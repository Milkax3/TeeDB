<?php

	require_once 'header.php';
	require_once 'item.php';
	require_once 'itemType.php';
	require_once 'info.php';
	require_once 'image.php';
	require_once 'group.php';
	require_once 'tileLayer.php';
	require_once 'quadLayer.php';
	require_once 'envpoint.php';
	require_once 'envelope.php';

	class MapReader{
		
		private $dir;
		private $name;
		
		private $file;
		private $header;
		private $info;	
		
		private $item_types;
		private $item_offsets;
		private $data_offsets;
		private $data_sizes;
		
		private $images;
		private $groups;
		private $envpoints;
		private $envelopes;
		
		function __construct(&$file){
			if(pathinfo($file, PATHINFO_EXTENSION) != 'map'){
				throw new Exception('Wrong fileextension. File must be a type of ".map".');
			}
			
			$this->name = pathinfo($file, PATHINFO_FILENAME);
			$this->dir = pathinfo($file, PATHINFO_DIRNAME);
			
			$this->file = fopen($file,'rb');
			$this->header = new Header($this->file);
			
			$this->load_item_types();
			$this->load_offsets_and_data_sizes();
			$this->check_version();
			
			//Get and set Info-items
			$this->info = new Info();
			
			if($item_info = $this->find_item(Item::INFO, 0)){
				$info = $item_info->unpack('iversion/iauthor/imap_version/icredits/ilicense/isettings');
				foreach($info as $key => $value){
					if($key == 'settings' && $value > -1){
						$data = gzuncompress($this->get_compressed_data($value)).split('\x00');
						$info[$key] = substr($data, 0, -1);
					}else if($key != 'version' && $value > -1){
						$info[$key] = $this->get_decompressed_data($value, TRUE);
					}
					//call_user_func('$this->info->set_'.$key, $value);
					call_user_func(array($this->info,'set_'.$key), $value);
				}
			}
			unset($item_info);
			unset($info);
			
			//Load images
			$this->images = array();
			$item_type_image = $this->get_item_type(Item::IMAGE);
			for($i=0; $i < $item_type_image->get_num(); $i++){
				$image = new Image($this->get_item($item_type_image->get_start() + $i));
				$image->set_name($this->get_decompressed_data($image->get_name(), TRUE));
				if(!$image->get_external()){
					$image->set_data($this->get_compressed_data($image->get_data()));
				}
				$this->images[] = $image;
			}
			unset($item_type_image);

			//load groups
			$this->groups = array();
			$item_type_group = $this->get_item_type(Item::GROUP);
			for($i=0; $i < $item_type_group->get_num(); $i++){
				$item = $this->get_item($item_type_group->get_start() + $i);
				$group = new Group($item);
				
				//load layers in group
				$item_type_layer = $this->get_item_type(Item::LAYER);
				for($j=0; $j < $group->get_num_layers(); $j++){
					$item_layer = $this->get_item($item_type_layer->get_start() + $group->get_start_layer() + $j);
					$item_layer_type = Layer::get_type_from_item($item_layer);
					
					//Title Layer
					if($item_layer_type == Layer::TYPE_TILE){
						$tile_layer = new TileLayer($item_layer);
						$tile_layer->set_data($this->get_decompressed_data($tile_layer->get_data()));
						$tile_layer->set_tiles();
						
						//Tele Layer
						if($tile_layer->get_game() == 2){							
							//num of tele data is right after the default type length
							if($item_layer->has_data()){
								$tele_data = implode($item_layer->unpack('i', 4));
								if($tele_data > -1 && $tele_data < $this->header->get_num_raw_data()){
									$tele_data = $this->get_decompressed_data($tele_data);
									$tile_layer->set_tele_tiles($tele_data);
								}
							}
								
						//Speedup Layer
						}else if($tile_layer->get_game() == 4){							
                            //num of speedup data is right after tele data
							if($item_layer->has_data()){
								$speedup_data = $item_layer->unpack('i2', 8);
								$speedup_data = $speedup_data[2];
								if($speedup_data > -1 && $speedup_data < $this->header->get_num_raw_data()){
									$speedup_data = $this->get_decompressed_data($speedup_data);
									$tile_layer->set_speedup_tiles($speedup_data);
								}
							}
						}
						
						$group->add_layer($tile_layer);
						
					}elseif($item_layer_type == Layer::TYPE_QUAD){
						$quad_layer = new QuadLayer($item_layer);
						$quad_layer->set_data($this->get_decompressed_data($quad_layer->get_data()));
						$quad_layer->set_quads();
						
						$group->add_layer($quad_layer);
					}
				}
				$this->groups[] = $group;
			}
			unset($item_type_group);
			
			//load envpoints
			$this->envpoints = array();
			if($item_envpoint = $this->find_item(Item::ENVPOINT, 0)){
				for($i=0; $i < $item_envpoint->get_size()/6; $i++){
					$this->envpoints[] = new Envpoint($item_envpoint);
				}
				unset($item_envpoint);
			}
			
			//load envelopes
			$this->envelopes = array();
			if($item_type_envelope = $this->get_item_type(Item::ENVELOPE)){
				for($i=0; $i < $item_type_envelope->get_num(); $i++){
					$item_envelope = $this->find_item(Item::ENVPOINT, 0);
					$envelope = new Envelope($item_envelope);
					$start_point = $envelope->get_start_point();
					$num_point = $envelope->get_num_point();
					$envelope->set_envpoint(array_slice($this->envpoints, $start_point, $num_point));
					
					$this->envelopes[] = $envelope;
				}
				unset($item_type_envelope);
			}
		}
		
		function __destruct(){
			if(isset($this->file)){
				fclose($this->file);
			}
		}
		
		/*
		 * Load item types from map file
		 * 
		 * Per item type we have:
		 * int Type
		 * int Start
		 * int Num
		 * Amount to load from map file = 3Ints * 4Bytes * #Types
		 */
		private function load_item_types(){
			//$this->item_types = new SplFixedArray($this->header->get_num_item_types());
			$this->item_types = array();
			
			$data = unpack('i*', fread($this->file, 12 * $this->header->get_num_item_types()));
			foreach(array_chunk($data, 3) as $item_type){
				$this->item_types[$item_type[0]] = new ItemType($item_type[0], $item_type[1], $item_type[2]);
			}
		}	
		
		private function get_item_type($type){
			if(isset($this->item_types[$type])){
				return $this->item_types[$type];
			}
		}
		
		/*
		 * Load offsets from map file
		 * 
		 * Offsets for items and raw data and data sizes for version 4
		 */
		private function load_offsets_and_data_sizes(){//Get Offsets
			$data = unpack('i*', fread($this->file, ($this->header->get_num_items() + $this->header->get_num_raw_data()) * 4));
			$this->item_offsets = array_slice($data, 0, $this->header->get_num_items());
			$this->data_offsets = array_slice($data, $this->header->get_num_items(), $this->header->get_num_raw_data());	
			
			//For version 4 get data sizes
			if($this->header->get_version() == 4){
				$this->data_sizes = unpack('i*', fread($this->file, $this->header->get_num_raw_data() * 4));
			}
		}
		
		private function check_version(){
			$item_version = $this->find_item(Item::VERSION, 0);
			if(isset($item_version)){
				$version = implode($item_version->unpack('i*'));
			}
			if(!isset($version) OR $version != 1){
				throw new Exception('Wrong Map-version. Version must be a value of 1');
			}
		}
		
		private function find_item($type, $index){
			$item_type = $this->get_item_type($type);
			
			if(isset($item_type) && $item_type->get_num() && $index < $item_type->get_num()){
				return $this->get_item($item_type->get_start() + $index);
			}
		}

		private function get_item($index){
			if($index < $this->header->get_num_items()){
				//+8 to cut out type_and_id and size
				fseek($this->file, $this->header->get_area() + $this->item_offsets[$index] + 8);
				$size = $this->get_item_size($index);
				if($size > 0){
					return new Item(fread($this->file, $size), $size);
				}
			}
		}
		
		private function get_item_size($index){
			if($index == $this->header->get_num_items()-1){
				return $this->header->get_item_size() - $this->item_offsets[$index] - 8;
			}
			return $this->item_offsets[$index + 1] - $this->item_offsets[$index] - 8;
		}
		
		private function get_compressed_data_size($index){
			if($index == $this->header->get_num_raw_data() - 1){
				return $this->header->get_data_size() - $this->data_offsets[$index];
			}
			return $this->data_offsets[$index + 1] - $this->data_offsets[$index];
		} 

		private function get_compressed_data($index){
			$size = $this->get_compressed_data_size($index);
			fseek($this->file, $this->header->get_area() + $this->header->get_item_size() + $this->data_offsets[$index]);
			return fread($this->file, $size);
		} 

		private function get_decompressed_data($index, $cut_last_byte = FALSE){
			$data = gzuncompress($this->get_compressed_data($index));
			if($cut_last_byte){
				$data = substr($data, 0, -1);
			}
			return $data;
		}
		
		/*
		 * Returns images used in map file
		 */
		public function get_images(){
			return $this->images;
		}
		
		public function get_groups(){
			return $this->groups;
		}
		
		public function get_name(){
			return $this->name;
		}
	}

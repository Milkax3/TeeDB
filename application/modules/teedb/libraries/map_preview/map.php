<?php

	include 'MapReader.php';
	include 'MapWriter.php';

	class Map{
		
		private $map;
		
		private $titlesize = 16;
		private $entitie = 'entities';
		
		function __construct($file=NULL){
			if(isset($file)){
				$this->map = new MapReader($file);
			}else{
				$this->map = new MapWriter();
			}
		}
		
		public function set_tile_size($size){
			if(is_int($size) && $size > 0)
				$this->tilesize = $size;
		}
		
		public function set_entitie($entitie){
			$this->entitie = $entitie;
		}
		
		public function save_images($path){
			$images = $this->map->get_images();
			foreach($images as $image){
				$image->save($path);
			}
		}
		
		public function get_image_names(){
			$names = array();
			$images = $this->map->get_images();
			foreach($images as $image){
				$names[] = $image->get_name();
			}
			return $names;
		}
		
		public function save_preview($path, $only_game_layer){
			echo '<br><br>Groups and Layers:';
			//var_dump($this->map->get_groups());
		}

		public function draw_gamelayer($path, $mod){
			foreach($this->map->get_groups() as $group){
				foreach($group->get_layers() as $layer){
					if($layer instanceof TileLayer && $layer->is_gamelayer()){
						$src = $layer->draw($path, $this->map->get_name(), $mod);
						echo 'Gamelayer generated:</br><img src="'.$src.'" alt="Gamelayer" width="30%" height="30%" /></br>';
					}
				}
			}
		}

		public function draw_layers($path, $mod){
			$image_names = array();
			$images = $this->map->get_images();
			foreach($images as $image){
				$image_names[$image->get_id()] = $image->get_name();
			}
			
			$width = 0;
			$height = 0;
			$previews = array();
			
			$sizes = array();
			$i=0;
			
			foreach($this->map->get_groups() as $group){
				foreach($group->get_layers() as $layer){
					if($layer instanceof TileLayer){						
						if($width < $layer->get_width()){
							$width = $layer->get_width();
						}
						if($height < $layer->get_height()){
							$height = $layer->get_height();
						}
						
						if(($layer->is_gamelayer())){
							$layer->draw($path, $this->map->get_name(), $mod);
						}else{
							$sizes[$i]['width'] = $layer->get_width();
							$sizes[$i]['height'] = $layer->get_height();
							$i++;
						
							$layer->set_image_name($image_names[$layer->get_image_id()]);
							$previews[] = $layer->draw($path, $this->map->get_name(), NULL);
						}
					}
				}
			}
			
			$image = imagecreatetruecolor($width*64, $height*64);
			imagealphablending($image, false);
			imagesavealpha($image, true);
			$trans_color = imagecolorallocatealpha($image, 255, 255, 255, 127);
			imagefill($image, 0, 0, $trans_color);
			$i=0;
			foreach($previews as $preview){
				$pre = imagecreatefrompng($preview);
				imagealphablending($pre, true);
				imagealphablending($image, true);
				imagecopy($image, $pre, 0, 0, 0, 0, $sizes[$i]['width']*64, $sizes[$i]['height']*64);
				imagealphablending($image, false);
				imagesavealpha($image, true);
				imagedestroy($pre);
				$i++;
			}
			$src_path = $path.'/'.$this->map->get_name().'_preview.png';
			imagepng($image, $src_path);
			imagedestroy($image);
			
			return $src_path;
		}
	}

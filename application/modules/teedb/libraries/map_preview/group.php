<?php
		
	class Group{
		
		private $name;
		private $offset_x;
		private $offset_y;
		private $parallax_x;
		private $parallax_y;
		private $use_clipping;
		private $clip_x;
		private $clip_y;
		private $clip_w;
		private $clip_h;
		
		private $layers;
		
		private $version;
		private $start_layer;
		private $num_layers;
		
		const TYPE_SIZE = 15; 
		
		function __construct(&$item){
			$version = implode($item->unpack('iversion', 4));
			$data = $item->unpack('ioffset_x/ioffset_y/iparallax_x/iparallax_y/istart_layer/inum_layers/iuse_clipping/iclip_x/iclip_y/iclip_w/iclip_h', 44);
			
			if($version >= 3){
				$data['name'] = implode($item->unpack('i3name', 12));
			}
			
			$data['version'] = $version;
			
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
			
			$this->layers = array();
		}
		
		public function get_name(){
			return $this->name;
		}
		
		public function get_num_layers(){
			return $this->num_layers;
		}
		
		public function get_start_layer(){
			return $this->start_layer;
		}
		
		public function add_layer($layer){
			$this->layers[] = $layer;
		}
		
		public function get_layers(){
			return $this->layers;
		}
	}
	

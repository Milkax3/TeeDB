<?php
		
	class Image{
		
		private $id;
		private $version;
		private $width;
		private $height;
		private $external;
		private $name;
		private $data;
		
		private static $next_id = 0;
		private static $type_size = 6;
		
		function __construct($item){
			$data = $item->unpack('iversion/iwidth/iheight/iexternal/iname/idata');
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
			$this->external = (bool) $this->external;
			$this->id = self::$next_id;
			self::$next_id++;
		}
		
		public function get_id(){
			return $this->id;
		}
		
		public function get_name(){
			return $this->name;
		}
		
		public function get_data(){
			return $this->data;
		}
		
		public function get_external(){
			return $this->external;
		}
		
		public function set_name($name){
			$this->name = $name;
		}
		
		public function set_data($data){
			$this->data = $data;
		}
		
		public function save($path){
			if($this->external){
				return;
			}
			if(!isset($this->data)){
				throw new Exception('No data given for the non external image '.$this->name);
			}
			
			$image = imagecreatetruecolor($this->width, $this->height);
			imagealphablending($image, false);
			imagesavealpha($image, true);
					
			$rgba = array();
			$rgba = unpack('C*', gzuncompress($this->data));
					
			//Fill
			$pos = 1;
			for($y=0; $y < $this->height; $y++){
				for($x=0; $x < $this->width; $x++){
					if(isset($rgba[$pos])){
						$alpha =  (int)(255 - $rgba[$pos+3]) >> 1;
						$col = imagecolorallocatealpha($image, $rgba[$pos], $rgba[$pos+1], $rgba[$pos+2], $alpha);
						$pos+=4;
					}else{
						$col = imagecolorallocatealpha($image, 0, 0, 0, 127);
					}
					
					imagesetpixel($image, $x, $y, $col);
				}
			}
			unset($rgba);

			imagepng($image, $path.'/'.$this->name.'.png');
			imagedestroy($image);
		}
	}
	

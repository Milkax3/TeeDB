<?php
	
	require_once 'layer.php';
	require_once 'quad.php';
	require_once 'quadManager.php';
		
	class QuadLayer extends Layer{
		
		private $version;
		private $num_quads;
		private $image_id;		
		
		private $data;
		
		private $quads;
		
		const TYPE_SIZE = 10;
		const FORMAT = 'iversion/inum_quads/idata/iimage_id'; 
		
		function __construct(&$item){
			parent::__construct($item, 'Quads');
			$data = $item->unpack('iversion/inum_quads/idata/iimage_id', 16);
			
			if($data['version'] >= 2){
				$data['name'] = implode($item->unpack('i3', 12));
			}else{
				$data['name'] = 'Quads';
			}
			
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
		}
		
		public function get_data(){
			return $this->data;
		}
		
		public function get_quads(){
			return $this->quads;
		}
		
		public function get_quad($index){
			return $this->quad[$index];
		}
		
		public function set_data($data){
			$this->data = $data;
		}
		
		public function set_quads(){
			//$this->quads = new QuadManager(str_split($this->data, 152));
						
			$this->quads = array();
			$raw_quads = str_split($this->data, 152);
			foreach($raw_quads as $raw_quad){
				$this->quads[] = QuadManager::string_to_quad($raw_quad);
			}
			unset($this->data);
		}
		
		public function to_image($path){
			$image = imagecreatetruecolor($this->width, $this->height);
			imagealphablending($image, false);
			imagesavealpha($image, true);
					
			$rgba = array();
			$rgba = unpack('C*', gzuncompress($this->data));
		}

		private function gradient($from, $to, $height, $steps, $step_width) {
		  $im = imagecreatetruecolor(++$steps * $step_width, $height);
		  imagesavealpha($im, true);
		  imagealphablending($im, false);
		  imagefill($im, 0, 0, imagecolorallocatealpha($im, 225, 225, 225, 127));
		  $from = explode(',', $from);
		  $to = explode(',', $to);
		  $diff = array();
		  for ($i = 0; $i < 4; $i++) {
		    $diff[$i] = ($from[$i] - $to[$i]) / $steps;
		  }
		  for ($step = 0; $step < $steps; $step++) {
		    for ($i = 0; $i < 4; $i++) {
		      $rgb[$i] = round($from[$i] - $diff[$i] * $step);
		      if ($i < 3) {
		        if ($rgb[$i] > 255) {
		          $rgb[$i] = 255;
		        }
		      } elseif ($rgb[3] > 127) {
		        $rgb[3] = 127;
		      }
		    }
		    $col = imagecolorallocatealpha($im, $rgb[0], $rgb[1], $rgb[2], $rgb[3]);
		    imagefilledrectangle($im, $step * $step_width, 0, ($step + 1) * $step_width - 1, $height, $col);
		  }
		  header('Content-type: image/png');
		  imagepng($im);
		  imagedestroy($im);
		}
	}
<?php
	
	require_once 'layer.php';
	require_once 'tile.php';
	require_once 'tileManager.php';
		
	class TileLayer extends Layer{
		
		private $version;
		private $width;
		private $height;
		private $game;
		private $color;
		private $color_env;
		private $color_env_offset;
		private $image_id;
		private $data;
		private $image_name;
		
		private $tiles;
		private $tele_tiles;
		private $speedup_tiles;
		
		private static $next_id = 0;
		
		const MOD_VANILLA = 0;
		const MOD_RACE = 1;
		const MOD_DDRACE = 2;
		
		//const FLAG_NORMAL1 = 0;
		const FLAG_FLIP_V = 1;
		const FLAG_FLIP_H = 2;
		//const FLAG_FLIP_VH = 3;
		const FLAG_OPAQUE = 4;
		const FLAG_ROTATE = 8;
		//const FLAG_FLIP_VHR = 11;
		
		const TYPE_SIZE = 18;
		const FORMAT = 'iversion/iwidth/iheight/igame/i4color/icolor_env/icolor_env_offset/iimage_id/idata';
		
		function __construct(&$item){
			parent::__construct($item, 'tileLayer'.self::$next_id);
			self::$next_id++;
			$data = $item->unpack('iversion/iwidth/iheight/igame/i4color/icolor_env/icolor_env_offset/iimage_id/idata', 48);
			
			if($data['version'] >= 3){
				$data['name'] = implode($item->unpack('i3', 12));
			}
			
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
		}
		
		public function get_data(){
			return $this->data;
		}
		
		public function get_game(){
			return $this->game;
		}
		
		public function get_version(){
			return $this->version;
		}
		
		public function get_image_id(){
			return $this->image_id;
		}
		
		public function get_width(){
			return $this->width;
		}
		
		public function get_height(){
			return $this->height;
		}
		
		public function set_data($data){
			$this->data = $data;
		}
		
		public function set_tiles(){
			$data = unpack('C*', $this->data);
			
			$this->tiles = array();
			for($i=1; $i < count($data); $i+=4){
				$tile = array();
				$tile['index'] = $data[$i];
				$tile['flags'] = $data[$i+1];
				$tile['skip'] = $data[$i+2];
				$tile['reserved'] = $data[$i+3];
				$this->tiles[] = $tile;
			}
			unset($this->data);
		}
		
		public function set_tele_tiles($data){
			$tile_data = unpack('C*', $data);
			
			$this->tele_tiles = array();
			for($i=1; $i < count($tile_data); $i+=2){
				$tile = array();
				$tile['number'] = $tile_data[$i];
				$tile['type'] = $tile_data[$i+1];
				$this->tele_tiles[] = $tile;
			}
			// $this->tele_tiles = new TileManager(str_split($data, 2), 1);
		}
		
		public function set_speedup_tiles($data){
			$this->speedup_tiles = array();
			
			while($tile_data = unpack('Cs', $data)){
				$tile['force'] = $tile_data[1];
				$tile['angle'] = $tile_data[2];
				$this->speedup_tiles[] = $tile;
			}
			// $this->speedup_tiles = new TileManager(str_split($data, 4), 2);
		}
		
		public function is_gamelayer(){
			return ($this->game == 1);
		}
		
		public function is_telelayer(){
			return ($this->game == 2);
		}
		
		public function is_speedlayer(){
			return ($this->game == 4);
		}
		
		public function set_image_name($name){
			$this->image_name = $name;
		}
		
		public function draw($path, $map_name, $mod = NULL){
			if($this->image_id < 0){
				switch($mod){
					case self::MOD_VANILLA:  $entities = 'res/entities_vanilla.png'; break;
					case self::MOD_RACE: $entities = 'res/entities_race.png'; break;
					case self::MOD_DDRACE: $entities = 'res/entities_ddrace.png'; break;
					default: $entities = 'res/entities.png'; break;
				}
			}else{
				$entities = 'upload/mapres/'.$this->image_name.'.png';
			}
				
			if($this->is_gamelayer()){
				$name = 'gamelayer';
			}else{
				$name = $this->name;
			}
			
			$tileset = imagecreatefrompng($entities);
			
			$image = imagecreatetruecolor($this->width*64, $this->height*64);
			imagealphablending($image, false);
			imagesavealpha($image, true);
			$trans_color = imagecolorallocatealpha($image, 255, 255, 255, 127);
			imagefill($image, 0, 0, $trans_color);
			
			//Fill
			$tile = 0;
			for($y=0; $y < $this->height; $y++){
				for($x=0; $x < $this->width; $x++){
					$pos_x = $x * 64;
					$pos_y = $y * 64;
					$tileset_col = ($this->tiles[$tile]['index'] % 16);
					$tileset_row = ($this->tiles[$tile]['index'] - $tileset_col) / 16;
					$tileset_col *= 64;
					$tileset_row *= 64;
					$width = 64;
					$height = 64;
					
					// if($name == 'tileLayer4'){
						// var_dump($this->tiles[$tile]);
					// }

					if($this->tiles[$tile]['flags'] & self::FLAG_FLIP_V != 0){
						for($i=0; $i < 64; $i++){
							imagecopy($image, $tileset, $pos_x+$i, $pos_y, $tileset_col+(63-$i), $tileset_row, 1, 64);
						}
					}elseif($this->tiles[$tile]['flags'] & self::FLAG_FLIP_H != 0){
						for($i=0; $i < 64; $i++){
							imagecopy($image, $tileset, $pos_x, $pos_y+$i, $tileset_col, $tileset_row+(63-$i), 64, 1);
						}
						exit();
					// }elseif($this->tiles[$tile]['flags'] == self::FLAG_FLIP_VH){
						// imagecopy($image, $tileset, $pos_x, $pos_y+$i, $tileset_col, $tileset_row+(64-$i), 64, 1);
					// }elseif($this->tiles[$tile]['flags'] == self::FLAG_FLIP_R){
						// imagecopy($image, $tileset, $pos_x, $pos_y+$i, $tileset_col, $tileset_row+(64-$i), 64, 1);
					// }elseif($this->tiles[$tile]['flags'] == self::FLAG_FLIP_VHR){
						// imagecopy($image, $tileset, $pos_x, $pos_y+$i, $tileset_col, $tileset_row+(64-$i), 64, 1);
					}else{
						imagecopy($image, $tileset, $pos_x, $pos_y, $tileset_col, $tileset_row, $width, $height);						
					}
					$tile++;
				}
			}
			
			imagedestroy($tileset);
			$src_path = $path.'/'.$map_name.'_'.$name.'.png';
			imagepng($image, $src_path);
			imagedestroy($image);
			
			return $src_path;
		}
	}
	

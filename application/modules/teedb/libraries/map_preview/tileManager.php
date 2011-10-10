<?php
	
	class TileManager{
		
		private $tiles;
		private $type;
		
		function __construct($tiles, $type=0){
			$this->tiles = $tiles;
			$this->type = $type;
			
			for($i=0; $i < count($this->tiles); $i++){
				$this->tiles[$i] = $this->tile_to_string(str_split($this->tiles[$i], 1));
			}
		}
		
		private function tile_to_string($tile){
			//index, flags, skip, reserved
			return pack('C4', $tile[0], $tile[1], $tile[2], $tile[3]);
		}
		
		private function string_to_tile($string){
			//index, flags, skip, reserved
			$data =  unpack('Cindex/Cflags/Cskip/Creserved', $string);
			return new Tile($data);
		}
	}
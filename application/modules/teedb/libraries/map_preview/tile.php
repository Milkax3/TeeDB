<?php
	
	class Tile{
		
		private $index;
		private $flags;
		private $skip;
		private $reserved;
		
		const FLAG_VFLIP = 1;
		const FLAG_HFLIP = 2;
		const FLAG_OPAQUE = 4;
		const FLAG_ROTATE = 8;
		
		function __construct($data){
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
		}
		
		public function vflip(){
			if($this->flags['rotation']){
				$this->flags ^= self::FLAG_HFLIP;
			}else{
				$this->flags ^= self::FLAG_VFLIP;
			}
		}
		
		public function hflip(){
			if($this->flags['rotation']){
				$this->flags ^= self::FLAG_VFLIP;
			}else{
				$this->flags ^= self::FLAG_HFLIP;
			}
		}
		
		/*
		 * Rotate the tile
		 * 
		 * @param direction Can be 'l' or 'r' for left and right
		 */
		public function rotate($direction){
			if($direction == 'r' OR $direction == 'right'){
				if($this->flags['rotation']){
					$this->flags ^= (self::FLAG_HFLIP|self::FLAG_VFLIP);
				}
				$this->flags ^= self::FLAG_ROTATE;
			}elseif($direction == 'l' OR $direction == 'left'){
				if($this->flags['rotation']){
					$this->flags ^= (self::FLAG_HFLIP|self::FLAG_VFLIP);
				}
				$this->flags ^= self::FLAG_ROTATE;
				$this->vflip();
				$this->hflip();
			}else{
				throw new Exception('Wrong argument for Tile rotation. You can only rotate (l)eft or (r)ight.');
			}
		}
		
		public function get_coords(){
			return array($this->index % 16, $this->index / 16);
		}
		
		/*
		 * Returns the Flags of the tile.
		 * 
		 * The flags contain the rotation, hflip and vflip information.
		 * 
		 * @return {'rotation': int, 'vflip': int, 'hflip': int}
		 */
		public function get_flags(){
			return array(
				'rotation' => $this->flags & self::FLAG_ROTATE != 0,
				'vflip' => $this->flags & self::FLAG_VFLIP != 0,
				'hflip' => $this->flags & self::FLAG_HFLIP != 0
			);
		}
	}
<?php
	/*
	 * Header
	 * Gets the header data from a map file
	 * 
	 * Char = 1 Byte
	 * Int = 4 Bytes
	 * 
	 * 4 Chars = 4 Bytes for map id
	 * 8 Ints = 8 * 4 Bytes = 32 Bytes for the other stuff, like version, size, swaplen,...
	 * Total amout of Bytes to read: 36
	 */
	class Header{
		
		private $id;
		private $version;
		private $size;
		private $swaplen;
		private $num_item_types;
		private $num_items;
		private $num_raw_data;
		private $item_size;
		private $data_size;
		
		private $area;
		

		function __construct(&$file){
			//Build header
			$format = 'a4id/iversion/isize/iswaplen/inum_item_types/inum_items/inum_raw_data/iitem_size/idata_size';
			$header_info = unpack($format, fread($file, 36));

			foreach($header_info as $key => $value){
				$this->{$key} = $value;
			}
			
			//Check Map Header
			if($this->id != 'ATAD' && $this->id != 'DATA'){
				throw new Exception('Wrong map signature. Header signature must be "ATAD" or "DATA".');
			}
			
			//Check Map Version
			if($this->version != 3 && $this->version != 4){
				throw new Exception('Wrong Header-version. Version must be a value of 3 or 4.');
			}
			
			//Header size
			$this->area = 36 + $this->num_item_types * 12 + $this->num_items * 4 + $this->num_raw_data * 8;
		}
		
		public function get_num_item_types(){
			return $this->num_item_types;
		}
		
		public function get_num_items(){
			return $this->num_items;
		}
		
		public function get_num_raw_data(){
			return $this->num_raw_data;
		}
		
		public function get_area(){
			return $this->area;
		}
		
		public function get_item_size(){
			return $this->item_size;
		}
		
		public function get_version(){
			return $this->version;
		}
		
		public function get_data_size(){
			return $this->data_size;
		}
		
	}

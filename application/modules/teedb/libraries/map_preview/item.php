<?php
		
	class Item{
		
		private $data;
		private $size;
		
		const VERSION = 0;
		const INFO = 1;
		const IMAGE = 2;
		const ENVELOPE = 3;
		const GROUP = 4;
		const LAYER = 5;
		const ENVPOINT = 6;
		
		function __construct($data, $size){
			$this->data = $data;
			$this->size = $size;
		}
		
		public function unpack($format, $length=0){
			if($this->has_data()){
				$data = unpack($format, $this->data);
				if($length > 0){
					$this->data = substr($this->data, $length);
				}
			}
			return $data;
		}
		
		public function has_data(){
			return strlen($this->data) > 0;
		}
		
		public function get_data(){
			return $this->data;
		}
		
		public function get_size(){
			return $this->size;
		}
		
		public function set_data($data){
			$this->data = $data;
		}
	}
	

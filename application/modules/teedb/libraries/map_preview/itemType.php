<?php
		
	class ItemType{
		
		private $type;
		private $start;
		private $num;
		
		function __construct($type, $start, $num){
			$this->type = $type;
			$this->start = $start;
			$this->num = $num;
		}
		
		public function get_type(){
			return $this->type;
		}
		
		public function get_num(){
			return $this->num;
		}
		
		public function get_start(){
			return $this->start;
		}
	}
	

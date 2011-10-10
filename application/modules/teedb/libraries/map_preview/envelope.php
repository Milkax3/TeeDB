<?php
		
	class Envelope{
		
		private $name;
		private $version;
		private $channels;
		private $envpoints;
		
		private $start_point;
		private $num_point;
		
		const TYPE_SIZE = 12;
		
		function __construct(&$item){			
			$data = $item->unpack('iversion/ichannels/istart_point/inum_point/i8name');

			$data['name'] = '';
			for($i=1; $i <= 8; $i++){
				$data['name'] .= $data['name'.$i];
				unset($data['name'.$i]);
			}
			
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
		}
		
		public function get_start_point(){
			return $this->start_point;
		}
		
		public function get_num_point(){
			return $this->num_point;
		}
		
		public function set_envpoint($points){
			$this->envpoints = $points;
		}
	}
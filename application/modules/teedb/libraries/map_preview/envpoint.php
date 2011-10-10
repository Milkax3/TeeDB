<?php
		
	class Envpoint{
		
		private $time;
		private $curvetype;
		private $values;
		
		const TYPE_SIZE = 6; 
		
		function __construct(&$item){			
			$data = $item->unpack('itime/icurvetype/i4value');
			
			$this->time = $data['time'];
			$this->curvetype = $data['curvetype'];
			$this->values = array($data['value1'], $data['value2'], $data['value3'], $data['value4']);
		}
	}
	

<?php
	
	class QuadManager{
		
		private $quads;
		
		function __construct($data){
			$this->quads = $data;
		}
		
		public static function string_to_quad($string){
			$data = unpack('i10point/i16color/i8texcoord/ipos_env/ipos_env_offset/icolor_env/icolor_env_offset', $string);
			
			$data['points'] = array();
			for($i=1; $i <= 10; $i+=2){
				$data['points'][] = array('x' => $data['point'.$i], 'y' => $data['point'.($i+1)]);
				unset($data['point'.$i]);
				unset($data['point'.($i+1)]);
			}		
				
			$data['colors'] = array();
			for($i=1; $i <= 16; $i+=4){
				$data['colors'][] = array('r' => $data['color'.$i], 'g' => $data['color'.($i+1)], 'b' => $data['color'.($i+2)], 'a' => $data['color'.($i+3)]);
				unset($data['color'.$i]);
				unset($data['color'.($i+1)]);
				unset($data['color'.($i+2)]);
				unset($data['color'.($i+3)]);
			}	
				
			$data['texcoords'] = array();
			for($i=1; $i <= 8; $i+=2){
				$data['texcoords'][] = array('x' => $data['texcoord'.$i], 'y' => $data['texcoord'.($i+1)]);
				unset($data['texcoord'.$i]);
				unset($data['texcoord'.($i+1)]);
			}
			
			return new Quad($data);
		}
	}
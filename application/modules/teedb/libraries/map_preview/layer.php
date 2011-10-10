<?php
		
	abstract class Layer{
		
		protected $layer_version;
		protected $type;
		protected $flags;
		protected $detail;
		
		protected $name;
		
		const TYPE_INVALID = 0;
		const TYPE_GAME = 1;
		const TYPE_TILE = 2;
		const TYPE_QUAD = 3;
		
		const FLAG_DETAIL = 1;
		
		const TYPE_SIZE = 3;
		const FORMAT = 'ilayer_version/itype/iflags';
		
		function __construct(&$item, $name){
			$data = $item->unpack('ilayer_version/itype/iflags', 12);
			$data['detail'] = ($data['flags'] == true);
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
			$this->name = $name;
		}
		
		public function get_type(){
			return $this->type;
		}
		
		public static function get_type_from_item($item){
			$data = $item->unpack('ilayer_version/itype');
			return $data['type'];
		}
	}
	

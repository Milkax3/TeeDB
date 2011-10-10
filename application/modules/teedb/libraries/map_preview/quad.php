<?php
		
	class Quad{
		
		private $pos_env;
		private $pos_env_offset;
		private $color_env;
		private $color_env_offset;
		private $points;
		private $colors;
		private $texcoords;
		
		const TYPE_SIZE = 38;
		
		function __construct($data){
			foreach($data as $key => $value){
				$this->{$key} = $value;
			}
		}
		
	}
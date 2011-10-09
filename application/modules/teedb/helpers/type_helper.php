<?php 
if ( ! function_exists('checkDBTypes'))
{
	function checkDBTypes($type){
		if(!is_string($type))
			return FALSE;
			
		switch($type){
			case "skin":
			case "demo":
			case "mapres":
			case "gameskin":
			case "map":
			case "mod":
				break;
			default: return FALSE;
		}
		
		return TRUE;
	}
}

if ( ! function_exists('checkCommentTypes'))
{
	function checkCommentTypes($type){
		if(!is_string($type))
			return FALSE;
			
		switch($type){
			case "skin":
			case "demo":
			case "mapres":
			case "gameskin":
			case "map":
			case "mod":
			case "news":
			case "user":
				break;
			default: return FALSE;
		}
		
		return TRUE;
	}
}

if ( ! function_exists('getSize'))
{
	function getSize($type, $name){
		if(!checkDBTypes($type))
			return FALSE;
			
		$file = 'upload/skins/'.$name.'.png';
		if(is_file($file)){
			$size = filesize($file);
		}else{
			$size = 0;
		}
		if($size > 0)
			return number_format(($size/1000),2).' kB';
		else
			return '0 kB';
	}
}
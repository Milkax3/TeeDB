<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('rateFormat'))
{
	function rateFormat($sum, $count){
		if($count == 0)
			return '0.00';
		else
			return number_format($sum/$count,2);
	}
}
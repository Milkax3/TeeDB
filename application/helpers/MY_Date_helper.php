<?php 
if ( ! function_exists('datetime_to_human'))
{
	function datetime_to_human($datetime, $format="M j Y G:i"){
		if(!$time = human_to_unix($datetime))
			$time = $datetime;
		if($time >= time()-86400) //24h
			return '<b>Today</b> '.date("G:i", $time);
		elseif($time >= time()-172800) //48h
			return '<b>Yesterday</b> '.date("G:i", $time);
		else
			return date($format, $time);
	}
}

if ( ! function_exists('timediff_to_now'))
{
  function timediff_to_now($time){
    $diff = human_to_unix($time)-time(); //Sec
    $str = 'Secundes';
    $after = '';
    
    if($diff<0){
      $diff = $diff * -1;
      $after = ' ago';
    } 
    
    if($diff > 60){
      $diff = $diff / 60; //Min
      $str = 'Minutes';
    }
    if($diff > 60){
      $diff = $diff / 60; //Hours
      $str = 'Hours';
    }
    if($diff > 24){
      $diff = $diff / 24; //Days
      $str = 'Days';
    }
      
    return floor($diff).' '.$str.$after;
  }
}
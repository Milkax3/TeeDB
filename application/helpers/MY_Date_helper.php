<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('relative_time'))
{
    function relative_time($datetime)
    {
        $CI =& get_instance();
        $CI->lang->load('date');
        
        if(!is_numeric($datetime))
        {
            $val = explode(" ",$datetime);
           $date = explode("-",$val[0]);
           $time = explode(":",$val[1]);
           $datetime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
        }
        
        $difference = time() - $datetime;
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        if ($difference > 0) 
        { 
            $ending = $CI->lang->line('date_ago');
        } 
        else 
        { 
            $difference = -$difference;
            $ending = $CI->lang->line('date_to_go');
        }
        for($j = 0; $difference >= $lengths[$j]; $j++)
        {
            $difference /= $lengths[$j];
        } 
        $difference = round($difference);
        
        if($difference != 1) 
        { 
            $period = strtolower($CI->lang->line('date_'.$periods[$j].'s'));
        } else {
            $period = strtolower($CI->lang->line('date_'.$periods[$j]));
        }
        
        return "$difference $period $ending";
    }
} 



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
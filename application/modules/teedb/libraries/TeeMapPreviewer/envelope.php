<?php

include_once 'constants.php';

class Envelope {
  static public $size = 56;
  private $version, $channels, $start_points, $item, $num_points;
  
  function __constructor($item){
    $tmpItemInfo = array();
    for($i=2; $i<=6; $i++)
      $tmpItemInfo[] = $item->info[$i];  
      
    list(
      $this->version, $this->channels, $this->start_points,
      $this->num_points
    ) = $tmpItemInfo;
    
    $this->item = item;
  }
  
  function inits_to_string($num){
    $string = '';
    for($i=0; $i <= count($num); $i++){
      $string .= chr((($num[$i]>>24)&0xff)-128);
      $string .= chr((($num[$i]>>16)&0xff)-128);
      $string .= chr((($num[$i]>>8)&0xff)-128);
      if($i < 7){
        $string .= chr(($num[$i]&0xff)-128);
      }
    }
    return $string;
  }
  
  function string_to_ints(){
    $ints = array();
    for($i=0; $i <= 8; $i++){
      $string = '';
      for($j=$i*4; $j <= $i*4+4; $j++){
        if($j < count($this->name))
          $string .= $this->name[$j];
        else
          $string .= chr(0);
      }
      $ints[] = ((ord($string[0])+128)<<24)|((ord($string[1])+128)<<16)|((ord($string[2])+128)<<8)|(ord($string[3])+128);
    }
    $ints[-1] &= 0xffffff00;
    return $ints;
  }
  
  function itemdata(){
    return array(self::$size-8, 1, $this->channels, $this->start_point, $this->num_points);
  }
  
  function show(){
    echo '<Envelope>';    
  }
}
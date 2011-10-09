<?php

include_once 'constants.php';

class Group{
  static public $size = 56;
  private $version, $offset_x, $offset_y, $parallax_x, $parallax_y, $start_layer, $num_layers, 
          $use_clipping, $clip_x, $clip_y, $clip_w, $clip_h;
  public $layers;
  
  function __constructor($item=NULL){
    if($item === NULL){
      $info = array(2, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0);
    }else{      
      $info = array();
      for($i=2; $i<=count($item->info); $i++)
        $info[] = $item->info[$i];
    }
    list(
      $this->version, $this->offset_x, $this->offset_y, $this->parallax_x, $this->parallax_y,
      $this->start_layer, $this->num_layers, $this->use_clipping, $this->clip_x, $this->clip_y,
      $this->clip_w, $this->clip_h
    ) = $info;
    $this->layers = array();
  }
  
  function itemdata(){
    return array(self::$size-8, 2, $this->offset_x, $this->offset_y,
                $this->parallax_x, $this->parallax_y, $this->start_layer,
                count($this->layers), $this->use_clipping, $this->clip_x, $this->clip_y,
                $this->clip_w, $this->clip_h);
  }
  
  function default_background(){
    $this->parallax_x = 0;
    $this->parallax_y = 0;
  }
  
  function show(){
    echo '<Group>';    
  }
}
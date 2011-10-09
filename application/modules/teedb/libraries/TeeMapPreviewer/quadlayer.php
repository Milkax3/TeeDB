<?php

include_once 'constants.php';

class QuadLayer{
  static public $size = 36;
  private $quads;
  
  function __constructor($item=NULL, $image=NULL){
    $this->quads = array();
    
    if($item == NULL){
      $info = array(3, 0, -1, -1);
      $this->type = 3;
      $this->flags = 0;
    }else{
      $info = array();
      for($i=5; $i<=count($item->info); $i++)
        $info[] = $item->info[$i];  
      $this->__constructor($item);
      
      $i=0;    
      $this->quads = array();
      while($i < count($item->data)){    
        for($j=$i; $j<$i+38; $j++)
          $this->quads[] = $item->info[$i];
        $i += 38;
      }
    }
    list($this->version, $this->num_quads, $this->data, $this->image) = $info;  
  }
  
  function itemdata(){
    return array(self::$size-8, 1, $this->type, $this->flags, 1, count($this->quads, $this->data, $this->image));
  }
  
  function get_ata($id){
    $this->data = $id;
    $data = array();
    foreach($this->quads as $quad){
      foreach($quad->point as $point){
        $points[] = (array($point['x'], $point['y']));
      }
      foreach($quad->colors as $color){
        $colors[] = (array($color['r'], $color['g'], $color['b'], $color['a']));
      }
      foreach($quad->texcoords as $texcoord){
        $texcoords[] = (array($texcoord['x'], $texcoord['y']));
      }
      for($i=0; $i < count($this->quads); $i++){
        $data[] = array($points[$i], $colors[$i], $texcoords[$i], $quad->pos_env, $quad->pos_env_offset, $quad->color_env, $quad->color_env_offset);
      }
    }
    return $data;
  }
  
  function add_background_quad(){
    $with = 800000;
    $height = 600000;
    $points = array(-$width, -$height, $width, -$height, -$width, $height, $width, $height, 32, 32);
    $colors = array(94, 132, 174, 255, 94, 132, 174, 255, 204, 232, 255, 255, 204, 232, 255, 255);
    $this->quads[] = new Quad($points, $colors);
  }
  
  function show(){
    echo '<Quad layer>';    
  }
}
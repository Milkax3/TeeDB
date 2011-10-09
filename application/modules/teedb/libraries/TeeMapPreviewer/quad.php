<?php

include_once 'constants.php';

class Quad {
  
  private $points, $color, $texcoords, $pos_env, $pos_env_offset, $color_env, $color_env_offset;
  
  function Quad($points=NULL, $colors=NULL, $texcoords=NULL, $pos_env=-1, $pos_env_offset=0, $color_env=-1, $color_env_offset=0){
    $this->__constructor($points, $colors, $texcoords, $pos_env, $pos_env_offset, $color_env, $color_env_offset);
  }
  
  function __constructor($points=NULL, $colors=NULL, $texcoords=NULL, $pos_env=-1, $pos_env_offset=0, $color_env=-1, $color_env_offset=0){
    $this->points = array();
    
    if($points){
      for($i=0; $i<=5; $i++){
        $this->points[] = array('x' => $points[$i*2], 'y' => $points[$i*2+1]);
      }
      $points = array();
    }else{
      for($i=0; $i<=5; $i++){
        $this->points[] = array('x' => 0, 'y' => 0);
      }      
    }
    
    $this->color = array();
    if($colors){
      for($i=0; $i<=4; $i++){
        $this->colors[] = array('r' => $colors[$i*4], 'g' => $colors[$i*4+1], 'b' => $colors[$i*4+2], 'a' => $colors[$i*4+3]);
      }   
      $colors = array();
    }else{
      for($i=0; $i<=4; $i++){
        $this->colors[] = array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 255);
      }         
    }
    
    $this->texcoords = array();
    if($texcoords){
      for($i=0; $i<=4; $i++){
        $this->texcoords[] = array('x' => $texcoords[$i*2], 'y' => $texcoords[$i*2+1]);
      }
      $texcoords = array();
    }else{
      $this->texcoords[] = array('x' => 0, 'y' => 0);
      $this->texcoords[] = array('x' => 1024, 'y' => 0);
      $this->texcoords[] = array('x' => 0, 'y' => 1024);
      $this->texcoords[] = array('x' => 1024, 'y' => 1024);
    }
    $this->pos_env = $pos_env;
    $this->pos_env_offset = $pos_env_offset;
    $this->color_env = $color_env;
    $this->color_env_offset = $color_env_offset;
  }

  public function show(){
    echo '<Quad '.$this->pos_env.' '.$this->color_env.'>';
  }
}
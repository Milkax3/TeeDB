<?php

include_once 'constants.php';

class Tile {
  
  private $index, $flags, $skip, $reserved, $layerimage;
  
  function Tile(){
    $this->__constructor();
  }
  
  function __constructor($index=0, $flags=0, $skip=0, $reserved=0, $image=NULL){
    $this->index = $index;
    $this->flags = $flags;
    $this->skip = $skip;
    $this->reserved = $reserved;
    $this->layerimage = $image;    
  }
  
  //TODO: Teilweise sehr stumpf und unnötig! Überarbeiten!!! zB.: $a |= 1 => $a ist tautologie
  function vflip($value=NULL){
    //getter
    if($value === NULL)
      return $this->flags & 1 != 0;
      
    //setter
    elseif($value === FALSE){
      if($this->vflip())
        $this->flags ^= 1; //Invertiert
    }else{
      $this->flags |= 1;
    }
  } 
  
  function hflip($value=NULL){
    //getter
    if($value === NULL)
      return $this->flags & 2 != 0;
      
    //setter
    elseif($value === FALSE){
      if($this->vhflip())
        $this->flags ^= 2;
    }else{
      $this->flags |= 2;
    }
  }
  
  function image(){
    if($this->layerimage != NULL){
      if($this->layerimage == 'gamelayer'){
        $img = @imagecreatefrompng(GAMELAYER_IMAGE);
        $x = $this->index % 16 * 64;
        $y = $this->index / 16 * 64;
        $image = imagecreatetruecolor(64, 64);
        imagealphablending($im, false);
        imagecopy($image, $img, 0, 0, $x, $y, 64, 64);
      }else{
        $image = $this->layerimage->get_shape($this->index);
      }
      if($this->hflip){
        $image = imagerotate($image, 1, 0);
      }
      if($this->vflip){
        $image = imagerotate($image, 0, 0);
      }
      return $image;
    }
    return NULL;
  }
  
  function show(){
    echo '<Tile '.$this->index.'>';    
  }
  
}
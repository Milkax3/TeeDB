<?php

include_once 'constants.php';


class TileLayer{
  static public $size = 68;
  private $images, $tiles, $type, $flags;
  
  function __constructor($item=NULL, $images=NULL, $game=0, $width=50, $height=50){
    $this->images = $images;
    $this->tiles = array();
    
    if($item == NULL){
      $info = array(2, $width, $height, $game, 255, 255, 255, 255, -1, 0, -1, -1);
      $this->type = 2;
      $this->flags = 0;
      
      for($i=0; $i<$width*$height; $i++){
        $this->tiles[] = new Tile();
      }
    }else{
      for($i=5; $i<count($item->info); $i++){
        $info[] = $item->info[$i];
      }
      $this->TileLayer($item);
      $i=0;
      $this->game = $info[3];
      $this->image = $info[-2];
      while($i < count($item->data)){
        $datas = array();
        for($j=$i; $i<$i+4; $j++){
          $datas[] = $item->data[$i];
        }
        $this->tiles[] = new Tile($datas, $this->image);
        $i+=4;
      }
    }
    $this->color = array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0);
    list(
      $this->version, $this->width, $this->height, $this->game, $this->color['r'],
        $this->color['g'], $this->color['b'], $this->color['a'], $this->color_env,
        $this->color_env_offset, $this->_image, $this->_data
    ) = $info;
  }

  function width($value=NULL){
    //getter
    if($value === NULL){
      return $this->width;
    }
    //setter
    elseif($value){
      if(isset($this->width)){
        $diff = $value - $this->width;
        $tiles = array();
        for($i=0; $i<$this->height; $i++){
          $start = $i * $this->width;
          if($diff > 0){
            $end = $i * $this->width + $this->width;
            for($j=$start; $j<$end; $j++){
              $tiles[] = $this->tiles[$j];
            }
            for($j=$i; $j<$diff; $j++){
              $tiles[] = new Tile();
            }
          }elseif($diff < 0){
            $end = $i*$this->width + $this->width + $diff;
            for($j=$start; $j<$end; $j++){
              $tiles[] = $this->tiles[$j];
            }          
          }
        }
        $this->tiles = $tiles;     
      }
    }
    $this->width = $value;
  }
  
  function height($value=NULL){
    //getter
    if($value === NULL){
      return $this->height;
    }
    //setter
    elseif($value){
      if(isset($this->height)){
        $diff = $value - $this->height;
        if($diff > 0){
            for($i=0; $i<$this->width; $i++){
              $this->tiles[] = new Tile();
            }
        }elseif($diff < 0){
            for($i=0; $i<$diff * $this->width; $i++){
              $this->tiles[] = $this->tiles[$i];
            }
        }
      }
      $this->height = $value;
    }
  }
  
  function is_gamelayer(){
    return $this->game == 1;
  }
  
  function itemdata(){
    return array(self::$size-8, 0, $this->type, $this->flags, 2, $this->width,
                $this->height, $this->game, $this->color['r'], $this->color['g'],
                $this->color['b'], $this->color['a'], $this->color_env,
                $this->color_env_offset, $this->_image, $this->_data);
  }
  
  function image(){
    if($this->is_gamelayer){
      return 'gamelayer';
    }
    return ($this->image != -1)? $this->images[$this->image] : NULL;
  }
  
  function render(){
    $im = imagecreatetruecolor($this->width*64, $this->height*64);
    for($h=0; $h<$this->height; $h++){
      for($w=0; $w<$this->width; $w++){
        $tile = $this->tiles[$w+$h*$this->width];
        //$region = array($w*64, $h*64, $w*64+64, $h*64+64);
        //TODO: crazy where to x/y coords for paste or getImg
        imagecopymerge($im,$tile->image,$w*64, $h*64,$w*64,$h*64,64, 64);
      }      
    }
    return $im;
  }
  
  function get_data($id){
    $this->data = $id;
    $data = array();
    
    foreach($this->tiles as $tile){
      $data[] = array($tile->index, $tile->flags, $tile->skip, $tile->reserved);
    }
    return $data;
  }
  
  function show(){
    echo '<Tile layer ('.$this->width.'x'.$this->height.')>';    
  }
}
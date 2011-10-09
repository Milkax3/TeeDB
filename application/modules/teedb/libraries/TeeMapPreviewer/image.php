<?php

include_once 'constants.php';

class Image{
  static public $size = 32;
  private $version, $wiht, $height, $external, $image_name, $image_data, $name, $image, $data;
  
  function __constructor(){
    $tmpItemInfo = array();
    for($i=2; $i<=count($item->info); $i++)
      $tmpItemInfo[] = $item->info[$i];      
    list(
      $this->version, $this->width, $this->height, $this->external,
      $this->image_name, $this->image_data
    ) = $tmpItemInfo;
    
    $this->name = $item->name;
    $this->image = (!$this->external)? $item->data : NULL;
    
    if($this->external){
      $path = './upload/mapres/'.$this->name.'.png';
      $this->image = @imagecreatefrompng($path);
    }else{
      $this->image = @imagecreatefrompng('./upload/mapres/grass_main.png');
    }
  }
  
  function get_shape($index){
    $x = $index % 16 * 64;
    $y = $inex / 16 * 64;
    $image = imagecreatetruecolor(64, 64);
    imagealphablending($im, false);
    imagecopy($image, $this->image, 0, 0, $x, $y, 64, 64);
    return $image;
  }
  
  function save(){
    //TODO
    if(!@imagepng($this->image, '.upload/maps/previews/'.$this->name.'.png'));
      return FALSE;
    return TRUE;
  }
  
  function itemdata(){
    return array(self::$size, 1, $this->width, $this->height, $this->external, $this->image_name, $this->image_data);
  }
  
  function get_data($id){
    $name = $this->name;
    $this->image_name = $id;
    
    if($this->image){
      $k = array();
      foreach($this->image as $i){
        foreach($i as $j){
          $k[] = $j;
        }
      }
      $image_data = implode($k);
      $this->image_data = $id + 1;
      return array($name, $image_data);
    }
    return array($name);
  }
  
  function show(){
    echo '<Image '.$this->name.'>';    
  }
}
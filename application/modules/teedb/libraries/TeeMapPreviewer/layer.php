<?php

include_once 'constants.php';

class Layer{
  private $version, $tpye, $flags, $item;
  
  function __constructor($item){
    $this->version = $item->info[2];
    $this->type = $item->info[3];
    $this->flags = $item->info[4];
    $this->item = $item;
  }
  
  function is_gamelayer(){
    return FALSE;
  }
}
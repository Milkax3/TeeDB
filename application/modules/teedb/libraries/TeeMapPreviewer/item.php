<?php

include_once 'constants.php';

class Item {
  
  private $info, $data, $name;
  public $type;
  
  function Item($type_num){
    $this->__constructor($type_num);
  }
  
  function __constructor($type_num){
    $this->type = $ITEM_TYPES[$type_num];
  }
  
  public function load($info, $data){
    $this->info = str_split(current(unpack('H*', $info)),2);
    
    if($this->type == 'layer'){
      if($LAYER_TYPES[$this->info[3]] == 'tile'){
        $data = trim($data[$this->info[-1]]); 
        $this->data = str_split(current(unpack('H*', $data)),2);
      }elseif($LAYER_TYPES[$this->info[3]] == 'quad'){
        $data = trim($data[$this->info[-2]]); 
        $this->data = str_split(current(unpack('H*', $data)),2);
      }     
    //Load image data 
    }elseif($this->type == 'image'){
      $name = trim($data[$this->info[-2]]);
      $this->name = '';
      
      $chars = str_split(current(unpack('H*', $name)),2);
      foreach($chars as $char){
        if($char == '\x00')
          break;
        $this->name += $char;
      }
      
      if(!$this->info[5]){
        $data = trim($data[$this->info[-1]]);
        $data = str_split(current(unpack('H*', $data)),2);
        $this->data = array();
        
        for($i=0; $i <= $this->info[4]; $i++){
          for($j = $i*$this->info[3]*4; $j < ($this->info[3]*4)+($i*$this->info[3]*4); $j++){
            $this->data[] = $data[$j];
          }
        }
      }
    }
  }
}
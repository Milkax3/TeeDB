<?php

include_once 'constants.php';

class Envpoint {
  public $time, $curvetype, $values;
  
  function __constructor($info){
    $this->time = $info[0];
    $this->curvetype = $info[1];
    $this->values = array();
    for($i=2; $i<=count($info); $i++)
      $this->values[] = $info[$i];  
  }
  
  function show(){
    echo '<Envpoint>';    
  }
}
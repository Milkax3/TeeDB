<?php

include_once 'constants.php';

class Version{
  
  public $item, $size = 12;
  
  function __constructor($item){
    $this->item = $item;    
  }
}

/*
 * class Version(object):

    size = 12

    def __init__(self, item):
        self.item = item
 */
  
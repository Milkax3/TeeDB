<?php

include_once 'constants.php';

class Header {
  
  private $name, $sig, $teemap;
  private $version, $swaplen;
  public $num_items, $num_item_types, $num_raw_data, $size, $item_size, $data_size;
  
  //PHP V.4
  public function Header($teemap, $mapfile){
    __construct($teemap, $mapfile);
  }
  
  public function __construct($teemap, $mapfile=NULL){
    $this->teemap = $teemap;
    $this->version = 4;
    $this->size = 0;
    
    if($mapfile !== NULL){
      $file = fopen($mapfile,'rb');
      
      $this->size = 0;    
      $this->checkSignature($file);   
      
      $this->name = basename($mapfile,'.map');
      
      list(
        $this->version, $this->size, $this->swaplen, $this->num_item_types, 
        $this->num_items, $this->num_raw_data, $this->item_size, $this->data_size
      ) = str_split(current(unpack('H*', fread($file,32))),2);
      
      $this->version = (int) $this->version;
      $this->size = (int) $this->size;
      $this->swaplen = (int) $this->swaplen;
      $this->num_item_types = (int) $this->num_item_types;
      $this->num_items = (int) $this->num_items;
      $this->num_raw_data = (int) $this->num_raw_data;
      $this->item_size = (int) $this->item_size;
      $this->data_size = (int) $this->data_size;
      
      $this->checkVersion($file);
      
      if($this->size > 0){
        $this->size += $this->num_item_types * 12; //TODO: 12 = DATAFILE_ITEM_TYPE vs 3
        $this->size += ($this->num_items + $this->num_raw_data) * 4;//32-bit system
        if($this->version == 4)
          $this->size += $this->num_raw_data * 4;
        $this->size += $this->item_size;
        $this->size += 36;
      }
      fclose($file);
    }
  }
  
  /**
   * Signature of a tw map file: DATA or ATAD at the beginning
   */
  private function checkSignature(&$file){
    $this->sig = fread($file, 4);
    if($this->sig != 'DATA' && $this->sig != 'ATAD'){
      throw new Exception('Wrong signature: <'.$this->sig.'>');
      return FALSE;
    }
    return TRUE;
  } 
  
  /*
   * Version des Maptypen, bisher 3 und 4 unterstï¿½tzt
   * Beachten: nicht verwechseln mit der mapversion (mapeditverison)
   */
  private function checkVersion(){
    if($this->version != 3 && $this->version != 4){
      throw new Exception('Wrong version: <'.$this->version.'>');
      return FALSE;
    }
    return TRUE;
  }
}
<?php //if (!defined('BASEPATH')) exit('No direct script access allowed'); 

include_once 'constants.php';

/**
 * Translatetion from python project tml by sushi and erdbeere
 * Under GNU,GPL license
 */

class TeeMap {
  
  private $header, $item_types, $item_offsets, $data_offsets, $compressed_data, $layers;
  public $envelopes, $envpoints, $groups, $images, $name;
  
  //PHP V.4
  public function TeeMap(){
    __construct();
  }
  
  public function __construct(){
    global $ITEM_TYPES;
    global $LAYER_TYPES;
    
    $this->name = '';
    $this->header = new Header($this);

    # default list of item types
    foreach($ITEM_TYPES as $type){
      if($type != 'layer'){
        $methode = $tpye.'s';
        $this->$methode = array();
      }
    }
    
    $this->create_default();
  }
     
  public function load($mapfile){ 
    global $ITEM_TYPES;
    global $LAYER_TYPES;
      
    $file = fopen($mapfile,'rb');
    
    $this->header = new Header($this, $mapfile);
    var_dump($this->header);
    
    //default list of item types
    foreach($ITEM_TYPES as $type){
      if($type != 'layer'){
        $typeTmp = $type.'s';
        $this->$typeTmp = array();
      }
    }
    
    $this->item_types = array();
    for($i=0; $i <= $this->header->num_item_types; $i++){
      $val = str_split(implode('',unpack('H*', fread($file,12))),2);
      $this->item_types[] = array('type' => $val[0], 'start' => $val[1], 'num' => $val[2]);
    }
    
    $this->item_offsets = str_split(current(unpack('H*', fread($file, $this->header->num_items * 4))),2);
    for($i=0; $i<count($this->item_offsets); $i++)
      $this->item_offsets[$i] = (int) $this->item_offsets[$i];
    $this->data_offsets = str_split(current(unpack('H*', fread($file, $this->header->num_raw_data * 4))),2);
    for($i=0; $i<count($this->data_offsets); $i++)
      $this->data_offsets[$i] = (int) $this->data_offsets[$i];
            
    $data_start_offset = $this->header->size;
    $item_start_offset = $this->header->size - $this->header->item_size;
    
    $this->compressed_data = array();
    fseek($file, $data_start_offset);
    foreach($this->data_offsets as $offset){ 
      $offset += $this->header->data_size;
      if($offset - $last_offset > 0){ //TODO: if($offset > 0){ 
        $this->compressed_data[] = fread($file, $offset - $last_offset);
      }
      $last_offset = $offset;
    }
    
    //Calculate with the offsets and the whole item size the size of each item
    $sizes = array();
    foreach($this->item_offsets as $offset){
      $offset += $this->header->item_size;
      if($offset > 0)
        $sizes[] = $offset - $last_offset;
      $last_offset = $offset;
    }
    fseek($file, $item_start_offset);
    $itemlist = array();
    foreach($this->item_types as $item_type){
      for($i = 0;  $i <= $item_type['num']; $i++){
        $size = $sizes[$item_type['start'] + $i];
        $item = new Item($item_type['type']);
        //TODO:
        if($size > 0)
          $item->load(fread($file, $size), $this->compressed_data);
        $itemlist[] = $item;
      }      
    }
    
    //order the items
    foreach($ITEM_TYPES as $type){
      //envpoints and layers will be handled separately
      if($type != 'envpoint' && $type != 'layer'){
        $name = $type.'s';
        //$methode = ucfirst($name);
        
        $tmp = array();
        foreach($itemlist as $item){
          if($item->type == $type)
            $tmp[] = new Version($item);
        }
        $this->$name = $tmp;
      }
    }
    
    // handle envpoints and layers
    $this->envpoints = array();
    $layers = array();
    
    foreach($itemlist as $item){
      //divide the envpoints item into the single envpoints
      if($item->type == 'envpoint'){
        for($i=0; $i <= ((count($item.info)-2)/6); $i++){
          for($j=2+($i*6); $j < (2+($i*6+6)); $j++){
            $info = $item->info[$j];
          }
          $this->envpoints[] = $items->Envpoint($info);
        }
      }elseif($item->type == 'layer'){
        $layer = $items.Layer($item);
        $layerclass = $LAYER_TYPES[$layer->type]->title().'Layer';
        $class_ = $item->$layerclass;
        $layers[] = $class_($item, $this->images);
      }
    }
    
    //assign layers to groups
    foreach($this->groups as $group){
      $start = $group->start_layer;
      $end = $group->start_layer + $group->num_layers;
      
      $group->layers = array();
      foreach($layers as $key => $layer){
        if($key >= $start && $key < $end)
          $group->layers[] = $layer;
      }
    }
    
    fclose($file);
  }

  function create_default(){
    $this->groups = array();
    $background_group = new Group();
    $this->groups[] = $background_group;
    $background_group->default_background();
    $background_layer = new QuadLayer();
    $background_layer->add_background_quad();
    $background_group->layers[] = $background_layer;
    $game_group = new Group();
    $this->groups[] = $game_group;
    $game_layer = new TileLayer(NULL, NULL, 1);
    $game_group->layers[] = $game_layer;    
  }
  
  function layers(){
    $layers = array();
    foreach($this->groups as $group){
      $layers[] = $group->layers;
    }
    return $layers;
  }
  
  function gamelayer(){
    foreach($this->layers as $layer){
      if($layer->is_gamelayer)
        return $layer;
    }
  }
  
  function width(){
    return $this->gamelayer->width;
  }
  
  function height(){
    return $this->gamelayer->height;
  }
  
  function _render_on_top($img1, $img2){
    $region = array(0,0,$img1->size[0], $img1->size[1]);
    $im = 0;
    /**
     *    def _render_on_top(self, img1, img2):
        region = (0, 0, img1.size[0], img1.size[1])
        # create a transparent layer the size of the image and draw the
        # tile-/quadlayer in that layer.
        im = PIL.Image.new('RGBA', img1.size, (0,0,0,0))
        im.paste(img2, (0, 0))
        mask = im#.convert('1') # TODO: transparency bug
        return PIL.ImageChops.composite(im, img1, mask)
     */
  }
  


  function render($gamelayer_on_top = FALSE){
    /**
     *         im = PIL.Image.new('RGBA', (self.width*64, self.height*64))
        for layer in self.layers:
            if layer.is_gamelayer and gamelayer_on_top:
                continue
            if hasattr(layer, 'render'):
                im = self._render_on_top(im, layer.render())
        if gamelayer_on_top:
                im = self._render_on_top(im, self.gamelayer.render())
        return im
     */
  }
  
  function show(){
    echo '<Teemap '.$this->name.' ('.$this->with.'x'.$this->height.')>';    
  }
                                                
}
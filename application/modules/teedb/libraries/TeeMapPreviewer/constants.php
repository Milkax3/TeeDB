<?php
  $ITEM_TYPES = array('version', 'info', 'image', 'envelope', 'group', 'layer', 'envpoint');
  $LAYER_TYPES = array('invalid', 'game', 'tile', 'quad');
  define('GAMELAYER_IMAGE', './upload/mods/server/entities/entities.png'); //tile
  
  function __autoload($class_name) {
    require_once $class_name . '.php';
  }
  
  //global $ITEM_TYPES;
  //global $LAYER_TYPES;
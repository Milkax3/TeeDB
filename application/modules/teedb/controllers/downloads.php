<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Downloads extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('download');
		$this->load->model(array('teedb/download', 'teedb/skin', 'teedb/tileset', 'teedb/demo', 'teedb/gameskin', 'teedb/map'));
	}
	
	function index($type, $name)
	{
		$ext = '.png';
		
		switch($type)
		{
			case 'skin': $file = 'uploads/skins/'.$name.'.png'; $table = $this->skin; break;
			case 'mapres': $file = 'uploads/mapres/'.$name.'.png'; $table = $this->tileset; break;
			case 'gameskin': $file = 'uploads/gameskins/'.$name.'.png'; $table = $this->gameskin; break;
			case 'map': $file = 'uploads/maps/'.$name.'.map'; $ext = '.map'; $table = $this->map; break;
			case 'demo': $file = 'uploads/demos/'.$name.'.demo'; $ext = '.demo'; $table = $this->demo; break;
			default: redirect('/');
		}
		
		if(is_file($file) and $data = file_get_contents($file))
		{
			$this->download->increment($type, $table, $name);
			force_download($name.$ext, $data);
		}else{
			redirect('/'); //TODO: file coundn't found message here
		}
	}
}

/* End of file download.php */
/* Location: ./application/modules/teedb/controllers/download.php */
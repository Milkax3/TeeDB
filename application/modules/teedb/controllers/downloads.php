<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Downloads extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('download');
		
		$this->load->model('teedb/download');
	}
	
	function index($type, $name)
	{
		switch($type)
		{
			case 'skin': $file = 'uploads/skins/'.$name.'.png'; break;
			case 'mapres': $file = 'uploads/mapres/'.$name.'.png'; break;
			case 'gameskin': $file = 'uploads/gameskins/'.$name.'.png'; break;
			default: redirect('/');
		}
		
		if(is_file($file) and $data = file_get_contents($file))
		{
			//$this->download->increment($type, $name);
			force_download($name.'.png', $data);
		}else{
			redirect('/'); //TODO: file coundn't found message here
		}
	}
}

/* End of file download.php */
/* Location: ./application/modules/teedb/controllers/download.php */
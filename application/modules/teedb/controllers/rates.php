<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rates extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('download');
		
		$this->load->model('teedb/rate');
	}
	
	function index()
	{		
		//Check values
		$id = (int) $this->input->post('id');
		if(!is_numeric($id) or $id <= 0)
			return FALSE;
		
		$type = trim($this->input->post('type'));
		switch($type){
			case 'skin':
			case 'mapres':
			case 'mod':
			case 'map':
			case 'demo':
				break;
			default: return FALSE;
		}
		
		$rate = (int) $this->input->post('rate');
		if(!is_numeric($rate) or $rate!= 1 and $rate != 0)
			return FALSE;
		
		$data = $this->rate->setRate($type, $id, $rate);
		$this->_return_json($data);
	}

	function _return_json($json) 
	{
	    $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
	    $this->output->set_header("Pragma: no-cache");
		form_open(); //To generate a new csrf hash
		$json['csrf_token_name'] = $this->security->get_csrf_token_name();
		$json['csrf_hash'] = $this->security->get_csrf_hash();
		$this->security->csrf_set_cookie();
		$this->output->append_output(json_encode($json));
	}
}

/* End of file rates.php */
/* Location: ./application/modules/teedb/controllers/rates.php */
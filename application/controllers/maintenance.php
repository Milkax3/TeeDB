<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{		
		$data['date'] = "2012/12/12";
		$this->load->view('maintenance', $data);
	}
}

/* End of file maintenance.php */
/* Location: ./application/controllers/maintenance.php */
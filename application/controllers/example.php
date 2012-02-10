<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('template');
	}

	// --------------------------------------------------------------------

	/**
	 * Temaplte example wirh Bootstrap 2.0
	 */
	
	public function index()
	{
		$this->template->set_subtitle('Example');
		$this->template->view('example');
	}
}

/* End of file example.php */
/* Location: ./application/controllers/example.php */
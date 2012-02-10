<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('user/auth');
		if($this->auth == NULL || !$this->auth->logged_in()) {
			redirect('user/login');
		}
		
		$this->template->clear_layout();
		$this->template->set_theme('admin');
	}

	// --------------------------------------------------------------------

	/**
	 * Temaplte example wirh Bootstrap 2.0
	 */
	
	public function index()
	{
		$this->template->set_subtitle('Dashboard');
		$this->template->view('admin');
	}
}

/* End of file login.php */
/* Location: ./application/modules/user/controllers/login.php */
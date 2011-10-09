<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('auth');
	}

	public function index()
	{
    	$this->auth->logout();
	}
}

/* End of file logout.php */
/* Location: ./application/modules/user/controllers/logout.php */
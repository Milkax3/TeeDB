<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Html5 extends CI_Controller {
	
	public function index()
	{
		$this->load->view('html5boilerplate');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
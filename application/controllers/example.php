<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {
	
	public function index()
	{
		$this->load->view('header', array('title' => 'Example page'));
		$this->output->append_output('Welcome to CodeIgniter + Html5Boilerplate');
		$this->load->view('footer');
	}
}

/* End of file example.php */
/* Location: ./application/controllers/example.php */
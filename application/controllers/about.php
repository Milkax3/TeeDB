<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {
	
	public function index()
	{
		$this->template->set_subtitle('About');
		$this->template->view('about');
	}
}

/* End of file about.php */
/* Location: ./application/controllers/about.php */
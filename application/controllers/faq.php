<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {
	
	public function index()
	{
		$this->template->set_subtitle('FAQ');
		$this->template->view('faq');
	}
}

/* End of file faq.php */
/* Location: ./application/controllers/faq.php */
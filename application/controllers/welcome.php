<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		$this->load->model(array('blog/blog', 'user/user', 'teedb/skin', 'teedb/common'));
	}
	
	public function index()
	{		
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['news'] = $this->blog->get_latest(1);
		$data['stats'] = $this->common->get_stats();
		
		$this->template->set_layout_data('nav', array('large' => TRUE, 'randomtee' => $this->skin->get_random()));
		$this->template->view('welcome', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
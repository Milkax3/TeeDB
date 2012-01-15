<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends CI_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation', 'user/auth'));
		if($this->auth == NULL || !$this->auth->logged_in()) {
			redirect('user/login');
		}
	}

	public function index()
	{
		$success = FALSE;
		
		if ($this->_submit_validate() === TRUE)
		{
			$success = TRUE;
		}
		
		$this->template->set_subtitle('Edit profile');
		$this->template->view('edit', array('success' => $success));
	}

	private function _submit_validate()
	{
				
		$this->form_validation->set_rules('username', 'username', 'callback__not_logged_in|trim|required|callback__status|callback__authenticate');
		$this->form_validation->set_rules('password', 'password', 'trim|required');

		return $this->form_validation->run();
	}
	
	function _status()
	{
		$status = $this->user->get_status($this->input->post('username'));
		
		if($status === User::STATUS_DEACTIVE)
		{
			$this->form_validation->set_message('_activate','Invalid login. The account is not activated, yet. Click '.anchor('user/signup/resend/'.$this->input->post('username'), 'here').' if you want to send the activation mail again.');
			return FALSE;
		}
		elseif($status === User::STATUS_BANNED)
		{
			$this->form_validation->set_message('_not_banned','Invalid login. The Account has been banned.');
			return FALSE;
		}
		
		return TRUE;
	}
	
	function _authenticate()
	{
		//per input->post
		$this->form_validation->set_message('_authenticate','Invalid login. Please try again.');
		return $this->auth->login();
	}
	
	function _not_logged_in()
	{
		$this->form_validation->set_message('_not_logged_in', 'You are already logged in.');
		return !$this->auth->logged_in();
	}
}

/* End of file login.php */
/* Location: ./application/modules/user/controllers/login.php */
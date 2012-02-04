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
		
		$this->load->model(array('user/user', 'teedb/common'));
	}

	public function index($success = array())
	{
		$data['email'] = $this->user->get_email($this->auth->get_id());
		$data['uploads'] = $this->common->get_uploads($this->auth->get_id());
		$data['success'] = $success;
			
		$this->template->set_subtitle('Edit profile');
		$this->template->view('edit', $data);
	}
	
	public function pass()
	{		
		if ($this->_pass_validate() === TRUE)
		{
			$user_id = $this->user->change_pass(
				$this->auth->get_id(),
				$this->auth->get_hash($this->input->post('new_password'))
			);
			
			return $this->index(array('pass' => TRUE));
		}
			
		return $this->index(array('pass' => FALSE));
		
	}
	
	private function _pass_validate()
	{
		$this->form_validation->set_rules('new_password', 'password', 'required|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[new_password]');

		return $this->form_validation->run();
	}
	
	public function email()
	{		
		if ($this->_email_validate() === TRUE)
		{
			$user_id = $this->user->change_email(
				$this->auth->get_id(),
				$this->input->post('email')
			);
			
			return $this->index(array('email' => TRUE));
		}
			
		return $this->index(array('email' => FALSE));
	}
	
	private function _email_validate()
	{
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|unique[users.email]');

		return $this->form_validation->run();
	}
	
	public function del()
	{		
		if($this->input->post('delete'))
		{
			return $this->index(array('del' => TRUE));
		}
		
		if ($this->input->post('delete2'))
		{
			$this->user->remove($this->auth->get_id());
			$this->auth->logout();
			return;
		}

		$this->index();
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
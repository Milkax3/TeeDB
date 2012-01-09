<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LostPw extends CI_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation', 'auth', 'email'));
		$this->load->helper(array('url', 'string'));
		
		$this->config->load('user');
	}
	
	public function index()
	{
		$success = FALSE;
		
		if ($this->_submit_validate() === TRUE)
		{
			$password = $this->string->random_string('alnum');
			list($username, $hash) = $this->confirm->add_password_link($this->input->post('email'), $this->auth->get_hash($password));
			
			$this->email->from($this->config->item('email'), 'TeeDB - Teeworlds database');
			$this->email->to($this->input->post('email'));
			
			$this->email->subject('TeeDB - New password request.');
			$this->email->message('
				Hi '.$username.',
				
				If you did NOT request a new password for your account at teedb.info, you can ignore this message.
				
				------------------------------------------
				
				With the following link you can set your password to the automatic generated one.
				
				Confirm link: http://teedb.info/lostpw/confirm/'.$hash.'
				
				New password: '.$password.'
				
				So long...
				Your big teeworlds database
				TeeDB
			');
			
			$this->email->send();
			$success = TRUE;
		}
		
		$this->template->set_subtitle('Forgot password?');
		$this->template->view('lostpw', array('success' => $success));
	}

	public function confirm($link)
	{
		if(!$this->user->confirm($link))
		{
			show_error('Invalid confirm link or already used.');
		}
		else
		{
			show_error('Activation successful. You can use now the new password.');
		}
	}

	private function _submit_validate()
	{
		$this->form_validation->set_rules('email', 'email', 'callback__not_logged_in|callback__status|required|valid_email|exist[users.email]');
		$this->form_validation->set_message('authenticate','Invalid login. Please try again.');

		return $this->form_validation->run();
	}
	
	function _status()
	{
		$status = $this->user->get_status($this->input->post('username'));
		
		if($status === User::STATUS_DEACTIVE)
		{
			$this->form_validation->set_message('_activate','Activate your account first. Click '.anchor('user/signup/resend', 'here').' if you want to send the activation mail again.');
			return FALSE;
		}
		elseif($status === User::STATUS_BANNED)
		{
			$this->form_validation->set_message('_not_banned','Invalid action. The Account has been banned.');
			return FALSE;
		}
		
		return TRUE;
	}
	
	function _not_logged_in()
	{
		$this->form_validation->set_message('_not_logged_in', 'You are logged in. If you lost your password, you can edit it in your profil settings.');
		return !$this->auth->logged_in();
	}
}

/* End of file lostpw.php */
/* Location: ./application/modules/user/controllers/lostpw.php */
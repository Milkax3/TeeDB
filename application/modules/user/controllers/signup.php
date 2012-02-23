<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->library(array('form_validation', 'auth', 'email'));
		$this->load->model(array('user','confirm'));
		
		$this->config->load('user');
	}

	public function index()
	{
		$success = FALSE;
		
		if ($this->_submit_validate() === TRUE)
		{
			
			$user_id = $this->user->add_user(
				$this->input->post('username'), 
				$this->auth->get_hash($this->input->post('password')),
				$this->input->post('email')
			);
			
			if(($this->config->item('confirm_signup')))
			{
				$this->_send_mail(
					$this->input->post('username'), 
					$this->input->post('email'),
					$this->confirm->add_signup_link($user_id), 
					$this->input->post('password')
				);
				$success = TRUE;
			}
		}
		
		$this->template->set_subtitle('Signup');
		$this->template->view('signup', array('success' => $success));
	}

	public function resend($email)
	{
		if($link = $this->confirm->get_signup_link($email) && $username = $this->user->get_name_by_mail($email))
		{
			$this->_send_mail($username, $email, $link);
			show_error('Confirm link resend to '.url_title($email).'.');
		}
		else
		{
			show_error('Invalid email or account already activated.');
		}
	}
	
	private function _send_mail($username, $email, $link, $password = NULL)
	{
		$this->email->from($this->config->item('email'), 'TeeDB - Teeworlds database');
		$this->email->to($email);
		
		$this->email->subject('TeeDB - Confirm signup');
		$this->email->message('
			Hi '.$username.',
			
			If you did NOT create an account at teedb.info, you can ignore this message.
			
			------------------------------------------
			
			With the following link you can activate your created account on teedb.info.
			
			Confirm link: {unwrap}'.base_url('user/signup/confirm/'.$link).'{/unwrap}
			
			Username: '.$username.'
			Password: '.( ($password != NULL)? $password : 'Password can not be displayed.').'
			
			So long...
			Your big teeworlds database
			TeeDB
		');
		
		if(!$this->email->send()){
			$this->email->print_debugger();
			exit();
		}
	}

	public function confirm($link)
	{
		if(!$this->confirm->confirm($link))
		{
			show_error('Invalid link or account already activated.');
		}
		else
		{
			$this->output->set_output('Activation successful. You can now log in.');
			redirect('user/login');
		}
	}

	private function _submit_validate()
	{
		// validation rules
		$this->form_validation->set_rules('username', 'username', 'callback__not_logged_in|trim|required|alpha_numeric|min_length[3]|max_length[12]|unique[users.name]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|unique[users.email]');

		return $this->form_validation->run();
	}
	
	function _not_logged_in()
	{
		$this->form_validation->set_message('_not_logged_in', 'You are logged in. No multi accounts allowed.');
		return !$this->auth->logged_in();
	}
}

/* End of file signup.php */
/* Location: ./application/modules/user/controllers/signup.php */
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Confirm Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class User extends CI_Model {
	
	const TABLE = 'user_confirms';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->helper('string');
		$this->load->model('user');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a random hash link
	 * 
	 * @access private
	 * @return string
	 */
	private function _get_random_link()
	{
		$new_link = $this->string->random_string('unique');
		
		$query = $this->db
		->select('id')
		->where('link', $new_link)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			return $new_link;
		}
		
		return $this->_get_random_link();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add user signup confirm link
	 * 
	 * @access public
	 * @param integer user id
	 * @return string
	 */
	public function add_signup_link($user_id)
	{
		$link = $this->_get_random_link();
		
		$this->db
		->set('user_id', $user_id)
		->set('link', $link)
		->set('update', 'NOW()', FALSE)
		->set('create', 'NOW()', FALSE)
		->insert(self::TABLE);
		
		return $link;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get user signup confirm link
	 * 
	 * @access public
	 * @param string user name
	 * @return string hash link
	 */
	public function get_signup_link($username)
	{
		$this->db
		->select('link')
		->join(User::TABLE, 'user_id = '.User::TABLE.'.id')
		->where('name', $username)
		->where('password IS NULL')
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$confirm_set = $query->row();
			return $confirm_set->link;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add user lost password confirm link
	 * 
	 * @access public
	 * @param integer user id
	 * @param string password hash
	 * @return string
	 */
	public function add_password_link($email, $pass)
	{
		$link = $this->_get_random_link();
		$user_id = $this->user->get_id($email);
		
		$this->db
		->select('link')
		->where('user_id', $user_id)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$this->db
			->set('link', $link)
			->set('password', $pass)
			->set('update', 'NOW()', FALSE)
			->update(self::TABLE);
		}
		else
		{
			$this->db
			->set('user_id', $user_id)
			->set('link', $link)
			->set('password', $pass)
			->set('update', 'NOW()', FALSE)
			->set('create', 'NOW()', FALSE)
			->insert(self::TABLE);
		}
		
		return $link;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Check link and activate account or set new password
	 * 
	 * @access public
	 * @param string hash link
	 * @return boolean
	 */
	public function confirm($link)
	{
		$query = $this->db
		->select('id, user_id, password')
		->where('link', $link)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$confirm_set = $query->row();
			
			//Set new password
			if($confirm_set->password == NULL){
				$this->db
				->set('password', $confirm_set->password)
				->set('update', 'NOW()', FALSE)
				->where('id', $confirm_set->user_id)
				->update(User::TABLE);
			}
			//Activate new user
			else
			{
				$this->db
				->set('status', User::STATUS_ACTIVE)
				->set('update', 'NOW()', FALSE)
				->where('id', $confirm_set->user_id)
				->update(User::TABLE);
			}
			
			$this->db
			->where('id', $confirm_set->id)
			->delete(self::TABLE);
			
			return TRUE;
		}
		
		return FALSE;
	}
}

/* End of file: confirm.php */
/* Location: application/modules/user/models/confirm.php */
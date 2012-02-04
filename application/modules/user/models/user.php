<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class User extends CI_Model {
	
	const TABLE = 'users';
	
	const STATUS_DEACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_BANNED = 2;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->helper('file');
		$this->config->load('user/user');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count users in table
	 */
	public function count_users()
	{
		return $this->db->count_all(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add new user
	 * 
	 * @access public
	 * @param string user name
	 * @param string user password hash
	 * @param string email
	 * @return integer user id
	 */
	public function add_user($name, $password, $email)
	{
		$status =  ($this->config->item('confirm_signup'))? self::STATUS_DEACTIVE : self::STATUS_ACTIVE;
		
		$this->db
		->set('name', $name)
		->set('password', $password)
		->set('email', $email)
		->set('status', $status)
		->set('update', 'NOW()', FALSE)
		->set('create', 'NOW()', FALSE)
		->insert(self::TABLE);
		
		return $this->db->insert_id();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Change password
	 * 
	 * @access public
	 * @param string user id
	 * @param string new password hash
	 * @return integer user id
	 */
	public function change_pass($id, $password)
	{		
		return $this->db
		->set('password', $password)
		->set('update', 'NOW()', FALSE)
		->where('id', $id)
		->update(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Change email
	 * 
	 * @access public
	 * @param string user id
	 * @param string new email
	 * @return integer user id
	 */
	public function change_email($id, $email)
	{		
		return $this->db
		->set('email', $email)
		->set('update', 'NOW()', FALSE)
		->where('id', $id)
		->update(self::TABLE);
	}
	

	// --------------------------------------------------------------------
	
	/**
	 * Login
	 * 
	 * @access public
	 * @param string user name
	 * @param string password hash
	 * @return integer user id
	 */
	public function login($name, $hash)
	{
		$query = $this->db
		->select('id')
		->where('name', $name)
		->where('password', $hash)
		->where('status !=', self::STATUS_DEACTIVE)
		->where('status !=', self::STATUS_BANNED)
		->limit(1)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$user = $query->row();
			return $user->id;
		}
		
		return 0;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get user id
	 * 
	 * @access public
	 * @param string email
	 * @return integer user id
	 */
	public function get_id($email)
	{
		$query = $this->db
		->select('id')
		->where('email', $email)
		->limit(1)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$user = $query->row();
			return $user->id;
		}
		
		return 0;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get user id
	 * 
	 * @access public
	 * @param string email
	 * @return integer user id
	 */
	public function get_status($name)
	{
		$query = $this->db
		->select('status')
		->where('name', $name)
		->limit(1)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$user = $query->row();
			return $user->status;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the user name
	 * 
	 * @access public
	 * @param integer user id
	 * @return string user name
	 */
	public function get_name($user_id)
	{
		$query = $this->db
		->select('name')
		->where('id', $user_id)
		->limit(1)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$user = $query->row();
			return $user->name;
		}
		
		return '';
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the user email
	 * 
	 * @access public
	 * @param integer user id
	 * @return string user name
	 */
	public function get_email($user_id)
	{
		$query = $this->db
		->select('email')
		->where('id', $user_id)
		->limit(1)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			$user = $query->row();
			return $user->email;
		}
		
		return '';
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get user where id
	 * 
	 * @access public
	 * @param integer user id
	 * @return db-obj user
	 */
	public function get_user($user_id)
	{
		$query = $this->db
		->select('*')
		->where('id', $user_id)
		->limit(1)
		->get(self::TABLE);
		
		if ($query->num_rows())
		{
			return $query->row();
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get user where id
	 * 
	 * @access public
	 * @param integer user id
	 * @return db-obj user
	 */
	public function remove($user_id)
	{
		return $this->db
		->where('id', $user_id)
		->limit(1)
		->delete(self::TABLE);
	}
	

	// --------------------------------------------------------------------
	
	/**
	 * Get data for the last user
	 * 
	 * Data will be:
	 * 	name	string		Name of the user
	 * 	update	datatime	last time the dataset changed
	 * 
	 * @access public
	 * @return db-obj
	 */
	public function get_last_user()
	{
		$query = $this->db
		->select('name, create')
		->order_by('create DESC')
		->limit(1)
		->get(self::TABLE);
		
		return $query->row();
	}

	// --------------------------------------------------------------------
	// TODO: Continue model reworking ...
	// --------------------------------------------------------------------

	// --------------------------------------------------------------------
	
	/**
	 * Get user by name
	 * 
	 * Get id, name and create from table where $name is in table
	 * 
	 * @access public
	 * @param string
	 * @return db-obj
	 */
	public function get_user_by_name($name)
	{
		$query = $this->db
		->select('id, name, create')
		->where('name', $name)
		->limit(1)
		->get(self::TABLE);
		
		return $query->row();
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Get avatar
	 * 
	 * @access public
	 * @param string Username
	 * @return string Path to user avatar
	 */
	public function get_avatar($name)
	{
		$files = get_filenames($this->config->item('upload_path_avatars'));
		foreach($files as $file)
			switch($name){
				case basename($file, '.png'): return base_url().$path.$file;
				case basename($file, '.gif'): return base_url().$path.$file;
				case basename($file, '.jpg'): return base_url().$path.$file;
			}
		return base_url().$path.'default.png';
	}

	// --------------------------------------------------------------------	
			
	public function getComments($user_id){
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.type_id',$user_id);
		$this->db->where('comment.type = "user"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->result();
	}

	// --------------------------------------------------------------------		
	
	public function getComment($id){
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.id',$id);
		$this->db->where('comment.type = "user"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->row();
	}

	// --------------------------------------------------------------------
		
	public function setComment(){
		$this->db->set('comment', $this->input->post('comment'));
		$this->db->set('user_id', $this->auth->getCurrentUserID());
		$this->db->set('type', 'user');
		$this->db->set('type_id', $this->input->post('id'));
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert('comment');
		
		return $this->db->insert_id();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Check ID
	 * 
	 * @access public
	 * @param integer
	 * @return bool
	 */
	public function check_id($id){
		$query = $this->db
		->select('id')
		->where('id', $id)
		->get(self::TABLE);
		
		if($query->num_rows()){
			return TRUE;
		}
		return FALSE;
	}	
}

/* End of file: user.php */
/* Location: application/modules/user/models/user.php */
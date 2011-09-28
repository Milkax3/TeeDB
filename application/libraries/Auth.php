<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Authentication
 * @author		Andreas Gehle
 */
class Auth {

	protected $CI;
	protected $index_redirect 	= '/';
	protected $login_redirect 	= '/login';
	
	private static $salt		= 'geheim';
	private static $user_id 	= 0;
	private static $user_name 	= ''; 
	private static $rights		= array();

	
	/**
	 * Constructor
	 */
	function __constructor($props = array())
	{
		$this->CI =& get_instance();

		// Load additional libraries, helpers, etc.
		$this->CI->load->library('session');
		$this->CI->load->database();
		$this->CI->load->helper('url');

		if (count($props) > 0)
		{
			$this->initialize($props);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	public function initialize($props = array())
	{
		if (count($props) > 0)
		{
			foreach ($props as $key => $val)
			{
				$this->$key = $val;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Redirects users after logging in
	 *
	 * @access	public
	 * @return	void
	 */
	public function redirect()
	{
		if ($this->CI->session->userdata('redirected_from') == FALSE)
		{
			redirect($this->index_redirect);
		}
		else
		{
			redirect($this->CI->session->userdata('redirected_from'));
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Restrict users from certain pages
	 * 
	 * use restrict(TRUE) if a user can't access a page when logged in
	 *
	 * @access	public
	 * @param	boolean	if the page is viewable when logged in
	 * @return	void
	 */
	public function restrict($logged_out = FALSE)
	{
		// If the user is logged in and he's trying to access a page
		// he's not allowed to see when logged in,
		// redirect him to the index!
		if ($logged_out && $this->logged_in())
		{
			redirect($this->index_redirect);
		}

		// If the user isn' logged in and he's trying to access a page
		// he's not allowed to see when logged out,
		// redirect him to the login page!
		if ( ! $logged_out && ! $this->logged_in())
		{
			// We'll use this in our redirect method.
			$this->CI->session->set_userdata('redirected_from', $this->CI->uri->uri_string()); 
			redirect($this->login_redirect);
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Checks login data
	 * 
	 * Requires user name and password as post data
	 * @access public
	 * @return boolean	if login successful the user will be redirect else false is given back
	 */
	public function login()
	{
		$query = $this->CI->db
		->select('id')
		->where('name', $this->CI->input->post('username') )
		->where('password', $this->get_hash($this->CI->input->post('password')) )
		->limit(1)
		->get('user');
	
		if ($query->num_rows())
		{
			$row = $query->row();
			$this->CI->session->set_userdata('user_id', $row->id);
			self::$user_id = $row->id;
			$this->redirect();
			return TRUE;
		}
		
		// No existing user or password wrong
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * User is logged in
	 * 
	 * @access public
	 * @return boolean
	 */
	public function logged_in()
	{
		return (self::$user_id > 0 || self::$user_id = $this->CI->session->userdata('user_id'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Getter for user id
	 *
	 * @access	public
	 * @return	mixed	value - user id or boolean false if not logged in
	 */
	public function get_user_id()
	{
		if($this->logged_in())
		{
			return self::$user_id;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
  
  	/**
	 * Checks user rights
	 * 
	 * @access public
	 * @param string
	 * @return boolean
	 */
	public function user_can($right)
	{
	    if(isset(self::$rights[$right]))
	    {
	    	return self::$rights[$right];
	    }   
		
		if(!$this->logged_in())
		{
			return FALSE;
		}
		
	    $query = $this->CI->db
	    ->select('right')
	    ->where('user_id', self::$user_id)
	    ->where('right', $right)
	    ->get('userrights');
	    
	    if ($query->num_rows())
	    {
	      $row = $query->row();
	      self::$rights[$right] = TRUE;
		  
	      return TRUE;
	    }
		
	    self::$rights[$right] = FALSE;
		  
	    return FALSE;
	  }

	// --------------------------------------------------------------------
	
	/**
	 * Getter for user name
	 * 
	 * @access public
	 * @return mixed
	 */
	public function get_username()
	{		
		if(!$this->logged_in())
		{
			return FALSE;
		}
			
		if(self::$user_name)
		{
			return self::$user_name;
		}
		
		$query = $this->CI->db
		->select('name')
		->where('id', self::$user_id)
		->limit(1)
		->get('user');
		
		if ($query->num_rows())
		{
			$row = $query->row();
			self::$user_name = $row->name;
			
			return self::$user_name;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the user database object
	 * 
	 * @access public
	 * @return db-obj
	 */
	public function getCurrentUser()
	{
		if(!$this->logged_in())
		{
			return FALSE;
		}
			
		$query = $this->CI->db
		->select('*')
		->where('id', self::$user_id)
		->limit(1)
		->get('user');
		
		if ($query->num_rows())
		{
			$row = $query->row();
			
			return $row;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Logout
	 *
	 * Log out the current user and redirect to index page
	 */
	public function logout()
	{
		$this->CI->session->sess_destroy();
		redirect($this->index_redirect);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the hash for a password
	 * 
	 * @access public
	 * @param string
	 * @return string
	 */
	public function get_hash($password)
	{
		return sha1(self::$salt.$password);
	}
}

/* End of file: Auth.php */
/* Location: application/libraries/Auth.php */
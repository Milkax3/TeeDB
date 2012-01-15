<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Demo Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Demo extends CI_Model {
	
	const TABLE = 'teedb_demos';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->model(array('user', 'teedb/rate'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count demos
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_demos()
	{
		return $this->db->count_all(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a all demos
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Demo name
	 */	
	public function get_demos($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('demo.id, demo.name, demo.downloads, user.name AS username, demo.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as demo')
		->join(User::TABLE.' as user', 'demo.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'demo.id = rate.type_id AND rate.type = "demo"', 'left')
		->order_by($order, $direction)
		->group_by('demo.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count user demos
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_my_demos()
	{
		$this->db
			->from(self::TABLE.' as demo')
			->join(User::TABLE.' as user', 'demo.user_id = user.id')
			->where('user.id', $this->auth->get_id());		
		
		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get all user demos
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Demo name
	 */	
	public function get_my_demos($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('demo.id, demo.name, demo.downloads, user.name AS username, demo.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as demo')
		->join(User::TABLE.' as user', 'demo.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'demo.id = rate.type_id AND rate.type = "demo"', 'left')
		->where('user.id', $this->auth->get_id())
		->order_by($order, $direction)
		->group_by('demo.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	public function setDemo($name = null){
		if(!$name and !$name = $this->input->post('name') or
			!$this->auth and !$this->auth->logged_in()){
			return false;
		}
		
		$this->db->set('name', $name);
		$this->db->set('user_id', $this->auth->get_id());
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert(self::TABLE);
		
		return $this->db->insert_id();
	}
}

/* End of file: demo.php */
/* Location: application/modules/teedb/models/demo.php */
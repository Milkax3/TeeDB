<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Map Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Map extends CI_Model {
	
	const TABLE = 'teedb_maps';
		
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
	 * Count maps
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_maps()
	{
		return $this->db->count_all(self::TABLE);
	}	

	// --------------------------------------------------------------------
	
	/**
	 * Get a all maps
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Map name
	 */	
	public function get_maps($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('map.id, map.name, map.downloads, user.name AS username, map.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as map')
		->join(User::TABLE.' as user', 'map.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'map.id = rate.type_id AND rate.type = "map"', 'left')
		->order_by($order, $direction)
		->group_by('map.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count user skins
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_my_maps()
	{
		$this->db
			->from(self::TABLE.' as map')
			->join(User::TABLE.' as user', 'map.user_id = user.id')
			->where('user.id', $this->auth->get_id());		
		
		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a all maps
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Map name
	 */	
	public function get_my_maps($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('map.id, map.name, map.downloads, user.name AS username, map.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as map')
		->join(User::TABLE.' as user', 'map.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'map.id = rate.type_id AND rate.type = "map"', 'left')
		->where('user.id', $this->auth->get_id())
		->order_by($order, $direction)
		->group_by('map.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}
	

	// --------------------------------------------------------------------
	
	public function setMap($name = null){
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

/* End of file: map.php */
/* Location: application/modules/teedb/models/map.php */
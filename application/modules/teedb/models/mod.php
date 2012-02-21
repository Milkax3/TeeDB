<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Mod Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Mod extends CI_Model {
	
	const TABLE = 'teedb_mods';
		
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
	 * Tablename
	 * 
	 * @access public
	 * @return integer
	 */	
	public function get_table()
	{
		return self::TABLE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count mods
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_mods()
	{
		return $this->db->count_all(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a all modifications
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Mod name
	 */	
	public function get_mods($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('modi.id, modi.name, modi.link, modi.server, modi.client, modi.downloads, user.name AS username, modi.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as modi')
		->join(User::TABLE.' as user', 'modi.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'modi.id = rate.type_id AND rate.type = "mod"', 'left')
		->order_by($order, $direction)
		->group_by('modi.id')
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
	public function count_my_mods()
	{
		$this->db
			->from(self::TABLE.' as modi')
			->join(User::TABLE.' as user', 'modi.user_id = user.id')
			->where('user.id', $this->auth->get_id());		
		
		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get user skins
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Skin name
	 */	
	public function get_my_mods($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('modi.id, modi.name, modi.downloads, user.name AS username, modi.create')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as modi')
		->join(User::TABLE.' as user', 'modi.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'modi.id = rate.type_id AND rate.type = "mod"', 'left')
		->where('user.id', $this->auth->get_id())
		->order_by($order, $direction)
		->group_by('modi.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}
	

	// --------------------------------------------------------------------
	
	public function setMod($name, $link, $server=false, $client=false){
		$this->db
			->set('name', $name)
			->set('link', $link)
			->set('server', $server)
			->set('client', $client)
			->set('user_id', $this->auth->get_id())
			->set('update', 'NOW()', FALSE)
			->set('create', 'NOW()', FALSE)
			->insert(self::TABLE);
		
		return $this->db->insert_id();
	}
	
	public function get_name($id)
	{
		$query = $this->db
		->select('name')
		->where('id', $id)
		->get(self::TABLE);
		
		return $query->row()->name;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Change skinname
	 * 
	 * @access public
	 * @param string skin id
	 * @param string skin name
	 * @return integer user id
	 */
	public function change_name($id, $name)
	{		
		return $this->db
		->set('name', $name)
		->set('update', 'NOW()', FALSE)
		->where('id', $id)
		->update(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Remove skin
	 * 
	 * @access public
	 * @param integer user id
	 * @return db-obj user
	 */
	public function remove($id)
	{
		return $this->db
		->where('id', $id)
		->limit(1)
		->delete(self::TABLE);
	}

	// --------------------------------------------------------------------
}

/* End of file: mod.php */
/* Location: application/modules/teedb/models/mod.php */
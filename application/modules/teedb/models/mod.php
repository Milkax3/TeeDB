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
		->select('modi.id, modi.name, modi.downloads, user.name AS username, modi.create')
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
}

/* End of file: mod.php */
/* Location: application/modules/teedb/models/mod.php */
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Common Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Common extends CI_Model {
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->model(array('teedb/demo', 'teedb/gameskin', 'teedb/map', 'teedb/mapres', 'teedb/mod', 'teedb/skin', 'teedb/user'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get teedb stats
	 * 
	 * @access public
	 * @param integer limit
	 * @return db-obj
	 */	
	public function get_stats()
	{
		$tables = array(Demo::TABLE, Gameskin::TABLE, Map::TABLE, Mapres::TABLE, Mod::TABLE, Skin::TABLE, User::TABLE);
		
		foreach($tables as $table){		
			$this->db->select('count(*) AS count');
			if($table == 'user'){
				$this->db->from($table);				
			}else{
				$this->db->from($table);
			}
			$stats[$table] = $this->db->get()->row();
		}

		foreach($stats as $table => $stat){		
			$this->db->select($stat->count.' AS `'.$table.'`', FALSE);
		}
		$query = $this->db->get();
		
		return $query->row();
	}

	// --------------------------------------------------------------------
	// TODO: Continue model reworking ...
	// --------------------------------------------------------------------
	
	function getLastTeeDBEntries($limit=6){
		$tables = array('teedb_map', 'teedb_mapres', 'teedb_gameskin', 'teedb_demo', 'teedb_mod');
		$queryStr = '';
		
		foreach($tables as $table){		
			$this->db->select('id, name, create');
			$queryStr .= $this->db->_compile_select().", '{PRE}$table' AS type FROM `{PRE}$table` LIMIT $limit UNION ";
			$this->db->_reset_select();
		}

		$this->db->select('id, name, create');
		$queryStr .= $this->db->_compile_select().", '{PRE}teedb_skin' AS type FROM `{PRE}teedb_skin` ";
		$this->db->_reset_select();		
		
		$queryStr .= 'GROUP BY `id` ORDER BY `create` DESC LIMIT '.$limit;			
		$query = $this->db->query($queryStr);
		
		return $query->result();
	}
	
}

/* End of file: common.php */
/* Location: application/modules/teedb/models/common.php */
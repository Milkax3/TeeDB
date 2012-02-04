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
		$this->load->model(array('teedb/demo', 'teedb/gameskin', 'teedb/map', 'teedb/tileset', 'teedb/mod', 'teedb/skin', 'teedb/user'));
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
		$tables = array(Demo::TABLE, Gameskin::TABLE, Map::TABLE, Tileset::TABLE, Mod::TABLE, Skin::TABLE, User::TABLE);
		
		foreach($tables as $table){		
			$this->db
				->select('count(*) AS count1')
				->from($table);
			$stats[$table] = $this->db->get()->row();
		}

		foreach($stats as $table => $stat){		
			$this->db->select($stat->count1.' AS `'.str_replace('teedb_', '', $table).'`', FALSE);
		}
		$query = $this->db->get();
		
		return $query->row();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get teedb stats for user
	 * 
	 * @access public
	 * @param integer limit
	 * @return db-obj
	 */	
	public function get_uploads($user_id)
	{
		$tables = array(Demo::TABLE, Gameskin::TABLE, Map::TABLE, Tileset::TABLE, Mod::TABLE, Skin::TABLE);
		
		foreach($tables as $table){		
			$this->db
				->select('count(*) AS count')
				->from($table)
				->where('user_id', $user_id);
			$stats[$table] = $this->db->get()->row();
		}

		$uploads = 0;
		foreach($stats as $stat){		
			$uploads += $stat->count;
		}
		
		return $uploads;
	}

	// --------------------------------------------------------------------
	// TODO: Continue model reworking ...
	// --------------------------------------------------------------------
	
	function get_last($limit=6){
		$tables = array(Demo::TABLE, Gameskin::TABLE, Map::TABLE, Tileset::TABLE, Mod::TABLE);
		$queryStr = '';
		
		foreach($tables as $table){		
			$this->db->select('id, name, create');
			$queryStr .= $this->db->get_compiled_select().", '".str_replace('teedb_', '', $table)."' AS type FROM `".$this->db->dbprefix($table)."` LIMIT $limit UNION ";
			$this->db->reset_query();
		}

		$this->db->select('id, name, create');
		$queryStr .= $this->db->get_compiled_select().", '".str_replace('teedb_', '', Skin::TABLE)."' AS type FROM `".$this->db->dbprefix(Skin::TABLE)."` ";
		$this->db->reset_query();		
		
		$queryStr .= 'GROUP BY `id` ORDER BY `create` DESC LIMIT '.$limit;			
		$query = $this->db->query($queryStr);
		
		return $query->result();
	}
	
}

/* End of file: common.php */
/* Location: application/modules/teedb/models/common.php */
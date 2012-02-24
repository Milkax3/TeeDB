<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Download Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Download extends CI_Model {
	
	const TABLE = 'teedb_downloads';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Increment download count for teedb entries
	 * 
	 * @access public
	 * @param string Type can be demo, gameskin, map, mapres, mod, skin
	 * @param string Name for the entry
	 * @return boolean
	 */	
	public function increment($type, $table, $name)
	{
		$ip = $this->input->ip_address();
		
		$query = $this->db
		->select('dw_type.id, dw_type.downloads, dw.ip', FALSE)
		->from($table->get_table().' as dw_type')
		->join(self::TABLE.' as dw', 'dw_type.id = dw.type_id AND dw.type = "'.$type.'" AND dw.ip = '.ip2long($ip), 'left')
		->where('dw_type.name', $name)
		->limit(1)
		->get();
		
		if($query->num_rows()){
			$dw = $query->row();
			
			if(!isset($dw->ip)){
				$dowloads = $dw->downloads + 1;
				$this->db
				->set('downloads', $dowloads)
				->where('name', $name)
				->update($table->get_table());
				
				if($ip != '0.0.0.0'){
					$this->db
					->set('type_id', $dw->id)
					->set('type', $type)
					->set('ip', ip2long($ip))
					->set('date', 'NOW()', FALSE)
					->insert(self::TABLE);
				}
				return TRUE;
			}
		}
		return FALSE;
	}
}

/* End of file: download.php */
/* Location: application/modules/teedb/models/download.php */
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
	public function increment($type, $name)
	{
		$ip = $this->input->ip_address();
		
		$query = $this->db
		->select($type.'.id, '.$type.'.downloads, download.ip', FALSE)
		->from($type)
		->join('download', $type.'.id = download.type_id AND download.ip = '.ip2long($ip), 'left')
		->where('name', $name)
		->limit(1)
		->get(self::TABLE);
		
		if($query->num_rows()){
			$dw = $query->row();
			
			if(!isset($dw->ip)){
				$dowloads = $dw->downloads + 1;
				$this->db->set('downloads', $dowloads);
				$this->db->where('name', $name);
				$this->db->update($type);
				
				if($ip != '0.0.0.0'){
					$this->db->set('type_id', $dw->id);
					$this->db->set('type', $type);
					$this->db->set('ip', ip2long($ip));
					$this->db->set('date', 'NOW()', FALSE);
					$this->db->insert('download');
				}
				return TRUE;
			}
		}
		return FALSE;
	}
}

/* End of file: download.php */
/* Location: application/modules/teedb/models/download.php */
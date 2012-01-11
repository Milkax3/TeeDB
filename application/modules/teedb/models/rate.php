<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rate Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Rate extends CI_Model {
	
	const TABLE = 'teedb_rates';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}
	
	function setRate($type, $id, $value)
	{
		if($user_id = $this->auth->get_id())
		{
			$data = array();
			
			$this->db->select('value');
			$this->db->from(self::TABLE);
			$this->db->where('type_id', $id);
			$this->db->where('type', $type);
			$this->db->where('user_id', $user_id);
			$this->db->limit(1);
			$query = $this->db->get();
			
			if($query->num_rows()){			
				$data['has_rated'] = $query->row()->value;
				
				$this->db->set('value', $value);
				$this->db->set('update', 'NOW()', FALSE);
				$this->db->where('type_id', $id);
				$this->db->where('type', $type);
				$this->db->where('user_id', $user_id);
				$this->db->update(self::TABLE);
			}else{
				$data['has_rated'] = -1;
				
				$this->db->set('value', $value);
				$this->db->set('type', $type);
				$this->db->set('type_id', $id);
				$this->db->set('user_id', $user_id);
				$this->db->set('update', 'NOW()', FALSE);
				$this->db->set('create', 'NOW()', FALSE);
				$this->db->insert(self::TABLE);
			}
			
			$this->db->select('SUM(value) as sum, COUNT(*) AS count');
			$this->db->from(self::TABLE);
			$this->db->where('type_id', $id);
			$this->db->where('type', $type);
			$this->db->limit(1);
			$query = $this->db->get();
			
			if($query->num_rows()){
				$rate = $query->row();
				if($rate->count == 0) {
					$data['like'] = 50;
					$data['dislike'] = 50;
				}else{
					$proc = round($rate->sum/$rate->count)*90;
					$data['like'] = ($proc >= 10)? $proc : 10;
					$data['dislike'] = 100 - $data['like'];
				}
				return $data;
			}

			return FALSE;
		}
		return FALSE;
	}
}
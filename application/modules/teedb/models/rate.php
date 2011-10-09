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
	
	function setRate($type, $id, $value){
		if($user_id = $this->auth->getCurrentUserID()){
			
			$this->db->select('value');
			$this->db->from('rate');
			$this->db->where('type_id', $id);
			$this->db->where('type', $type);
			$this->db->where('user_id', $user_id);
			$this->db->limit(1);
			$query = $this->db->get();
			
			if($query->num_rows()){
				$this->db->set('value', $value);
				$this->db->set('date', 'NOW()', FALSE);
				$this->db->where('type_id', $id);
				$this->db->where('type', $type);
				$this->db->where('user_id', $user_id);
				$this->db->update('rate');
			}else{
				$this->db->set('value', $value);
				$this->db->set('type', $type);
				$this->db->set('type_id', $id);
				$this->db->set('user_id', $user_id);
				$this->db->set('date', 'NOW()', FALSE);
				$this->db->insert('rate');			
			}
			
			$this->db->select('SUM(value) as sum, COUNT(*) AS count');
			$this->db->from('rate');
			$this->db->where('type_id', $id);
			$this->db->where('type', $type);
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows()){
				$rate = $query->row();
				if($rate->count == 0)
					return '0.00';
				else
					return number_format($rate->sum/$rate->count,2);
			}
			return FALSE;
		}
		return FALSE;
	}
}
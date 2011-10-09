<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Mapres Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Mapres extends CI_Model {
	
	const TABLE = 'teedb_mapres';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}
	
	public function countMapres(){
		$this->db->select('COUNT(*) AS count');
		$this->db->from('mapres');
		$query = $this->db->get();
		
		return $query->row()->count;
	}	
	
	public function countUserMapres($name){
		$this->db->select('COUNT(*) AS count');
		$this->db->from('mapres');
		$this->db->join('user', 'mapres.user_id = user.id AND user.name = "'.$name.'"');
		$query = $this->db->get();
		
		return $query->row()->count;
	}
	
	public function getRandom(){				
		$random = mt_rand(0, $this->countMapres()-1);
		
		$this->db->select('name');
		$this->db->from('mapres');
		$this->db->limit(1,$random);
		$query = $this->db->get();
		
		if($query->num_rows()){
			return $query->row();
		}
		
		return FALSE;		
	}
	
	public function setMapres(){
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('user_id', $this->auth->getCurrentUserID());
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert('mapres');
		
		return $this->db->insert_id();
	}
	
	public function getMapres($limit, $offset='0', $order='mapres.update', $direction='DESC'){
		$this->db->select('mapres.id, mapres.name, mapres.downloads, user.name AS username, mapres.update');
		$this->db->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count');
		$this->db->from('mapres');
		$this->db->join('user', 'mapres.user_id = user.id');
		$this->db->join('rate', 'mapres.id = rate.type_id AND rate.type = "mapres"', 'left');
		$this->db->order_by($order, $direction);
		$this->db->group_by('mapres.id');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		return $query->result();
	}	
	
	public function getUserMapres($limit, $name, $offset='0', $order='mapres.update', $direction='DESC'){
		$this->db->select('mapres.id, mapres.name, mapres.downloads, user.name AS username, mapres.update');
		$this->db->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count');
		$this->db->from('mapres');
		$this->db->join('user', 'mapres.user_id = user.id AND user.name = "'.$name.'"');
		$this->db->join('rate', 'mapres.id = rate.type_id AND rate.type = "mapres"', 'left');
		$this->db->order_by($order, $direction);
		$this->db->group_by('mapres.id');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function getRate($sum, $count){
		if($count == 0)
			return '0.00';
		else
			return number_format($sum/$count,2);
	}
	
	public function getTopMapres(){
		$this->db->select('mapres.name, user.name AS username');
		$this->db->select('SUM(rate.value) AS rate_sum, COUNT(rate.value) AS rate_count');
		$this->db->from('mapres');
		$this->db->join('user', 'mapres.user_id = user.id');
		$this->db->join('rate', 'mapres.id = rate.type_id AND rate.type = "mapres"');
		$this->db->group_by('mapres.id');
		$this->db->order_by('(SUM(rate.value)/COUNT(rate.value)) DESC');
		$this->db->order_by('COUNT(rate.value) DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}	
	
	public function getMapresByName($name){
		$this->db->select('mapres.id, mapres.name, mapres.downloads, user.name AS username, mapres.update');
		$this->db->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count');
		$this->db->from('mapres');
		$this->db->join('user', 'mapres.user_id = user.id');
		$this->db->join('rate', 'mapres.id = rate.type_id AND rate.type = "mapres"', 'left');
		$this->db->group_by('mapres.id');
		$this->db->where('mapres.name', $name);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}	
		
	public function getComments($mapres_id){
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.type_id',$mapres_id);
		$this->db->where('comment.type = "mapres"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->result();
	}	
	
	public function getComment($id){
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.id',$id);
		$this->db->where('comment.type = "mapres"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->row();
	}
		
	public function setComment(){
		$this->db->set('comment', $this->input->post('comment'));
		$this->db->set('user_id', $this->auth->getCurrentUserID());
		$this->db->set('type', 'mapres');
		$this->db->set('type_id', $this->input->post('id'));
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert('comment');
		
		return $this->db->insert_id();
	}
	
	public function getSize($name){
		$file = 'upload/mapres/'.$name.'.png';
		if(is_file($file)){
			$size = filesize($file);
		}else{
			$size = 0;
		}
		if($size > 0)
			return number_format(($size/1000),2).' kB';
		else
			return '0 kB';
	}	
	
	public function checkID($id){
		$this->db->select('id');
		$this->db->from('mapres');
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		if($query->num_rows()){
			return $query->row()->id;
		}
		return FALSE;
	}	
	
	function hasRate($id){
		$this->db->select('value');
		$this->db->from('rate');
		$this->db->where('user_id', $this->auth->getCurrentUserID());
		$this->db->where('type_id', $id);
		$this->db->where('type', 'mapres');
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function getName($id){
		$this->db->select('name');
		$this->db->from('mapres');
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		return $query->row()->name;
	}	
	
}

/* End of file: mapres.php */
/* Location: application/modules/teedb/models/mapres.php */
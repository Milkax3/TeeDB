<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Skin Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Skin extends CI_Model {
	
	const TABLE = 'teedb_skins';
		
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
	 * Count skins
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_skins()
	{
		return $this->db->count_all(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a random skin
	 * 
	 * @access public
	 * @return string Skin name
	 */	
	public function get_random()
	{
		//rand better performance as rand()
		$count = $this->count_skins();
		if($count<=0)
		{
			return FALSE;
		}
		
		$random = mt_rand(0, $count-1);
		
		$query = $this->db
		->select('name')
		->limit(1, $random)
		->get(self::TABLE);
		
		if($query->num_rows())
		{
			return $query->row();
		}
		
		return FALSE;		
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a all skins
	 * 
	 * @access public
	 * @param integer limit
	 * @param integer offset
	 * @param string order
	 * @param string direction
	 * @return string Skin name
	 */	
	public function get_skins($limit, $offset='0', $order='update', $direction='DESC')
	{
		$query = $this->db
		->select('skin.id, skin.name, skin.downloads, user.name AS username, skin.update')
		->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count')
		->from(self::TABLE.' as skin')
		->join(User::TABLE.' as user', 'skin.user_id = user.id')
		->join(Rate::TABLE.' as rate', 'skin.id = rate.type_id AND rate.type = "skin"', 'left')
		->order_by($order, $direction)
		->group_by('skin.id')
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	public function countUserSkins($name)
	{
		$this->db
			->from('teedb_skin as skin')
			->join('user', 'skin.user_id = user.id')
			->where('user.name', $name);		
		
		return $this->db->count_all_results();
	}
	
	public function setSkin()
	{
		$this->db
			->set('name', $this->input->post('name'))
			->set('user_id', $this->auth->getCurrentUserID())
			->set('update', 'NOW()', FALSE)
			->set('create', 'NOW()', FALSE)
			->insert('teedb_skin');
		
		return $this->db->insert_id();
	}
	
	public function getUserSkins($limit, $name, $offset='0', $order='skin.update', $direction='DESC')
	{
		$this->db->select('skin.id, skin.name, skin.downloads, user.name AS username, skin.update');
		$this->db->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count');
		$this->db->from('teedb_skin as skin');
		$this->db->join('user', 'skin.user_id = user.id AND user.name = "'.$name.'"');
		$this->db->join('teedb_rate as rate', 'skin.id = rate.type_id AND rate.type = "skin"', 'left');
		$this->db->order_by($order, $direction);
		$this->db->group_by('skin.id');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function getTopSkin()
	{
		$query = $this->db
			->select('skin.name, user.name AS username')
			->select('SUM( rate.value ) AS value, COUNT(rate.value) AS rate_count')
			->from('teedb_skin AS skin')
			->join('user', 'skin.user_id = user.id')
			->join('teedb_rate AS rate', 'skin.id = rate.type_id')
			->group_by('skin.id')
			->order_by('(SUM( rate.value )/COUNT( rate.value )) DESC')
			->order_by('COUNT(rate.value) DESC')
			->where('rate.type = "skin"')
			->limit(1)
			->get();
		
		return $query->row();
	}	
	
	public function getSkinByName($name)
	{
		$this->db->select('skin.id, skin.name, skin.downloads, user.name AS username, skin.update');
		$this->db->select('SUM(rate.value) AS rate_sum, COUNT(rate.user_id) AS rate_count');
		$this->db->from('teedb_skin as skin');
		$this->db->join('user', 'skin.user_id = user.id');
		$this->db->join('teedb_rate as rate', 'skin.id = rate.type_id AND rate.type = "skin"', 'left');
		$this->db->group_by('skin.id');
		$this->db->where('skin.name', $name);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}	
		
	public function getComments($skin_id)
	{
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.type_id',$skin_id);
		$this->db->where('comment.type = "skin"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->result();
	}	
	
	public function getComment($id)
	{
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.id',$id);
		$this->db->where('comment.type = "skin"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->row();
	}
		
	public function setComment()
	{
		$this->db->set('comment', $this->input->post('comment'));
		$this->db->set('user_id', $this->auth->getCurrentUserID());
		$this->db->set('type', 'skin');
		$this->db->set('type_id', $this->input->post('id'));
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert('comment');
		
		return $this->db->insert_id();
	}
	
	public function checkID($id)
	{
		$this->db->select('id');
		$this->db->from('teedb_skin');
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		if($query->num_rows()){
			return $query->row()->id;
		}
		return FALSE;
	}	
	
	function hasRate($id)
	{
		$this->db->select('value');
		$this->db->from('teedb_rate');
		$this->db->where('user_id', $this->auth->getCurrentUserID());
		$this->db->where('type_id', $id);
		$this->db->where('type', 'skin');
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function getName($id)
	{
		$this->db->select('name');
		$this->db->from('teedb_skin');
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		return $query->row()->name;
	}	
}

/* End of file: skin.php */
/* Location: application/modules/teedb/models/skin.php */
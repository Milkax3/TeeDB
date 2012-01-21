<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Comment Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Comment extends CI_Model {
	
	const TABLE = 'comments';
		
	/**
	 * Constructor
	 */
	function __construct(){
        parent::__construct();
		
		$this->load->database();
		$this->load->model(array('user/user'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count comments
	 * 
	 * @access public
	 * @param integer blog id
	 * @return integer
	 */	
	public function count_comments($blog_id)
	{
		return $this->db->where('news_id', $blog_id)->count_all(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get a all skins
	 * 
	 * @access public
	 * @param integer blog id
	 * @param integer limit
	 * @param integer offset
	 * @return string Skin name
	 */		
	public function get_comments($blog_id, $limit, $offset=0)
	{
		$query = $this->db
		->select('comment.comment, comment.create, user.name')
		->from(Comment::TABLE.' as comment')
		->join(User::TABLE.' as user', 'comment.user_id = user.id')
		->where('comment.news_id',$blog_id)
		->order_by('comment.create DESC')
		->limit($limit, $offset)
		->get();
	
		return $query->result();
	}

	// --------------------------------------------------------------------
	// TODO: Continue model reworking ...
	// --------------------------------------------------------------------
		
	/**
	 * Get Comments form a TeeDB/News or User id
	 * @param integer $type_id
	 * @param string $type (Enum: skin, mapres, map, mod, gameskin, demo, news, user)
	 * @return result-objekt if comments found
	 * @return boolean FALSE if no entry found or $type invalide
	 */
	public function getComments($type_id, $type){
		$this->load->helper('type');
		if(!checkCommentTypes($type))
			return FALSE;
		
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.type_id',$type_id);
		$this->db->where('comment.type', $type);
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->result();
	}	
	
	/**
	 * Get a Comment form ID and type
	 * @param integer $id
	 * @param string $type (Enum: skin, mapres, map, mod, gameskin, demo, news, user)
	 * @return result-objekt if comment found
	 * @return boolean FALSE if no entry found or $type invalide
	 */
	public function getComment($id, $type){
		$this->load->helper('type');
		if(!checkCommentTypes($type))
			return FALSE;
			
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.id',$id);
		$this->db->where('comment.type', $type);
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->row();
	}

	/**
	 * Set Comment by Input ['comment','id']
	 * BE SURE TO CHECK INPUTS BY FORM VALIDATION
	 * @param string $type (Enum: skin, mapres, map, mod, gameskin, demo, news, user)
	 * @return integer insert ID
	 */
	public function setComment($type){
    $this->load->helper('type');
    if(!checkCommentTypes($type))
      return FALSE;
      
		$this->db->set('comment', $this->input->post('comment'));
		$this->db->set('user_id', $this->auth->getCurrentUserID());
		$this->db->set('type', $type);
		$this->db->set('type_id', $this->input->post('id'));
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert('comment');
		
		return $this->db->insert_id();
	}
}

/* End of file: comment.php */
/* Location: application/modules/blog/models/comment.php */
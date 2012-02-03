<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Blog Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Blog extends CI_Model{
	
	const TABLE = 'news';
		
	/**
	 * Constructor
	 */
	function __construct(){
        parent::__construct();
		
		$this->load->database();
		$this->load->model(array('user/user', 'blog/comment'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count news
	 * 
	 * @access public
	 * @return integer
	 */	
	public function count_news()
	{
		return $this->db->count_all(self::TABLE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get latest news
	 * 
	 * @access public
	 * @param integer limit
	 * @return db-obj
	 */
	public function get_latest($limit, $offset=0, $order='news.create', $direction='DESC')
	{
		$query = $this->db
		->select('news.id, news.title, news.content, user.name, news.create, COUNT(comment.id) AS count_comment')
		->from(self::TABLE.' as news')
		->join(User::TABLE.' as user', 'news.user_id = user.id')
		->join(Comment::TABLE.' as comment', 'news.id = comment.news_id', 'left')
		->group_by('news.id')
		->order_by($order, $direction)
		->limit($limit, $offset)
		->get();
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get latest news titles
	 * 
	 * @access public
	 * @param integer limit
	 * @return db-obj
	 */
	public function get_latest_titles($limit=5)
	{
		$query = $this->db
		->select('title, create')
		->order_by('update DESC')
		->limit($limit)
		->get(self::TABLE);
		
		return $query->result();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get news by title
	 * 
	 * @access public
	 * @param integer limit
	 * @return db-obj
	 */
	public function get_news($title)
	{
		$query = $this->db
		->select('news.id, title, content, name, news.create, COUNT(comment.id) AS count_comment')
		->from(self::TABLE.' as news')
		->join(User::TABLE.' as user', 'news.user_id = user.id')
		->join(Comment::TABLE.' as comment', 'news.id = comment.news_id', 'left')
		->where('news.title', $title)
		->group_by('news.id')
		->limit(1)
		->get();
		
		if($query->num_rows())
		{
			return $query->row();
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	// TODO: Continue model reworking ...
	// --------------------------------------------------------------------
	
	
	public function save(){
		if($this->id == 0){
			$this->date_update = 'NOW()';
			$this->date_create = 'NOW()';
			$this->db->insert('blog', $this); 
		}else{
			$this->date_update = 'NOW()';
			$this->db->where('id', $this->id);
			$this->db->update('blog', $this); 				
		}
	}
	
	public function getComment($id){
		$this->db->select('comment.id, comment.comment, comment.update, user.name');
		$this->db->from('comment');
		$this->db->join('user', 'comment.user_id = user.id');
		$this->db->where('comment.id',$id);
		$this->db->where('comment.type = "blog"');
		$this->db->order_by('comment.update DESC');
		$query = $this->db->get();
	
		return $query->row();
	}

	public function checkID($id){
		$this->db->select('id');
		$this->db->from('blog');
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		if($query->num_rows()){
			return $query->row()->id;
		}
		return FALSE;
	}			
		
	public function setComment(){
		$this->db->set('comment', $this->input->post('comment'));
		$this->db->set('user_id', $this->auth->get_id());
<<<<<<< HEAD
		$this->db->set('news_id', $this->input->post('id'));
=======
		$this->db->set('type', 'blog');
		$this->db->set('type_id', $this->input->post('id'));
>>>>>>> origin/master
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert(Comment::TABLE);
		
		return $this->db->insert_id();
	}

	public function getUserID($blog_id){
	  $this->db->select('user_id');
	  $this->db->from('blog');
	  $this->db->where('id', $blog_id);
	  $query = $this->db->get();
	  
	  if($query->num_rows()){
	    return $query->row()->user_id;
	  }
	  return FALSE;
	}   
	
	public function delete($blog_id){
	  $this->db->where('id', $blog_id);
	  $this->db->delete('blog'); 
	}
}

/* End of file: blog.php */
/* Location: application/modules/blog/models/blog.php */
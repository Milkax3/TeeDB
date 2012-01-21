<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Academic Free License version 3.0
 * 
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class News extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		$this->load->library(array('pagination', 'form_validation', 'user/auth'));
		
		$this->load->model(array('blog/blog', 'blog/comment'));
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'news.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'news.downloads'; break;
			case 'name': $sort = 'news.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'news.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config['base_url'] = 'blog/news/index/'.$order.'/'.$direction;
		$config['total_rows'] = $this->blog->count_news();
		$config['per_page'] = 5;
		$config['num_links'] = 5;
		$config['uri_segment'] = 6;
		$config['cur_tag_open'] = '<span id="cur">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $config['per_page']){
			$limit = $config['per_page'];
		}
		
		//Set output
		$data = array();
		$data['news'] = $this->blog->get_latest($limit, $from, $sort, $direction);
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('News');
		$this->template->view('news', $data);
	}
	
	public function title($title, $from=0)
	{
		//Set output
		$data = array();
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['news'] = $this->blog->get_news(str_replace('-', ' ', $title));
		
		//Init pagination
		$config['base_url'] = 'blog/news/title/'.$title;
		$config['total_rows'] = $this->comment->count_comments($data['news']->id);
		$config['per_page'] = 5;
		$config['num_links'] = 8;
		$config['uri_segment'] = 5;
		$config['cur_tag_open'] = '<span id="cur">';
		$config['cur_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['total_rows'])
			$from=0;
		
		//Set limit
		$limit = $config['total_rows'] - $from; 
		if($limit >= $config['per_page']){
			$limit = $config['per_page'];
		}
		
		if(isset($data['news']) && $data['news']){
			$data['comments'] = $this->comment->get_comments($data['news']->id, $limit, $from);
		}
		
		$this->template->set_subtitle('News');
		$this->template->view('title', $data);
	}
	
	public function submit()
	{
		if(!$this->auth->logged_in())
		{
			return $this->_error('You have to login.');
		}
		
		if (!$this->_submit_validate())
		{
			return $this->_error(validation_errors(' ', ' '));
		}
		
		$this->blog->setComment();
		return $this->_info('Comment added.', $this->input->post('comment'));
	}

	private function _submit_validate()
	{
		function _parser($str)
		{
			$find = array(
			  "'\*(.*?)\*'is",
			  "'_(.*?)_'is",
			  "'-(.*?)-'is"
			);
			
			$replace = array(
			  '<strong>\\1</strong>',
			  '<em>\\1</em>',
			  '<span style="text-decoration: line-through;">\\1</span>'
			);
			
			return preg_replace($find, $replace, $str);
		}
		
		$this->form_validation->set_rules('id', 'id', 'trim|required|is_natural_no_zero||exists[blog.id]');
		$this->form_validation->set_rules('comment', 'comment text', 'trim|required|min_length[10]|max_length[500]|unique[comments.comment]|no_spam[comments.3]|htmlspecialchars|nl2br|_parser');
		
		return $this->form_validation->run();
	}

	function _error($msg=null) 
	{
		$json = array(
			'error' => true,
			'html' => (is_array($msg))? $msg : array($msg)
		);
		$this->_return_json($json);
		return false;
	}

	function _info($msg=null, $comment=null) 
	{
		$json = array(
			'error' => false,
			'html' => $msg,
			'comment' => $comment
		);
		$this->_return_json($json);
		return true;
	}

	function _return_json($json) 
	{
	    $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
	    $this->output->set_header("Pragma: no-cache");
		form_open(); //To generate a new csrf hash
		$json['csrf_token_name'] = $this->security->get_csrf_token_name();
		$json['csrf_hash'] = $this->security->get_csrf_hash();
		$this->security->csrf_set_cookie();
		$this->output->append_output(json_encode($json));
	}
}
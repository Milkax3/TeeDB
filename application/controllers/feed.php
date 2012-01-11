<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends CI_Controller {
	
	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
		
        $this->load->helper(array('xml', 'url'));
    	$this->load->library('template');
    }
    
    function index()
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = $this->template->header_data['title'];
        $data['feed_url'] = base_url();
        $data['page_description'] = $this->template->header_data['description'];
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'support (at) site (dot) com';
        
        //Example data:
        $data['posts'][0] = array(
        'post_date' => '1264426215877',
        'post_body' => 'blablablabalbalbalbla',
        'url_title' => '/news/tile',
        'post_title' => 'test blbabla'
        );
        
		header("Content-Type: application/rss+xml");
        $this->load->view('rss', $data);
    }
}

/* End of file feed.php */
/* Location: ./application/controllers/feed.php */
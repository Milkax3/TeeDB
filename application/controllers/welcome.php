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

class Welcome extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		$this->load->model(array('blog/blog', 'user/user', 'teedb/skin', 'teedb/common'));
	}
	
	public function index()
	{		
		$data['news_titles'] = $this->blog->get_latest_titles();
		$data['news'] = $this->blog->get_latest(1);
		$data['stats'] = $this->common->get_stats();
		$data['last_user'] = $this->user->get_last_user();
		$data['last'] = $this->common->getLastTeeDBEntries();
		
		$this->template->set_layout_data('nav', array('large' => TRUE, 'randomtee' => $this->skin->get_random()));
		$this->template->view('welcome', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
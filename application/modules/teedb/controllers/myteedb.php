<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MyTeeDB extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('user/auth');
		
		if($this->auth == NULL || !$this->auth->logged_in()) {
			redirect('user/login');
		}
		
		$this->load->library(array('pagination','form_validation'));
		$this->load->helper(array('rate','inflector'));
		$this->load->model(array('teedb/skin', 'teedb/mod', 'teedb/gameskin', 'teedb/tileset', 'teedb/demo', 'teedb/map'));
	}
	
	function index(){
		$this->skins();
	}

	function demos($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort(&$order, &$direction, &$from, 'demo', $this->demo->count_my_demos());
		
		$data = array();
		$data['skins'] = $this->demo->get_my_demos($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'demos';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function gameskins($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort(&$order, &$direction, &$from, 'gameskin', $this->gameskin->count_my_gameskins());
		
		$data = array();
		$data['skins'] = $this->gameskin->get_my_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'gameskins';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function mapres($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort(&$order, &$direction, &$from, 'mapres', $this->tileset->count_my_mapres());
		
		$data = array();
		$data['skins'] = $this->tileset->get_my_mapres($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mapres';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function maps($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort(&$order, &$direction, &$from, 'map', $this->map->count_my_maps());
		
		$data = array();
		$data['skins'] = $this->map->get_my_maps($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'maps';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function mods($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort(&$order, &$direction, &$from, 'mod', $this->mod->count_my_mods());
		
		$data = array();
		$data['skins'] = $this->mod->get_my_mods($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mods';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function skins($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort(&$order, &$direction, &$from, 'skin', $this->skin->count_my_skins());
		
		$data = array();
		$data['skins'] = $this->skin->get_my_skins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'skins';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}
	
	function _sort($order='new', $direction='desc', $from=0, $type='skin', $count=0)
	{
		if($type == 'mod') $type = 'modi';
		
		//Check input $order
		switch($order){
			case 'new': $sort = $type.'.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = $type.'.downloads'; break;
			case 'name': $sort = $type.'.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = $type.'.create';
		}
		
		if($type == 'modi') $type = 'mod';
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config['base_url'] = 'teedb/'.plural($type).'/index/'.$order.'/'.$direction;
		$config['total_rows'] = $count;
		$config['per_page'] = 20;
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
		
		return array($limit, $sort);
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */
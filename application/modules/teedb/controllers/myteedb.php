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
		
		$this->load->config('teedb/teedb');
	}
	
	function index(){
		$this->skins();
	}

	function demos($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'demo', $this->demo->count_my_demos());
		
		$data = array();
		$data['skins'] = $this->demo->get_my_demos($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'demos';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function gameskins($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'gameskin', $this->gameskin->count_my_gameskins());
		
		$data = array();
		$data['skins'] = $this->gameskin->get_my_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'gameskins';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function mapres($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'mapres', $this->tileset->count_my_mapres());
		
		$data = array();
		$data['skins'] = $this->tileset->get_my_mapres($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mapres';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function maps($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'map', $this->map->count_my_maps());
		
		$data = array();
		$data['skins'] = $this->map->get_my_maps($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'maps';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function mods($order='new', $direction='desc', $from=0){
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'mod', $this->mod->count_my_mods());
		
		$data = array();
		$data['skins'] = $this->mod->get_my_mods($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'mods';
		
		$this->template->set_subtitle('MyTeeDB');
		$this->template->view('myteedb', $data);
	}

	function skins($order='new', $direction='desc', $from=0)
	{
		$data = array();
		
		if($this->input->post('change') && $this->_name_validate('skinname', 'teedb_skins') === TRUE)
		{			
			$old_skinname = $this->skin->get_name($this->input->post('id'));
			
			$this->skin->change_name(
				$this->input->post('id'), 
				$this->input->post('skinname')
			);
			
			rename(
				$this->config->item('upload_path_skins').'/'.$old_skinname.'.png',
				$this->config->item('upload_path_skins').'/'.$this->input->post('skinname').'.png'
			);
			rename(
				$this->config->item('upload_path_skins').'/previews/'.$old_skinname.'.png',
				$this->config->item('upload_path_skins').'/previews/'.$this->input->post('skinname').'.png'
			);
			
			$data['changed'] = $old_skinname;
		}
		
		if($this->input->post('delete'))
		{			
			$skinname = $this->skin->get_name($this->input->post('id'));
			$data['delete'] = $skinname;
		}
		
		if($this->input->post('delete2'))
		{
			$skinname = $this->skin->get_name($this->input->post('id'));
			$this->skin->remove($this->input->post('id'));
			unlink($this->config->item('upload_path_skins').'/'.$skinname.'.png');
			unlink($this->config->item('upload_path_skins').'/previews/'.$skinname.'.png');
		}
		
		list($limit, $sort) = $this->_sort($order, $direction, $from, 'skin', $this->skin->count_my_skins());
		
		$data['skins'] = $this->skin->get_my_skins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		$data['type'] = 'skins';
		
		$this->template->set_subtitle('My Skins');
		$this->template->view('skins_edit', $data);
	}
	
	function _sort(&$order, &$direction, &$from, $type='skin', $count=0)
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
		$config['base_url'] = 'teedb/myteedb/'.plural($type).'/'.$order.'/'.$direction;
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

	private function _name_validate($input, $type)
	{
		$this->form_validation->set_rules('id', 'skin-ID', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules($input, $input, 'trim|required|alpha_numeric|min_length[3]|max_length[32]|unique['.$type.'.name]');

		return $this->form_validation->run();
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */
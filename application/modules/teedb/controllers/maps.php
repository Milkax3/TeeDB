<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maps extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->helper('rate');
		
		$this->load->model('teedb/map');
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'map.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'map.downloads'; break;
			case 'name': $sort = 'map.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'map.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config['base_url'] = 'teedb/maps/index/'.$order.'/'.$direction;
		$config['total_rows'] = $this->map->count_maps();
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
		
		//Set output
		$data = array();
		$data['maps'] = $this->map->get_maps($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Maps');
		$this->template->view('maps', $data);
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gameskins extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->helper('rate');
		
		$this->load->model('teedb/gameskin');
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'gameskin.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'gameskin.downloads'; break;
			case 'name': $sort = 'gameskin.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'gameskin.create';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config['base_url'] = 'teedb/gameskins/index/'.$order.'/'.$direction;
		$config['total_rows'] = $this->gameskin->count_gameskins();
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
		$data['gameskins'] = $this->gameskin->get_gameskins($limit, $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Gameskins');
		$this->template->view('gameskins', $data);
	}
}

/* End of file mapres.php */
/* Location: ./application/modules/teedb/controllers/mapres.php */
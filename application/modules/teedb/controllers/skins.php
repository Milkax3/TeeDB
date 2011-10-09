<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skins extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->helper('rate');
		
		$this->load->model('skin');
	}
	
	function index($order='new', $direction='desc', $from=0)
	{
		//Check input $order
		switch($order){
			case 'new': $sort = 'skin.update'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'skin.downloads'; break;
			case 'name': $sort = 'skin.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'skin.update';
		}
		
		//Check input $direction
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		//Init pagination
		$config['base_url'] = 'teedb/skins/'.$order.'/'.$direction;
		$config['total_rows'] = $this->skin->count_skins();
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		
		//Check input $form
		if(!is_numeric($from) || $from<0 || $from > $config['per_page'])
			$from=0;
		
		//Set output
		$data = array();
		$data['skins'] = $this->skin->get_skins($config['per_page'], $from, $sort, $direction);
		$data['direction'] = $direction;
		$data['order'] = $order;
		
		$this->template->set_subtitle('Skins');
		$this->template->view('skins', $data);
	}
}

/* End of file skins.php */
/* Location: ./application/modules/teedb/controllers/skins.php */
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('inflector');
		$this->load->config('teedb/teedb');
	}
	
	public function index($type='skins')
	{
		$this->template->set_subtitle('Upload '.$type);
		$this->template->view('upload', array('type' => $type));
	}
	
	public function skins()
	{
		$this->index('skins');
	}
	
	public function maps()
	{
		$this->index('maps');
	}
	
	public function demos()
	{
		$this->index('demos');
	}
	
	public function mapres()
	{
		$this->index('mapres');
	}
	
	public function gameskins()
	{
		$this->index('gameskins');
	}
	
	public function mods()
	{
		$this->index('mods');
	}
	
	function submit()
	{
		//var_dump($_FILES['file']['type'][0]);
		//return $this->_error('From '.$_FILES['file']['type'][0].' to '.preg_replace("/^(.+?);.*$/", "\\1", $_FILES['file']['type'][0]).' !');
		
		if($form_errors = validation_errors('','')) {
			return $this->_error($form_errors);	
		}
		
		if(!$this->input->post('type')) {
			return $this->_error('No type given.');
		} else {
			$type = $this->input->post('type');
		}
		
		switch($type){
			case 'skins': 
				$this->load->model('teedb/skin');
				$this->load->library('teedb/Skin_preview');
				$config['upload_path'] = './'.$this->config->item('upload_path_skins');
				$config['allowed_types'] = 'png';
				$config['max_size']	= '100'; //100kB
				$config['max_width']  = '256';
				$config['max_height']  = '128';
				$config['min_width']  = '256';
				$config['min_height']  = '128';
			break;
			case 'mapres':
				$this->load->model('teedb/tileset');
				$this->load->library('image_lib');
				$config['upload_path'] = './'.$this->config->item('upload_path_mapres');
				$config['allowed_types'] = 'png';
				$config['max_size']	= '1000'; //1MB
			break;
			case 'gameskins':
				$this->load->model('teedb/gameskin');
				$this->load->library('image_lib');
				$config['upload_path'] = './'.$this->config->item('upload_path_gameskins');
				$config['allowed_types'] = 'png';
				$config['max_size']	= '1000'; //1MB
				$config['max_width']  = '1024';
				$config['max_height']  = '512';
				$config['min_width']  = '1024';
				$config['min_height']  = '512';
			break;
			case 'maps':
				$this->load->model('teedb/map');
				//$this->load->library('teedb/Map_preview');
				$config['upload_path'] = './'.$this->config->item('upload_path_maps');
				$config['allowed_types'] = 'map';
				$config['max_size']	= '10000'; //10MB
			break;
			case 'demos':
				$this->load->model('teedb/demo');
				//$this->load->library('teedb/Demo_reader');
				$config['upload_path'] = './'.$this->config->item('upload_path_demos');
				$config['allowed_types'] = 'demo';
				$config['max_size']	= '10000'; //10MB
			break;
			default: 
				return $this->_error('Type incorret.');
		}
		
		if(!$this->auth->logged_in()){
			return $this->_error('You have to login.');
		}
		
		$this->load->library('upload', $config);
		
		$files = $_FILES['file'];
		$uploads = array();
		for($i = 0, $count = count($files['name']); $i < $count; $i++) {
			unset($_FILES['file']);
			$_FILES['file'] = array(
				'name' => $files['name'][$i], 
				'type' => $files['type'][$i], 
				'tmp_name' => $files['tmp_name'][$i], 
				'error' => $files['error'][$i], 
				'size' => $files['size'][$i]
			);
		
			if (!$this->upload->do_upload('file')){
				return $this->_error($this->upload->display_errors('', ''));
			}else{			
				$data = $this->upload->data();
				
				//Thumbnails
				if($type == 'skins'){
					if(!@$this->skin_preview->create($data['file_name'])){
						return $this->_error('Coudnt generate preview image.');
					}
					$data['preview'] = base_url().($this->config->item('upload_path_skins')).'/previews/'.$data['file_name'];
					$this->skin->setSkin($data['raw_name']);
				}elseif($type == 'mapres'){
					$configResize['source_image'] = $data['full_path'];
					$configResize['new_image'] = $config['upload_path'].'/previews/';
					$configResize['width'] = 110;
					$configResize['height'] = 64;
					
					$this->image_lib->initialize($configResize);
					if(!$this->image_lib->resize()){
						return $this->_error($this->image_lib->display_errors('', ''));
					}
					$this->image_lib->clear();
					$data['preview'] = base_url().($this->config->item('upload_path_mapres')).'/previews/'.$data['file_name'];
					$this->tileset->setMapres($data['raw_name']);
				}elseif($type == 'gameskins'){
					$configResize['source_image'] = $data['full_path'];
					$configResize['new_image'] = $config['upload_path'].'/previews/';
					$configResize['width'] = 110;
					$configResize['height'] = 64;
					
					$this->image_lib->initialize($configResize);
					if(!$this->image_lib->resize()){
						return $this->_error($this->image_lib->display_errors('', ''));
					}
					$this->image_lib->clear();
					$data['preview'] = base_url().($this->config->item('upload_path_gameskins')).'/previews/'.$data['file_name'];
					$this->gameskin->setGameskin($data['raw_name']);
				}elseif($type == 'maps'){
					//$this->map_preview->create($data['file_name']);
					$data['preview'] = base_url().($this->config->item('upload_path_maps')).'/previews/'.$data['raw_name'].'.png';
					$this->map->setMap($data['raw_name']);
				}elseif($type == 'demos'){
					//$this->demo_reader->getMap($data['file_name']);
					//$data['preview'] = base_url().($this->config->item('upload_path_maps')).'/previews/'.$data['raw_name'].'.png';
					$this->demo->setDemo($data['raw_name']);
				}
				$uploads[] = $data;
			}
		}
		return $this->_info('Upload sucessful.', $uploads);
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

	function _info($msg=null, $uploads=array()) 
	{
		$json = array(
			'error' => false,
			'html' => $msg,
			'uploads' => $uploads
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
	
	//-------------------------------------------------------
	
	function skins_submit()
	{
		if($this->input->post('name') === FALSE 
			or isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])){
			$this->file('skin');
			return;
		}
			
		if($this->_skin_validate() === FALSE) {
			$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
				'file_size' => $this->input->post('file_size'));
			$this->load->view('skin/upload', $data);
			return;
		}
		if($this->input->post('name') != $this->input->post('raw_name')){
			if(is_file('upload/skins/'.$this->input->post('name').'.png')){
				unlink('upload/skins/'.$this->input->post('name').'.png');
				unlink('upload/skins/previews/'.$this->input->post('name').'.png');
			}
			if(is_file('upload/skins/'.$this->input->post('raw_name').'.png')){
				rename('upload/skins/'.$this->input->post('raw_name').'.png', 
					'upload/skins/'.$this->input->post('name').'.png');
				rename('upload/skins/previews/'.$this->input->post('raw_name').'.png', 
					'upload/skins/previews/'.$this->input->post('name').'.png');
			}
		}
		$this->load->model('skin');
		$this->skin->setSkin();		
		$data['submit']=true;	
		$this->load->view('skin/upload', $data);
	}
	
	function _mapres()
	{
		if($this->input->post('name') === FALSE 
			or isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])){
			$this->file('mapres');
			return;
		}
			
		if($this->_mapres_validate() === FALSE) {
			$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
				'file_size' => $this->input->post('file_size'));
			$this->load->view('mapres/upload', $data);
			return;
		}
		if($this->input->post('name') != $this->input->post('raw_name')){
			if(is_file('upload/mapress/'.$this->input->post('name').'.png')){
				unlink('upload/mapress/'.$this->input->post('name').'.png');
				unlink('upload/mapress/previews/'.$this->input->post('name').'.png');
			}
			if(is_file('upload/mapress/'.$this->input->post('raw_name').'.png')){
				rename('upload/mapress/'.$this->input->post('raw_name').'.png', 
					'upload/mapress/'.$this->input->post('name').'.png');
				rename('upload/mapress/previews/'.$this->input->post('raw_name').'.png', 
					'upload/mapress/previews/'.$this->input->post('name').'.png');
			}
		}
		$this->load->model('Mapres');
		$this->Mapres->setMapres();		
		$data['submit']=true;	
		$this->load->view('mapres/upload', $data);
	}
	
	private function _skin_validate()
	{
		$this->form_validation->set_rules('name', 'Skinname',
			'required|alpha_numeric|min_length[3]|max_length[15]|unique[Skin.name]');
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');
		$this->form_validation->set_rules('file_size', 'Filesize',
			'required|numeric');

		return $this->form_validation->run();
	}
	
	private function _mapres_validate()
	{
		$this->form_validation->set_rules('name', 'Mapresname',
			'required|alpha_numeric|min_length[3]|max_length[15]|unique[Skin.name]');
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');
		$this->form_validation->set_rules('file_size', 'Filesize',
			'required|numeric');

		return $this->form_validation->run();
	}
	
	function skinpreview()
	{		
		if($this->_skinpreview_validate() === FALSE) {
			$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
				'file_size' => $this->input->post('file_size'));
			if($this->input->post('name'))
				$data['upload_data']['name'] = $this->input->post('name');
			$this->load->view('skin/upload', $data);
			return;
		}
		$data['upload_data'] = array('raw_name' => $this->input->post('raw_name'),
			'file_size' => $this->input->post('file_size'));
		if($this->input->post('name'))
			$data['upload_data']['name'] = $this->input->post('name');
		$data['refresh'] = TRUE;
		
		$this->load->library('teepreview');
		$this->teepreview->create_tee(base_url().'/upload/skins/'.$this->input->post('raw_name').'.png');	
		$this->load->view('skin/upload', $data);	
	}
	
	private function _skinpreview_validate()
	{
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');

		return $this->form_validation->run();
	}
}
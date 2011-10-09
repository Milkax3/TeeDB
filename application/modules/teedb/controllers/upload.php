<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller{

	function __constructor(){
		parent::__constructor();
		 
	}
	
	public function index($type)
	{
		$this->load->view('header', array('title' => 'Upload skins - TeeDB'));
		$this->load->view('nav');
		$this->load->view('upload', array('type' => $type));
		$this->load->view('footer');
	}
	
	function skins_submit(){
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
	
	function mapres(){
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
	
	function file($type){
		switch($type){
			case 'skin': 
				$config['upload_path'] = './upload/skin/';
				$config['allowed_types'] = 'png';
				$config['max_size']	= '100'; //100kB
				$config['max_width']  = '256';
				$config['max_height']  = '128';
				$config['min_width']  = '256';
				$config['min_height']  = '128';
				$error_view = 'skin/uploadfile';
				$view = 'skin/upload';
			break;
			case 'mapres':
				$config['upload_path'] = './upload/mapres/';
				$config['allowed_types'] = 'png';
				$config['max_size']	= '1000'; //1MB
				$error_view = 'mapres/uploadfile';
				$view = 'mapres/upload';
			break;
			default: 
				$msg = 'Type incorret.';
				$error_view = 'skin/uploadfile';
				$error = array('error' => '<p style="float:left;"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>'.$msg.'</p>');
				$this->load->view($error_view, $error);
				return;
		}
		
		if(!$this->auth->logged_in()){
			$msg = 'You have to login.';
			$error = array('error' => '<p style="float:left;"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>'.$msg.'</p>');
			$this->load->view($error_view, $error);
			return;
		}
		
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors('<p style="float:left;"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>', '</p>'));
			
			$this->load->view($error_view, $error);
		}else{			
			$data = $this->upload->data();
			
			//Thumbnails
			if($type == 'skin'){
				$this->load->library('teepreview');
				$this->teepreview->create_tee($data['full_path']);
			}
			if($type == 'mapres'){
				$configResize['source_image'] = $data['full_path'];
				$configResize['new_image'] = $config['upload_path'].'preview/';
				$configResize['width'] = 64;
				$configResize['height'] = 64;
				
				$this->load->library('image_lib', $configResize);				
				$this->image_lib->resize();
			}
			
			$upload_data = array('raw_name' => $data['raw_name'], 'file_size' => $data['file_size']);
			$this->load->view($view, array('upload_data' => $upload_data));
		}
	}
	
	private function _skin_validate(){
		$this->form_validation->set_rules('name', 'Skinname',
			'required|alpha_numeric|min_length[3]|max_length[15]|unique[Skin.name]');
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');
		$this->form_validation->set_rules('file_size', 'Filesize',
			'required|numeric');

		return $this->form_validation->run();
	}
	
	private function _mapres_validate(){
		$this->form_validation->set_rules('name', 'Mapresname',
			'required|alpha_numeric|min_length[3]|max_length[15]|unique[Skin.name]');
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');
		$this->form_validation->set_rules('file_size', 'Filesize',
			'required|numeric');

		return $this->form_validation->run();
	}
	
	function skinpreview(){		
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
	
	private function _skinpreview_validate(){
		$this->form_validation->set_rules('raw_name', 'Filename',
			'required|alpha_dash');

		return $this->form_validation->run();
	}
}
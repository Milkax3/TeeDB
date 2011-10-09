<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class teedb_Skin extends CI_Controller{

	function __constructor(){
		parent::__constructor();
	}
	
	function index(){
		$this->all();
	}
	
	function name($name=FALSE){
		if(!isset($name) or $name === FALSE)
			redirect('/');
		$this->load->model('Skin');
		$this->load->model('User');
		$data['view'] = 'skin/details';
		
		$this->jquery->addJqueryScript("	
			$('#commentForm').submit(function(){  	
				$.ajax({
					dataType: 'html',
	   				type: 'POST',
	  				url: '".base_url()."comments/submit/',
	   				data: $('#commentForm').serialize(),
	   				success: function(returned){
	   					if(returned.search(/ui-state-highlight/) != -1){
	   						var html = returned.split(/<TRENNER>/g);
	   						$('.errorBox').html(html[0]);
			  				$('#comments div.main').prepend(html[1]);
						}else{				       	
	   						$('.errorBox').html(returned);	
	   					}
					}
	 			});
	 		});
		");
		$this->_report();
		
		if(!$data['data']['skin'] = $this->Skin->getSkinByName($name))
			redirect('/');		
		$this->_Common('skin',$this->Skin->hasRate($data['data']['skin']->id));
		$data['data']['comments'] = $this->Skin->getComments($data['data']['skin']->id);	
		$this->load->view('html_main', $data);
	}
}
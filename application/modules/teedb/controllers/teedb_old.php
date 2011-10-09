<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teedb extends CI_Controller{

	function __constructor(){
		parent::__constructor();		
	}
					
	function _report(){
		$this->jquery->addJqueryScript("	
			$('#report_send').click(function(){  	
				$.ajax({
					dataType: 'html',
	   				type: 'POST',
	  				url: '".base_url()."reports/submit/',
	   				data: $('#reportForm').serialize(),
	   				success: function(returned){
						$('.errorReport').html(returned);
						if(returned.search(/class=\"dialog-info\"/) != -1){
			   				$('#form').hide();
			   				$('#report_send').unbind();
			                $('#report_send button span').text('OK');
			                $('#report_send').click(function() {
			                	$('#dialog-report').dialog('close');
			                });
				       	}
					}
	 			});
	 		});
	 		$('#dialog-report input').click(function(){
				if ($('#other:checked').size()) {
					$('#reportText').show();
					$('#reportText').val('Reason here...');
				}else if ($('#stolen:checked').size()) {
					$('#reportText').show();
					$('#reportText').val('Proof here...');
				}else{
					$('#reportText').hide();				
				}
			});   		 		
	 		$('.report').click(function(){
				$('#dialog-report').dialog('open');
			});   	
			$('#dialog-report').dialog({
				autoOpen: false,
				modal: true,
				width: 287 
			});	
		");	
	}
	
	function rate(){
		$id = $this->input->post('id');
		
		switch($this->input->post('type')){
			case 'skin': $type = 'skin'; break;
			case 'mapres': $type = 'mapres'; break;
			default: return FALSE;
		}
		
		if($this->input->post('rate')!= 1 and $this->input->post('rate') != 0)
			return FALSE;
			
		$this->load->Model('Rate');
		$this->config->set_item('compress_output', FALSE);
		echo ($this->Rate->setRate($type, $id, $this->input->post('rate'))*10);
	}
	
	function download($type, $name){
		switch($type){
			case 'skin': $file = 'upload/skins/'.$name.'.png'; break;
			case 'mapres': $file = 'upload/mapress/'.$name.'.png'; break;
			default: redirect('/');
		}
		if(is_file($file) and $data = file_get_contents($file)){ //austausch file_exists => is_file | performance
			$this->load->helper('download');
			$this->load->Model('download');
			$this->download->increment($type, $name);
			force_download($name.'.png', $data);
		}else{
			redirect('/'); //TODO: file coundn't found message here
		}
	}
}

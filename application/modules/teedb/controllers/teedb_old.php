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
}

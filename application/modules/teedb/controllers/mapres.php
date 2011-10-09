<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mapres extends Admin_Controller{

	function __constructor(){
		parent::__constructor();		
	}
	
	function index($order='new', $direction='desc', $from=0){
		$this->load->model('Mapres');
		$this->load->library('pagination');
		
		$per_page = 20;
		$max = $this->Mapres->countMapres();
						
		switch($order){
			case 'new': $sort = 'mapres.update'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = 'mapres.downloads'; break;
			case 'name': $sort = 'mapres.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = 'mapres.update';
		}		
		switch($direction){
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		if(!is_numeric($from) || $from<0 || $from > $max)
			$from=0;
		
		$this->_Common('mapres');
		
		$config['base_url'] = base_url().'/teedb/mapres/'.$order.'/'.$direction;
		$config['total_rows'] = $max;
		$config['per_page'] = $per_page;		
		$config['num_links'] = 5;
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		
		$data['view'] = 'mapres/overview';
		
		$data['data']['mapres'] = $this->Mapres->getMapres($per_page, $from, $sort, $direction);
		$data['data']['direction'] = $direction;
		$data['data']['order'] = $order;
		
		$this->load->view('html_main', $data);
	}	
	
	function _Common($type, $hasRate=0){
		$this->jquery->addJqueryScript("	
			var vote = ".$hasRate.";
					
			$('.top').click(function() {
				var section = $(this).parents('section.".$type.":eq(0)');
				var id = section.attr('id');
				var rate = section.find('.rate');
				
				sendRate(id, 1, rate);
			});			
			$('.flop').click(function() {
				var section = $(this).parents('section.".$type.":eq(0)');
				var id = section.attr('id');
				var rate = section.find('.rate');
				
				sendRate(id, 0, rate);
			});	
			function sendRate(id, value, rate){
				$.ajax({
	   				type: 'POST',
	  				url: '".base_url()."teedb/rate/',
	   				data: 'type=".$type."&id='+id+'&rate='+value,
	   				success: function(returned){
	   					if(returned){
	   						if(!rate.find('span#value').size())
								rate.find('span').text(returned);
							else{
								rate.find('span#value').text(returned);
								var votes = rate.find('span#votes').text();
								if(!vote){								
									if(!value)
										rate.find('div.rating_bar').attr('class','rating_bar_bad');
									rate.find('span#votes').text(parseInt(votes) + 1);
									vote = 1;
								}
								rate.find('div#ratebar').css('width', (returned*8)+'px');
							}
						}
					}
	 			});
			}
			$('#upload').click(function(){
				$('#dialog-upload').dialog('open');
			});   	
			var refreshClose = 0;
			$('#dialog-upload').dialog({
				autoOpen: false,
				modal: true,
				width: 287, /*320*/
				close: function(event, ui) { 
					if(refreshClose)
						location.reload();
				}
			});	
			$('#upload_".$type."').click(function() {
				$('#dialog-upload form').ajaxSubmit({
					type: 'POST',
		  			url: '".base_url()."upload/".$type."/',
					iframe: true,
	        		success: function(returned){ 
	   					$('#dialog-upload form').html(returned);
	   					$('#fileupload').customFileInput();
	   					$('#fileupload').css('top', '64px');
	   					
	   					if($('#info').size()){
	   						var errWidth = $('#info').css('height');
	   						errWidth = parseInt(errWidth.replace(/px/g,''))+ 18+64;
	   						$('#dialog-upload .customfile-input').css('top', errWidth + 'px');	
	   					}
	   					
	   					if($('.dialog-info').size()){
	   						var errWidth = $('#dialog-upload .customfile-input').css('top');
	   						errWidth = parseInt(errWidth.replace(/px/g,''))+ 18;
	   						$('#dialog-upload .customfile-input').css('top', errWidth + 'px');	
	   					}

	   					$('#refreshPreview').click(createPreview);
	   						
	   					if(returned.search(/class=\"dialog-info\"/) != -1){
			   				refreshClose = 1;
				       	}
	        		} 
	        	});
        	});
        	function createPreview(){
				$('#dialog-upload form').ajaxSubmit({
					type: 'POST',
		  			url: '".base_url()."upload/".$type."preview/',
	        		success: function(returned){ 
	   					$('#dialog-upload form').html(returned);
	   					$('#fileupload').customFileInput();
	   					$('#fileupload').css('top', '64px');
	   					
	   					if($('#info').size()){
	   						var errWidth = $('#info').css('height');
	   						errWidth = parseInt(errWidth.replace(/px/g,''))+ 18+64;
	   						$('#dialog-upload .customfile-input').css('top', errWidth + 'px');	
	   					}

	   					$('#refreshPreview').click(createPreview);
	   						
	   					if(returned.search(/class=\"dialog-info\"/) != -1){
			   				refreshClose = 1;
				       	}
	        		} 
	        	});
        	}
        	$('#fileupload').customFileInput();
		");
		$this->jquery->addExternalScript('jquery.form.js');
		$this->jquery->addExternalScript('jquery.fileinput.js');
	}
}

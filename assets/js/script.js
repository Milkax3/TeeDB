/* Author: Andreas Gehle */

function inputFocus(){
	console.log('focus');
	$('#loginName').focus();
	console.log('focusend');
}

adslider(4);

$('nav > ul > li').mouseover(navOpen);
$('nav > ul > li').mouseout(navTimer);




var vote = 0;
					
$('.top').click(function() {
	var section = $(this).parents('section.skin:eq(0)');
	var id = section.attr('id');
	var rate = section.find('.rate');
	
	sendRate(id, 1, rate);
});			

$('.flop').click(function() {
	var section = $(this).parents('section.skin:eq(0)');
	var id = section.attr('id');
	var rate = section.find('.rate');
	
	sendRate(id, 0, rate);
});	

function sendRate(id, value, rate){
	$.ajax({
		type: 'POST',
		url: 'teedb/rate',
		data: 'type=skin&id='+id+'&rate='+value,
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

$('#upload_skin > button#button').click(function() {
	form_submit('skin');
});

function form_submit(type){
	$('#dialog-upload form').ajaxSubmit({
		type: 'POST',
		url: 'teedb/upload/'+type,
		iframe: true,
		success: function(returned){
			$('#dialog-upload form').html(returned);
			$('#fileupload').customFileInput();
			$('#fileupload').css('top', '64px');
			
			if($('#info').size()){
				var errWidth = $('#info').css('height');
				errWidth = parseInt(errWidth.replace('px',''))+ 18+64;
				$('#dialog-upload .customfile-input').css('top', errWidth + 'px');	
			}
			
			if($('.dialog-info').size()){
				var errWidth = $('#dialog-upload .customfile-input').css('top');
				errWidth = parseInt(errWidth.replace('px',''))+ 18;
				$('#dialog-upload .customfile-input').css('top', errWidth + 'px');	
			}

			$('#refreshPreview').click(createPreview);
				
			if(returned.search('class="dialog-info"') != -1){
   				refreshClose = 1;
	       	}
		} 
	});
}

function createPreview(){
	$('#dialog-upload form').ajaxSubmit({
		type: 'POST',
		url: 'upload/skinpreview/',
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























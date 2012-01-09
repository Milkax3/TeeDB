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

$('form#upload button').click(function(){
	$('form#upload').ajaxSubmit({
		type: 'POST',
		url: 'teedb/upload/submit',
    	dataType: 'json',
		success: function(json){
			//Clean old info
			$('#info').html('');
			//Write new info
			if(json.error) {
				for(var i in json.html)	{
					$('#info').append(
						'<p class="error color border"><span class="icon color icon100"></span>'+
						json.html[i] +
						'</p>'
					);
				}
			}else{
				console.log(json.uploads);
				$('#info').html(
					'<p class="success color border"><span class="icon color icon101"></span>'+
					json.html +
					'</p>'
				)
				//.delay(5000).hide('drop', 2000, function () { $(this).remove();	})
      			;
				
				for(var i in json.uploads) {
					$('#list > ul').append(
						'<li>'+
							'<ul><li class="delete" href="Delete"><span class="icon icon56"></span></li>'+
							'<li class="refresh" href="Refresh"><span class="icon icon158"></span></li></ul>'+
							'<img src="'+json.uploads[i].preview+'" href="'+json.uploads[i].raw_name+' preview" />'+
							'<p>'+
								json.uploads[i].raw_name +
							'</p>'+
						'</li>'
					);
				}
				// $('#list').append(
					// '<li class="clear"></li>'
				// );
				//Clear the form
				$('input[name="file[]"]').val('');
			}
			//Set new csrf
			$('input[name="'+json.csrf_token_name+'"]').val(json.csrf_hash);
		},
		error: function(e){
			$('#info').html(
				'<p class="error color border"><span class="icon color icon100"></span>'+
				e.responseText +
				'</p>'
			);
		}
	});
});

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

//$('#fileupload').customFileInput();

       
function createUploader(node){            
    var uploader = new qq.FileUploader({
        element: node,
        action: '/teedb/upload/file',
        debug: true
    });
}

if(node = document.getElementById('file-uploader'))
	createUploader(node);























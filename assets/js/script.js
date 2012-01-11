/* Author: Andreas Gehle */

//Build Ad-Slider
adslider(4);

//Bind menu mousehover
$('nav > ul > li').mouseover(navOpen);
$('nav > ul > li').mouseout(navTimer);


//Bind tops
var vote = 0;
var lock = 0;
$('.top').click(function(){
	if(!lock && vote != 1){
		lock = 1;
		sendRate($(this), 1);
		vote = 1;
	}
});

//Bind flops
$('.flop').click(function() {
	if(vote != 2 && !lock){
		lock = 1;
		sendRate($(this), 0);
		vote = 2;
	}
});

//Ajax Rating
function sendRate(obj, value){
	var parent = obj.parents('li:eq(0)');
	var like = parent.find('.like:eq(0)');
	var dislike = parent.find('.dislike:eq(0)');
	
	obj.ajaxSubmit({
		type: 'POST',
		url: 'teedb/rates',
    	dataType: 'json',
		success: function(json){
			if(json){
				//Set new csrf
				$('input[name="'+json.csrf_token_name+'"]').val(json.csrf_hash);
				
				//Need login
				if(!json.like || !json.dislike){
					
					$('#info').append(
						'<p class="error color border"><span class="icon color icon100"></span>'+
						'You have to login.' +
						'</p>'
					);
					return;
				}
				
				//Update chartbar
				like.css('width', json.like);
				dislike.css('width', json.dislike);
				
				var num;
				
				if(value != json.has_rated){
					if(value){
						num = parseInt(like.text());
						like.text(num +1);
						if(json.has_rated >= 0){
							num = parseInt(dislike.text());
							dislike.text(num -1);
						}
					}else{
						num = parseInt(dislike.text());
						dislike.text(num +1);
						if(json.has_rated >= 0){
							num = parseInt(like.text());
							like.text(num -1);
						}
					}
				}
				//Rest lock
				lock = 0;
			}
		}
	});
}

//Ajax Uploader
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
				$('#info').html(
					'<p class="success color border"><span class="icon color icon101"></span>'+
					json.html +
					'</p>'
				);
				
				for(var i in json.uploads) {
					$('#list > ul').append(
						'<li>'+
							'<div style="width:110px; height:64px">'+
								'<img src="'+json.uploads[i].preview+'" href="'+json.uploads[i].raw_name+' preview" />'+
							'</div>'+
							'<p>'+
								json.uploads[i].raw_name +
							'</p>'+
						'</li>'
					);
				}
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
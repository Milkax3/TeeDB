/* Author: Andreas Gehle */

//Build Ad-Slider
adslider(4);

//Bind menu mousehover
$('nav > ul > li').mouseover(navOpen);
$('nav > ul > li').mouseout(navTimer);


//Bind tops and flops
var vote = 0;
var lock = 0;

$('.top').click(function(){
	if(!lock && vote != $(this)){
		lock = 1;
		sendRate($(this), 1);
		vote = $(this);
	}
});

$('.flop').click(function() {
	if(!lock && vote != $(this)){
		lock = 1;
		sendRate($(this), 0);
		vote = $(this);
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

//Ajax comment
$('form#comment button').click(function(){
	$('form#comment').ajaxSubmit({
		type: 'POST',
		url: 'blog/news/submit',
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
				
				$('#lister ul > br').first().after(
					'<li style="height: 90px">'+
						'<time style="padding:0;" datetime="'+ISODateString(new Date())+'">'+
							'Today'+
						'</time><br/>'+
						'<span class="none solid">You</span>'+
					'</li>'+
					'<li style="width: 496px; margin-left:15px; text-align: left;">'+
						$('textarea[name="comment"]').val()+
					'</li>'+
					'<br class="clear" />'
				);
				
				$('textarea[name="comment"]').val('');
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

function ISODateString(d) {
    function pad(n){
        return n<10 ? '0'+n : n
    }
    return d.getUTCFullYear()+'-'
    + pad(d.getUTCMonth()+1)+'-'
    + pad(d.getUTCDate())+'T'
    + pad(d.getUTCHours())+':'
    + pad(d.getUTCMinutes())+':'
    + pad(d.getUTCSeconds())+'Z'
}
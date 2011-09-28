//TODO: Write function in jquery plugin pattern
/*
section#AdLeiste div.slider1{background: url(images/slider/Teeplanet.jpg) no-repeat; }
section#AdLeiste div.slider2{background: url(images/slider/Teeworlds.jpg) no-repeat; }
section#AdLeiste div.slider3{background: url(images/slider/Teewit.jpg) no-repeat; }
section#AdLeiste div.slider4{background: url(images/slider/Teewiki.jpg) no-repeat; }

div#AdContent:
		<div class="Box" id="s0" style="display:none;"><div class="slider4"><a target="_blank" href="http://teewiki.info/"></a></div></div>
		<div class="Box" id="s1"><div class="slider1"><a target="_blank" href="http://news.teesites.net/"></a></div></div>
		<div class="Box" id="s2"><div class="slider2"><a target="_blank" href="http://www.teeworlds.com/"></a></div></div>
		<div class="Box" id="s3"><div class="slider3"><a target="_blank" href="http://news.teesites.net/teewit/"></a></div></div>
		<div class="Box" id="s4"><div class="slider4"><a target="_blank" href="http://teewiki.info/"></a></div></div>
		<div class="Box" id="s5" style="display:none;"><div class="slider1"><a target="_blank" href="http://news.teesites.net/"></a></div></div>
 */
function adslider(max){   
    var path, prev, next, links, images;
   	path = "images/slider/";
   	links = new Array('news.teesites.net', 'www.teeworlds.com', 'news.teesites.net/teewit', 'teewiki.info');
   	images = new Array('Teeplanet.jpg', 'Teeworlds.jpg', 'Teewit.jpg', 'Teewiki.jpg');

   	//init and error handling:
   	if(links.length != images.length){
   		console.log("AdSlieder: Length of image and link list doesnt match!");
   		if(links.length > images.length){
   			for(i=1;i<=(links.length - images.length);i++)
   				links.pop();
   		}else{
   			for(i=1;i<=(images.length - links.length);i++)
   				links.push('#NoLink')
   		}
   	}
   	if(links.length<max){
   		console.log("AdSlieder: Number of viewing images exceed the count of avaible images!");
   		max = links.length;
   	}
   	
   	prev = 0;
   	next = max+1;
   	
   	//Build html
   	$('div#AdContent').html('<div class="Box" id="s0" style="display:none;"><div class="slider'+links.length+'" style="background: url('+path+images[links.length-1]+') no-repeat"><a target="_blank" href="http://'+links[links.length-1]+'"></a></div></div>');
   	for(i=1;i<=max;i++){
   		$('div#AdContent').append('<div class="Box" id="s'+i+'"><div class="slider'+i+'" style="background: url('+path+images[i-1]+') no-repeat"><a target="_blank" href="http://'+links[i-1]+'"></a></div></div>');
   	}
   	if(max+1>links.length)
   		last = 0;
   	else
   		last = max+1;
	$('div#AdContent').append('<div class="Box" id="s'+next+'" style="display:none;"><div class="slider'+(max+1)+'" style="background: url('+path+images[last]+') no-repeat"><a target="_blank" href="http://'+links[last]+'"></a></div></div>');

	//Events
	$('#ArrowLeft').click(function(){left();});	
	$('#ArrowRight').click(function(){right();});
	
	function left(){
		$('#ArrowRight').unbind();
		$('#ArrowLeft').unbind();
		
		$('#s'+next).show('slow', function() {
			slider = $(this).find('div').attr('class');
			sliderNr = slider.replace("slider","");
			if(sliderNr+1 > links.length){
				sliderNr = 0;
				image = links.length-1;
			}else{
				sliderNr++;
				image = sliderNr-1;
			}
			next++;
			$('div#AdContent').append('<div class="Box" id="s'+next+'" style="display:none;"><div class="slider'+sliderNr+'" style="background: url('+path+images[image]+') no-repeat"><a target="_blank" href="http://'+links[image]+'"></a></div></div>');

			$('#ArrowLeft').click(function(){left();});	
			$('#ArrowRight').click(function(){right();});
		});
		
		$('#s'+(prev+1)).hide('slow', function() {
			$('#s'+prev).remove();
			prev++;	
		});
	}
	
	function right(){
		$('#ArrowRight').unbind();
		$('#ArrowLeft').unbind();
		
		$('#s'+prev).show('slow', function() {
			slider = $(this).find('div').attr('class');
			sliderNr = slider.replace("slider","");
			if(sliderNr-1<0){
				sliderNr = links.length;
				image = sliderNr-1;
			}else{
				sliderNr--;
				if(sliderNr==0)
					image = links.length-1;
				else
					image = sliderNr-1;					
			}
			prev--;
			$('div#AdContent').prepend('<div class="Box" id="s'+prev+'" style="display:none;"><div class="slider'+sliderNr+'" style="background: url('+path+images[image]+') no-repeat"><a target="_blank" href="http://'+links[image]+'"></a></div></div>');
			
			$('#ArrowLeft').click(function(){left();});	
			$('#ArrowRight').click(function(){right();});
		});
		
		$('#s'+(next-1)).hide('slow', function() {
			$('#s'+next).remove();
			next--;	
		});
	}
}
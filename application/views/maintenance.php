<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Coming soon - TeeDB</title>
  <meta name="description" content="Teeworlds Database">
  <meta name="author" content="Andreas Gehle">
  
  <base href="<?php echo base_url(); ?>">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="alternate" type="application/rss+xml" href="feed/" title="RSS feed for TeeDB">
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
  <link rel="shortcut icon" type="image/x-icon" href="assets/favicon.ico">
  <link rel="apple-touch-icon" type="image/x-icon" href="assets/apple-touch-icon.png">

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="assets/css/maintrance.css">
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="assets/js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>
	
	<div id="wrapper">
		
		<div id="logo">TeeDB</div>
	    <div style="clear:both"></div>
	    <h3>Teeworlds Database Coming Soon!</h3>
	    <div id="frame">
	    	<div id="sizewrap">
	    
	        	<h1>WE ARE WORKING HARD TO LAUNCH IT</h1>
	        	<h2>New look, new features and a faster interface!</h2>
	    
	        	<div id="clock">
	            	<div class="block"><span id="weeks"></span>WEEKS</div>
	                <div class="space">&nbsp;</div>	            
	            	<div class="block"><span id="daysLeft"></span>DAYS</div>
	                <div class="space">&nbsp;</div>	            
	            	<div class="block"><span id="hours"></span>HOURS</div>
	                <div class="space">&nbsp;</div>	            
	            	<div class="block"><span id="minutes"></span>MINUTES</div>
	                <div class="space">&nbsp;</div>	            
	            	<div class="block"><span id="seconds"></span>SECONDS</div>
	        	</div>
	        
	        	<div style="clear:both"></div>
	        
	        </div>
	    </div>
	    
	    <div id="footer">
			TeeDB &copy; Copyright <?php echo date("Y"); ?> | Disclaimer All Rights Reserved | Privacy Policy - Page rendered in {elapsed_time} seconds
	    </div>
	                
  </div>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="assets/js/libs/jquery-1.6.4.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script type="text/javascript" src="assets/js/libs/cufon-yui.js"></script>
  <script type="text/javascript" src="assets/js/League.Gothic.font.js"></script>
  <script src="assets/js/mylibs/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
	$(document).ready(function() {	
		Cufon.replace('h1,h2,h3,#logo');
		
		$(function() {
			$('div#clock').countdown("<?php echo $date; ?>" , function(event) {
				var $this = $(this);
				switch(event.type) {
					case "seconds":
					case "minutes":
					case "hours":
					case "days":
					case "weeks":
					case "daysLeft":
						$this.find('span#'+event.type).html(event.value);
						break;
					case "finished":
						$this.hide();
						break;
				}
			});
		});	
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
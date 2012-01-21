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

  <title>Update - TeeDB</title>
  <meta name="description" content="Teeworlds, TeeDB, Database, skin, mods, mapres, gameskins, demos, ">
  <meta name="author" content="kugel">
  
  <base href="<?php echo base_url(); ?>">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="alternate" type="application/rss+xml" href="feed/" title="RSS feed for TeeDB">
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
  <link rel="shortcut icon" type="image/x-icon" href="assets/favicon.ico">
  <link rel="apple-touch-icon" type="image/x-icon" href="assets/apple-touch-icon.png">

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
  	body{
		color: #3A2B1B;
		background-color: #A16E36;
  	}
  	#wrapper{
  		text-align: center;
  		margin: auto; 
  		position: relative; 
  		width: 800px
  	}
  	table{
  		width: 800px;
  	}
  	th{ 
  		background-color: #3B2B1C; 
  		color: #A16E36; 
  	}
  	td{ 
  		background-color: #543F24; 
  		color: #FFC96C;
  	}

	h2{	
		color: #A16E36;
		margin: 10px, 0px;
		background-color: #543f24;
		border: 5px solid #543f24;
		border-radius: 6px;	
		-moz-border-radius: 6px; 
		-webkit-border-radius: 6px;
		padding: 0 20px;
	}
  </style>
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="assets/js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>
	
	<div id="wrapper">
		
		<img src="assets/images/logo.png" alt="Logo">
		
		<h2>TeeDB update!</h2>
		
		<p>
			Last steps to a new version of TeeDB. Translate old TeeDB data to new one.
		<p/>
		
		<h2>Data dismatched upload/register rules:</h2>
		
		<table cellspacing="10">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Type</th>
					<th>Reason</th>
				</tr>
			</thead>
			<tbody>				
				<tr>
					<td>1</td>
					<td>Picachu</td>
					<td>Skin</td>
					<td>Dismatched minimum or maximum size of 256x125</td>
				</tr>			
				<tr>
					<td>2</td>
					<td>Blubb(&%)</td>
					<td>User</td>
					<td>No Symbols allowed in name</td>
				</tr>
			</tbody>
		</table>
		
	</div>
	
	<!-- Change UA-XXXXX-X to be your site's ID -->
	<script>
		window._gaq = [['_setAccount','<?php echo $google_analytic_id; ?>'],['_trackPageview'],['_trackPageLoadTime']];
	    Modernizr.load({
	      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
	    });
	</script>


	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
		chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
		<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	
</body>
</html>
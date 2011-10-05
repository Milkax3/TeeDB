	<?php if(!isset($large) OR !$large): ?>
	</section><!-- Closing the #center section -->
	
	<div class="image_border open">
		<div class="center trans_border open"></div>
	</div>
	
	<div class="wrapper dark">
		<div class="center transition min"></div>
	</div>
	<?php endif; ?>
	
	<div class="image_border close">
		<div class="center trans_border close"></div>
	</div>

	<footer id="main" class="wrapper light">
		<p class="center">
			<?php echo $title; ?> &copy; Copyright <?php echo date("Y"); ?> | Disclaimer All Rights Reserved | Privacy Policy - Page rendered in {elapsed_time} seconds
		</p>
	</footer>

	<!-- JavaScript at the bottom for fast page loading -->

 	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
 	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="assets/js/libs/jquery-1.6.4.min.js"><\/script>')</script>


 	<!-- scripts concatenated and minified via ant build script-->
 	<script defer src="assets/js/libs/jquery-ui-1.8.16.min.js"></script>
 	<script defer src="assets/js/plugins.js"></script>
 	<script defer src="assets/js/mylibs/jquery.adslider.js"></script>
 	<script defer src="assets/js/mylibs/jquery.fileinput.js"></script>
 	<script defer src="assets/js/mylibs/jquery.form.js"></script>
	<script defer src="assets/js/mylibs/jquery.nav.js"></script>
  	<script defer src="assets/js/script.js"></script>
  	<!-- end scripts-->

	
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
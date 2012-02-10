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
	<p class="center" style="padding: 0">
		TeeDB &copy; Copyright <?php echo date("Y"); ?> | Disclaimer All Rights Reserved | Privacy Policy - Page rendered in {elapsed_time} seconds
	</p>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url('assets/js/libs/jquery-1.7.1.min.js'); ?>"><\/script>')</script>

<!-- scripts concatenated and minified via ant build script-->
<script src="<?php echo base_url('assets/js/libs/bootstrap/transition.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/libs/bootstrap/collapse.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/mylibs/jquery.adslider.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/mylibs/fileuploader.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/mylibs/jquery.form.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/mylibs/jquery.nav.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
<!-- end scripts-->

<script>
	var _gaq=[['_setAccount','<?php echo $google_analytic_id; ?>'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url('assets/js/libs/jquery-1.7.1.min.js'); ?>"><\/script>')</script>

<!-- scripts concatenated and minified via ant build script-->
<script src="<?php echo base_url('assets/js/libs/bootstrap/transition.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/libs/bootstrap/collapse.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
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
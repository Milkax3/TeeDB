<?php if(isset($error) && $error): ?>
	<div class="ui-widget" id="info">
		<div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all"> 
			<?php echo  $error; ?>
			<div style="clear:both;"></div>
		</div>
	</div>
	<br />
<?php endif; ?>

<b>Skin:</b> 
<?php //echo form_upload('file',set_value('file'), 'id="fileupload"'); ?>
<div class="customfile"><span aria-hidden="true" class="customfile-button">Browse</span><span aria-hidden="true" class="customfile-feedback">No file selected...</span><input type="file" id="fileupload" value="" name="file" class="customfile-input"></div>
<?php if(validation_errors()): ?>
	<div class="ui-widget" id="info">
		<div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all"> 
			<?php echo  validation_errors('<p style="float:left;"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>', '</p>'); ?>
			<div style="clear:both;"></div>
		</div>
	</div>
	<br />
<?php endif; ?>
<?php if(isset($refresh) && $refresh === TRUE): ?>
	<div class="ui-widget" id="info">
		<div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em;">
			<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
				Skinpreview refreshed.
			</p>
		</div>
	</div>
	<br />
<?php endif; ?>
<?php if(isset($submit) && $submit===true): ?>
	<div class="dialog-info" class="ui-widget" id="info">
		<div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em;">
			<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
				Your Teeskin was sucsessfully uploaded.
			</p>
		</div>
	</div>
	<br>
	<p>One more...</p>
	<?php $this->load->view('skin/uploadfile'); ?>
<?php else: ?>
<?php echo form_hidden('raw_name',$upload_data['raw_name']); ?>
<?php echo form_hidden('file_size',$upload_data['file_size']); ?>
	<b>Skin:</b> 
	<?php //echo form_upload('file',set_value('file'), 'id="fileupload"'); ?>
	<div class="customfile"><span aria-hidden="true" class="customfile-button">Browse</span><span aria-hidden="true" class="customfile-feedback">No file selected...</span><input type="file" id="fileupload" value="" name="file" class="customfile-input"></div>
	<br>
	<hr>
	<br>
	<b>Name:</b><br>
	<?php echo form_input('name',set_value('name',(isset($upload_data['name']))? $upload_data['name'] : $upload_data['raw_name'])); ?>
	<br><br>
	<img src="<?php echo base_url()."upload/skin/preview/".$upload_data['raw_name']; ?>.png" alt="Preview" style="float:left;">
	<div style="float: left; font-size:13px; margin-left: 20px">
		<?php echo $upload_data['raw_name']; ?>.png<br />
		Size <?php echo $upload_data['file_size']; ?>kB<br />
		<span id="refreshPreview" class="click">refresh preview</span>
	</div>
	<br style="clear: both;" />
	<div style="/*background-image: url('images/transparentz.jpg');*/ width:256px; height:128px; margin: auto;">
		<img src="<?php echo base_url()."upload/skin/".$upload_data['raw_name']; ?>.png" alt="Skin">
	</div>
<?php endif; ?>
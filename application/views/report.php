<div class="errorReport"></div>
<div id="form">
	<?php echo form_hidden('type',$type); ?>
	<?php echo form_hidden('id',$id); ?>
	<h2><b>Report</b> <?php echo $name.' '.$type; ?></h2><br />
	<?php echo form_radio('report', 'Bug', TRUE); ?> Bug!<br />
	<?php echo form_radio('report', 'Content', TRUE); ?> Wrong Content!<br />
	<?php echo form_radio('report', 'Language', TRUE); ?> Language!<br />
	<?php echo form_radio('report', 'Stolen', '', 'id="stolen"'); ?> Stolen!<br />
	<?php echo form_radio('report', 'Other', '','id="other"'); ?> Other Reason<br />
	<?php echo form_textarea('reportText',set_value('reportText'), 'id="reportText" style="display:none;"'); ?>
</div>
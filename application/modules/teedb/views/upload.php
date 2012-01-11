<aside>	
	<h2>Wrong upload form?</h2>
	<ul>
		<?php if($type != 'demos'): ?><li><?php echo anchor('teedb/upload/demos', 'Demo form'); ?></li><?php endif; ?>
		<?php if($type != 'gameskins'): ?><li><?php echo anchor('teedb/upload/gameskins', 'Gameskin form'); ?></li><?php endif; ?>
		<?php if($type != 'mapres'): ?><li><?php echo anchor('teedb/upload/mapres', 'Mapres form'); ?></li><?php endif; ?>
		<?php if($type != 'maps'): ?><li><?php echo anchor('teedb/upload/maps', 'Map form'); ?></li><?php endif; ?>
		<?php if($type != 'skins'): ?><li><?php echo anchor('teedb/upload/skins', 'Skin form'); ?></li><?php endif; ?>
	</ul>
	<h2>Change uploads?</h2>
	<ul>
		<li><?php echo anchor('teedb/user/myteedb', 'My TeeDB'); ?></li>
	</ul>
</aside>

<section id="content">
	<section id="uploader">		
		<h2><?php echo ($type == 'mapres')? 'Mapres' : ucfirst(singular($type)); ?> upload</h2>
		
		<div id="info">
			<?php echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'); ?>
		</div>
		
		<?php echo validation_errors('<p class="error">','</p>'); ?>
		
		<?php echo form_open_multipart('teedb/upload/submit', array('id' => 'upload'), array('type' => $type)); ?>
		
		<?php echo form_upload('file[]', null, 'multiple'); ?>
		<?php echo form_button('upload', 'Upload'); ?>
		
		<?php echo form_close(); ?>
		
		<div id="list">
			<ul></ul>
			<br class="clear" />
		</div>
	</section>
</section>
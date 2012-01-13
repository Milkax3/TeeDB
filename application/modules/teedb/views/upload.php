<aside>	
	<h2>Wrong upload form?</h2>
	<ul>
		<?php if($type != 'demos'): ?><li><?php echo anchor('teedb/upload/demos', 'Demo form'); ?></li><?php endif; ?>
		<?php if($type != 'gameskins'): ?><li><?php echo anchor('teedb/upload/gameskins', 'Gameskin form'); ?></li><?php endif; ?>
		<?php if($type != 'mapres'): ?><li><?php echo anchor('teedb/upload/mapres', 'Mapres form'); ?></li><?php endif; ?>
		<?php if($type != 'maps'): ?><li><?php echo anchor('teedb/upload/maps', 'Map form'); ?></li><?php endif; ?>
		<?php if($type != 'mods'): ?><li><?php echo anchor('teedb/upload/mods', 'Mod form'); ?></li><?php endif; ?>
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
		
		<?php echo form_open_multipart('teedb/upload/submit', array('id' => 'upload'), array('type' => $type)); ?>
		
			
			<?php if($type != 'mods'): ?>
				<?php echo form_upload('file[]', null, 'multiple'); ?>
			<?php else: ?>
				<label for="name">Mod-name:</label><br />
				<?php echo form_input('modname',set_value('modname')); ?>
				<br /><br />
				<label for="link">Link:</label><br />
				<?php echo form_input('link',set_value('link')); ?>
				<br /><br />
				<label for="has">Mod has:</label><br />
				<?php echo form_checkbox('server',set_value('server')); ?> Server<br/>
				<?php echo form_checkbox('client',set_value('client')); ?> Client<br/>
				<br /><br />
				<label for="file">Screenshot:</label><br />				
				<?php echo form_upload('file[]', null, 'multiple'); ?>	
			<?php endif; ?>
			
		<?php echo form_button('upload', 'Upload'); ?>
		
		<?php echo form_close(); ?>
		
		<div id="list">
			<ul></ul>
			<br class="clear" />
		</div>
	</section>
</section>
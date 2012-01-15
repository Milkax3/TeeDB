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
		<li><?php echo anchor('teedb/myteedb', 'My TeeDB'); ?></li>
	</ul>
</aside>

<section id="content">
	<section id="uploader">		
		<h2><?php echo ($type == 'mapres')? 'Mapres' : ucfirst(singular($type)); ?> upload</h2>
		
		<?php if($type == 'mods'): ?>
			<p class="info border"><span class="icon color icon112"></span>
				For security reason you are only allowed to share a link instead of uploading.
			</p>
		<?php endif; ?>
		
		<div id="info">
			<?php echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'); ?>
		</div>
		
		<?php echo form_open_multipart('teedb/upload/submit', array('id' => 'upload'), array('type' => $type)); ?>
		
			
			<?php if($type != 'mods'): ?>
				<?php echo form_upload('file[]', null, 'multiple'); ?>
			<?php else: ?>
				<div style="margin: 20px 0;">
					<div style="float: left;">
						<label for="name">Modification-name:</label><br />
						<?php echo form_input('modname',set_value('modname'), 'style="width:321px"'); ?>
					</div>
					<div style="float: left;width:323px; margin-left:20px;height: 46px">
						<label for="has">Modified:</label><br />
						<div style="width: 50%; float:left">
							<?php echo form_checkbox('server',set_value('server')); ?> <span class="solid">Server</span>
						</div>
						<div style="width: 50%; float:left">
						<?php echo form_checkbox('client',set_value('client')); ?> <span class="solid">Client</span>
						</div>
					</div>
					<div style="float: left">
						<label for="link">Link:</label><br />
						<?php echo form_input('link',set_value('link'), 'style="width:321px"'); ?>
					</div>
					<div style="float: left;margin-left: 20px;width:333px;height: 46px">
						<label for="file">Screenshot:</label><br />				
						<?php echo form_upload('file[]', null, 'multiple'); ?>	
					</div>
				</div>
			<?php endif; ?>
			
		<?php echo form_button('upload', 'Upload'); ?>
		
		<?php echo form_close(); ?>
		
		<div id="list">
			<ul></ul>
			<br class="clear" />
		</div>
	</section>
</section>
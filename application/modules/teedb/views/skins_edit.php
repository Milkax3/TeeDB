<aside>	
	<h2>View my...</h2>
	<ul>
		<?php if($type != 'demos'): ?><li><?php echo anchor('teedb/myteedb/demos', 'Demos'); ?></li><?php endif; ?>
		<?php if($type != 'gameskins'): ?><li><?php echo anchor('teedb/myteedb/gameskins', 'Gameskins'); ?></li><?php endif; ?>
		<?php if($type != 'mapres'): ?><li><?php echo anchor('teedb/myteedb/mapres', 'Mapres'); ?></li><?php endif; ?>
		<?php if($type != 'maps'): ?><li><?php echo anchor('teedb/myteedb/maps', 'Maps'); ?></li><?php endif; ?>
		<?php if($type != 'mods'): ?><li><?php echo anchor('teedb/myteedb/mods', 'Mods'); ?></li><?php endif; ?>
		<?php if($type != 'skins'): ?><li><?php echo anchor('teedb/myteedb/skins', 'Skins'); ?></li><?php endif; ?>
	</ul>
	<br style="clear:both;" />
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('teedb/myteedb/skins/new/asc', 'Newest') : anchor('teedb/myteedb/skins/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('teedb/myteedb/skins/name/desc', 'Name') : anchor('teedb/myteedb/skins/name/asc', 'Name'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('teedb/upload/'.$type, 'Upload more '.$type.'!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="myteedb">
		<h2 style="margin-bottom: 10px;">My <?php echo ucfirst($type); ?></h2>
		
		<div id="info">		
			<?php if(isset($delete)): ?>
				<p class="info border"><span class="icon color icon112"></span>
					Are you really sure you want to remove the skin <?php echo $delete; ?>?
				</p>
			<?php endif; ?>
			<?php 
				echo (isset($changed) && $changed)? 
					'<p class="success color border">
						<span class="icon color icon101"></span>
						Skin '.$changed.' changed successful.
					</p>'
					 : 
					 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
				);
			?>
		</div>
		
		<div id="list">
			<ul>
				<?php foreach($skins as $entry): ?>
					<li style="width:314px; height: 122px">
						<?php echo form_open(null, null, array('id' => $entry->id)); ?>
							<img src="<?php echo base_url('uploads/skins/previews/'.$entry->name.'.png'); ?>" alt="Preview of skin <?php echo $entry->name; ?>" />
							<div style="float: right;text-align: left">
								<strong>Name:</strong> <?php echo form_input('skinname',$entry->name); ?><br />
								<br />
								<strong>Filesize:</strong> <?php echo round(filesize('uploads/skins/'.$entry->name.'.png')/1000); ?> kB<br />
								<strong>Uploaded:</strong> <?php echo datetime_to_human($entry->create); ?>
							</div>
							<br /><br /><br />
							<?php echo form_submit('change', 'Save changes', 'style="width:126px"'); ?>
							<?php if(isset($delete)): ?>
								<?php echo form_submit('delete2', 'Yes, delete this', 'style="width:126px"'); ?>								
							<?php else: ?>
								<?php echo form_submit('delete', 'Delete skin', 'style="width:126px"'); ?>
							<?php endif; ?>
		
						<?php echo form_close(); ?>
					</li>
				<?php endforeach; ?>
				<br class="clear" />
				<div style="width:680px; text-align: center; margin-top:15px">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</ul>
			<br class="clear" />
		</div>
		
	</section>
</section>
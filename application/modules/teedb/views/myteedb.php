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
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('teedb/myteedb/index/new/asc', 'Newest') : anchor('teedb/myteedb/index/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('teedb/myteedb/index/rate/asc', 'Rating') : anchor('teedb/myteedb/index/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('teedb/myteedb/index/dw/asc', 'Downloads') : anchor('teedb/myteedb/index/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('teedb/myteedb/index/name/desc', 'Name') : anchor('teedb/myteedb/index/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('teedb/myteedb/index/author/desc', 'Author') : anchor('teedb/myteedb/index/author/asc', 'Author'); ?></li>
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
			<?php echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'); ?>
		</div>
		
		<div id="list">
			<ul id="<?php echo $type; ?>">
				<?php foreach($skins as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
					<?php if($type == 'skins' OR true): ?>
					<li>
						<img src="<?php echo base_url(); ?>uploads/skins/previews/<?php echo $entry->name; ?>.png" alt="Skin <?php echo $entry->name; ?>" />
						<p><?php echo $entry->name; ?></p>
						<br />
						<?php echo anchor('teedb/myteedb/skin/'.url_title($entry->name), 'Change', 'style="font-size: 10px"'); ?>
					</li>
					<?php endif; ?>
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
<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('teedb/skins/new/asc', 'Newest') : anchor('teedb/skins/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('teedb/skins/rate/asc', 'Rating') : anchor('teedb/skins/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('teedb/skins/dw/asc', 'Downloads') : anchor('teedb/skins/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('teedb/skins/name/desc', 'Name') : anchor('teedb/skins/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('teedb/skins/author/desc', 'Author') : anchor('teedb/skins/author/asc', 'Author'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('teedb/upload/skins', 'Upload your own skins!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="skins">
		<h2 style="margin-bottom: 10px;">Skins</h2>
		
		
		<div id="list">
			<ul>
				<?php foreach($skins as $entry): ?>
					
					<li style="height:180px; font-weight: bold;">
						<img src="<?php echo base_url(); ?>uploads/skins/previews/<?php echo $entry->name; ?>.png" alt="Skin <?php echo $entry->name; ?>" />
						<p><?php echo $entry->name; ?></p>
						<p style="font-size: 10px">
							from <?php echo anchor('profile/name/'.url_title($entry->username), $entry->username, 'class="none solid"'); ?>
						</p>
						<br />
						<p style="font-size: 10px">
							<span style="float:left; margin-top: 2px;">Like: </span>
							<span style="cursor:pointer" class="icon color icon204"></span>
							<span style="cursor:pointer" class="icon color icon203"></span>
						</p>
						<br class="clear" />
						<div class="rate">
							<div class="like" style="width: <?php echo 104*rateFormat($entry->rate_sum, $entry->rate_count)+50; ?>px">
								<?php echo rateFormat($entry->rate_sum, $entry->rate_count)*10+234; ?>
							</div>
							<div class="dislike" style="width: <?php echo 104*rateFormat($entry->rate_sum, $entry->rate_count)+50; ?>px">
								<?php echo rateFormat($entry->rate_sum, $entry->rate_count)*10+132; ?>
							</div>
						</div>
						<br />
						<?php echo anchor('teedb/download/skin/'.url_title($entry->name), 'Download', 'style="font-size: 10px"'); ?>
					</li>
					
				<?php endforeach; ?>
			</ul>
			<br class="clear" />
		</div>
		
	</section>
</section>
<aside>	
	<h2>Sorted by...</h2>
	<ul>
		<li><?php echo ($order=='new' and $direction=='desc')? anchor('teedb/gameskins/index/new/asc', 'Newest') : anchor('teedb/gameskins/index/new/desc', 'Newest'); ?></li>
		<li><?php echo ($order=='rate' and $direction=='desc')? anchor('teedb/gameskins/index/rate/asc', 'Rating') : anchor('teedb/gameskins/index/rate/desc', 'Rating'); ?></li>
		<li><?php echo ($order=='dw' and $direction=='desc')? anchor('teedb/gameskins/index/dw/asc', 'Downloads') : anchor('teedb/gameskins/index/dw/desc', 'Downloads'); ?></li>
		<li><?php echo ($order=='name' and $direction=='asc')? anchor('teedb/gameskins/index/name/desc', 'Name') : anchor('teedb/gameskins/index/name/asc', 'Name'); ?></li>
		<li><?php echo ($order=='author' and $direction=='asc')? anchor('teedb/gameskins/index/author/desc', 'Author') : anchor('teedb/gameskins/index/author/asc', 'Author'); ?></li>
	</ul>
	<br style="clear:both;" />
	<div style="text-align: center;margin-top:20px">
		<?php echo anchor('teedb/upload/gameskins', 'Upload your own gameskin!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="gameskins">
		<h2 style="margin-bottom: 10px;">Gameskins</h2>
		
		<div id="info">
			<?php echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'); ?>
		</div>		
		
		<div id="list">
			<ul>
				<?php foreach($gameskins as $entry): $entry->rate_sum = (int)$entry->rate_sum; ?>
					
					<li style="height:180px; font-weight: bold;">
						<div style="width:64px; height:64px">
							<img src="<?php echo base_url(); ?>uploads/gameskins/previews/<?php echo $entry->name; ?>.png" alt="Gameskin <?php echo $entry->name; ?>" />
						</div>
						<p><?php echo $entry->name; ?></p>
						<p style="font-size: 10px">
							from <?php echo anchor('teedb/gameskins#profile/name/'.url_title($entry->username), $entry->username, 'class="none solid"'); ?>
						</p>
						<br />
						<div style="font-size: 10px">
							<span style="float:left; margin-top: 2px;">Like: </span>
							<?php echo form_open('teedb/rates', array('class' => 'top'), array('type' => 'skin', 'id' => $entry->id, 'rate' => 1)); ?>
								<span class="icon color icon204"></span>
							<?php echo form_close(); ?>
							<?php echo form_open('teedb/rates', array('class' => 'flop'), array('type' => 'skin', 'id' => $entry->id, 'rate' => 0)); ?>
								<span class="icon color icon203"></span>
							<?php echo form_close(); ?>
						</div>
						<br class="clear" />
						<div class="rate">
							<?php $prec = ($entry->rate_count > 0)? round($entry->rate_sum/$entry->rate_count)*90 : 50; ?>
							<div class="like" style="color: #3B2B1C; width: <?php echo ($prec >= 10)? $prec : 10; ?>px">
								<?php echo $entry->rate_sum; ?>
							</div>
							<div class="dislike" style="color: #FFC96C; width: <?php echo ($prec >= 10)? (100-$prec) : 90; ?>px">
								<?php echo $entry->rate_count-$entry->rate_sum; ?>
							</div>
						</div>
						<br />
						<?php echo anchor('teedb/downloads/index/gameskin/'.url_title($entry->name), 'Download', 'style="font-size: 10px"'); ?>
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
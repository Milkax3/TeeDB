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
		<?php echo anchor('upload/skins', 'Upload your own skins!', 'class="button solid"'); ?>
	</div>
</aside>

<section id="content">
	<section id="skins">
		<h2 style="margin-bottom: 10px;">Skins</h2>
		<?php foreach($skins as $entry): ?>
		
			<section class="skin" id="<?php echo $entry->id; ?>" style="float:left; width:295px; height:66px">
				<figure style="float: left;">
					 <img src="<?php echo base_url(); ?>uploads/skin/preview/<?php echo $entry->name; ?>.png" alt="Skin <?php echo $entry->name; ?>">
				</figure>
				<details open="open" style="float: right; width:231px">
					<ul style="float:left; width:154px">
						<li><b>Name:</b> <?php echo anchor('teedb/skin/'.url_title($entry->name), $entry->name); ?></li>
						<li><b>From:</b> <?php echo anchor('profile/name/'.url_title($entry->username), $entry->username); ?></li>
						<li><b style="float:left">Like:</b> 
							<?php if($this->auth->logged_in()): ?>
								<span class="top"></span>
								<span class="flop"></span>
							<?php else: ?>
								<b><?php echo anchor('#login', 'Login', 'class="loginRef"'); ?> to rate!</b>
							<?php endif; ?>
						</li>
					</ul>
					<ul style="float:left; width:77px">
						<li class="rate"><b>Rate:</b> <span><?php echo rateFormat($entry->rate_sum, $entry->rate_count)*10; ?></span></li>	
						<li><!-- <span class="icon color icon67"></span> --><b>#Dw:</b> <?php echo $entry->downloads; ?></li>
						<li><b><?php echo anchor('teedb/download/skin/'.url_title($entry->name), 'Download'); ?></b></li>					
					</ul>
				</details>				
			</section>
			
		<?php endforeach; ?>
	</section>
</section>
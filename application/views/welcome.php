<aside>
	<h2>Latest News</h2>
	<ul>
		<?php if(isset($news_titles) && $news_titles): ?>
			<?php foreach($news_titles as $news_title): ?>
				<li><?php echo anchor('news/'.url_title($news_title->title), $news_title->title); ?></li>
			<?php endforeach; ?>
		<?php else: ?>
			<li>No latest news.</li>
		<?php endif; ?>
	</ul>
</aside>


<section id="content">
	
	<section id="news">
				
	    <?php if(isset($news) && $news): ?>
	    	
			<header style="margin-bottom: 10px;">
				<h2><?php echo $news->title; ?></h2>
				<time datetime="<?php echo date('c', human_to_unix($news->update)); ?>">
					<?php echo datetime_to_human($news->update); ?>
				</time>
			</header>
			
			<article>
				<?php echo $news->content; ?>
			</article>
			
			<details open="open">
				<ul>
					<li>
						<span class="icon color icon145"></span>
						Posted by <?php echo anchor('user/'.url_title($news->name), $news->name); ?>
					</li>
					<li>
						<span class="icon color icon42"></span>
						<?php 
							if($news->count_comment > 1){
								echo $news->count_comment.' Comments'; 
							}elseif($news->count_comment == 1){
								echo '1 Comment';
							}else{
								echo 'No Comments';
							}					
						?>
					</li>						
				</ul>
			</details>
			
		<?php else: ?>
	    	
			<header style="margin-bottom: 10px;">
				<h2>No News found!</h2>
			</header>
			
			<article>
				There are no latest news to show :(
			</article>
			
			<details open="open">
				<ul>
					<li>
						<span class="icon color icon112"></span>
						...and no info for the news.
					</li>					
				</ul>
			</details>

		<?php endif; ?>
		
	</section>
	
	<section id="latest">
		<h2>Latest work</h2>
	</section>
	
</section>

</section>

<div class="image_border open">
	<div class="center trans_border open"></div>
</div>

<div class="wrapper dark">
<section id="infobox" class="center transition">
	
	<section id="stats" class="left col3">
		<h2>Stats</h2>
		
		<p>
			<?php if(isset($stats) && $stats): ?>
				<h4>General:</h4>
				<?php 
					if($stats->users <= 0)
					{
						echo 'No user signup, yet.';
					}
					elseif($stats->users == 1)
					{
						echo 'One user signup.';
					}
					else
					{
						echo $stats->users.' users signup.';
					}
				?>
				
				<h4>Database:</h4>
				<?php
					$width = 178;
					$min = 20;
					$sum = $stats->teedb_demos + $stats->teedb_gameskins + $stats->teedb_mapres + $stats->teedb_maps + $stats->teedb_mods + $stats->teedb_skins;
				?>
				<div class="left" style="text-align: right">
					Demos:<br />
					Gameskins:<br />
					Mapres:<br />
					Maps:<br />
					Mods:<br />
					Skins:<br />
				</div>
				<div class="left" style="padding-left: 11px">
					<?php $procent = ($stats->teedb_demos == 0)? 0 : ($sum/$stats->teedb_demos); ?>
					<div class="chart" style="width: <?php echo ($procent == 0)? $min : $width * $procent; ?>px"><?php echo $procent * 100; ?>%</div>
					<?php $procent = ($stats->teedb_gameskins == 0)? 0 : ($sum/$stats->teedb_gameskins); ?>
					<div class="chart" style="width: <?php echo ($procent == 0)? $min : $width * $procent; ?>px"><?php echo $procent * 100; ?>%</div>
					<?php $procent = ($stats->teedb_mapres == 0)? 0 : ($sum/$stats->teedb_mapres); ?>
					<div class="chart" style="width: <?php echo ($procent == 0)? $min : $width * $procent; ?>px"><?php echo $procent * 100; ?>%</div>
					<?php $procent = ($stats->teedb_maps == 0)? 0 : ($sum/$stats->teedb_maps); ?>
					<div class="chart" style="width: <?php echo ($procent == 0)? $min : $width * $procent; ?>px"><?php echo $procent * 100; ?>%</div>
					<?php $procent = ($stats->teedb_mods == 0)? 0 : ($sum/$stats->teedb_mods); ?>
					<div class="chart" style="width: <?php echo ($procent == 0)? $min : $width * $procent; ?>px"><?php echo $procent * 100; ?>%</div>
					<?php $procent = ($stats->teedb_skins == 0)? 0 : ($sum/$stats->teedb_skins); ?>
					<div class="chart" style="width: <?php echo ($procent == 0)? $min : $width * $procent; ?>px"><?php echo $procent * 100; ?>%</div>
				</div>
			<?php else: ?>
				No stats found :(
			<?php endif; ?>	
		</p>
	</section>
	
	<section id="top" class="left col3">
		<h2>Top</h2>
	    <?php if(isset($top1on1) and $top1on1): ?>
			<img src="upload/skins/previews/warpaint.png" alt="Avatar" style="float:left">
			<p style="padding-top:20px">
				<b>1on1:</b> <?php echo anchor('/profile/name/'.$top1on1->username, $top1on1->username); ?><br>
				<?php echo $top1on1->score; ?> Points, <?php echo $top1on1->count_machtes; ?> Matches
		    </p>
		    <br style="clear:both" />
	    <?php endif; ?>
	    <?php if(isset($topSkin) and $topSkin): ?>
			<img src="upload/skins/previews/<?php echo $topSkin->name; ?>.png" alt="TopSkin" style="float:left">
			<p style="padding-top:20px">
				<b>Skin:</b> <?php echo anchor('/teedb/skin/'.$topSkin->name,$topSkin->name); ?> by <?php echo anchor('/profile/name/'.$topSkin->username, $topSkin->username); ?><br>
				&#216;<?php echo $this->Skin->getRate($topSkin->rate_sum, $topSkin->rate_count)*10; ?> from <?php echo $topSkin->rate_count; ?> votes
			</p>
	    <?php endif; ?>
	</section>
	
	<section id="last" class="left col3">
		<h2>Last</h2>
		<p>
			<b>Last-User:</b> 
			<?php if(isset($last_user) and $last_user): ?>
			<?php echo anchor('/profile/name/'.$last_user->name ,$last_user->name, 'class="none solid"').' ('.datetime_to_human($last_user->create).')'; ?><br>
			<?php else: ?>
			No user signup, yet.<br />
	   		<?php endif; ?>
			<br>
			<b>TeeDB:</b> 
	    	<?php if(isset($last) and $last): ?>
	    	<?php $init = FALSE; foreach($last as $entry): if($init) echo ', '; else $init = TRUE; echo anchor('/teedb/'.$entry->type.'/'.$entry->name, $entry->name).' ('.$entry->type.')'; endforeach; ?><br>
			<?php else: ?>
			No uploads, yet.<br />
			<br>
	   		<?php endif; ?>
		</p>
	</section>
	
	<br class="clear">
	
</section>
</div>
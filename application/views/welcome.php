<aside>
	<h2>Latest News</h2>
	<ul>
		<?php if(isset($news_titles) && $news_titles): ?>
			<?php foreach($news_titles as $news_title): ?>
				<li><?php echo anchor('blog/news/title/'.url_title($news_title->title), $news_title->title); ?></li>
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
				<h2><?php echo anchor('blog/news/title/'.url_title($news->title), $news->title, 'class="none" style="color: #A16E36;"'); ?></h2>
				<time datetime="<?php echo date('c', human_to_unix($news->create)); ?>">
					<?php echo datetime_to_human($news->create); ?>
				</time>
			</header>
			
			<article>
				<?php echo $news->content; ?>
			</article>
			
			<div class="details">
				<ul>
					<li>
						<span class="icon color icon145"></span>
						Posted by <?php echo anchor('#user/'.url_title($news->name), $news->name, 'class="none"'); ?>
					</li>
					<li>
						<span class="icon color icon42"></span>
						<?php 
							if($news->count_comment > 1){
								echo anchor('blog/news/title/'.url_title($news->title), $news->count_comment.' Comments', 'class="none"'); 
							}elseif($news->count_comment == 1){
								echo anchor('blog/news/title/'.url_title($news->title), '1 Comment', 'class="none"');
							}else{
								echo anchor('blog/news/title/'.url_title($news->title), 'No Comments', 'class="none"');
							}					
						?>
					</li>						
				</ul>
			</div>
			
		<?php else: ?>
	    	
			<header style="margin-bottom: 10px;">
				<h2>No News found!</h2>
			</header>
			
			<article>
				There are no latest news to show :(
			</article>
			
			<div class="details">
				<ul>
					<li>
						<span class="icon color icon112"></span>
						...and no info for the news.
					</li>					
				</ul>
			</div>

		<?php endif; ?>
		
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
		
		<?php if(isset($stats) && $stats): ?>
			<h4>General:</h4>
			<?php 
				if($stats['users'] <= 0)
				{
					echo 'No user signup, yet.';
				}
				elseif($stats['users'] == 1)
				{
					echo 'One user signup.';
				}
				else
				{
					echo $stats['users'].' users signup.';
				}
			?>
			
			<h4>Database:</h4>
			<div class="left" style="text-align: right">
				Demos:<br />
				Gameskins:<br />
				Maps:<br />
				Mapres:<br />
				Mods:<br />
				Skins:<br />
			</div>
			<div class="left" style="padding-left: 11px">
				<?php unset($stats['users']); foreach($stats as $key => $type): ?>
					<div class="chart" style="width: <?php echo $type['width']; ?>px"><?php echo $type['procent']; ?>%</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<p>No stats found :(</p>
		<?php endif; ?>
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
	    	<?php $init = FALSE; foreach($last as $entry): if($init) echo ', '; else $init = TRUE; echo anchor('/teedb/'.$entry->type.'/'.$entry->name, $entry->name, 'class="none solid"').' ('.$entry->type.')'; endforeach; ?><br>
			<?php else: ?>
			No uploads, yet.<br />
			<br>
	   		<?php endif; ?>
		</p>
	</section>
	
	<br class="clear">
	
</section>
</div>
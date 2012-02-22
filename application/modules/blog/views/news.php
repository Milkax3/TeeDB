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
	    	<?php foreach($news as $entry): ?>
	    	
				<header style="margin-bottom: 10px;">
					<h2><?php echo anchor('blog/news/title/'.url_title($entry->title), $entry->title, 'class="none" style="color: #A16E36;"'); ?></h2>
					<time datetime="<?php echo date('c', human_to_unix($entry->create)); ?>">
						<?php echo datetime_to_human($entry->create); ?>
					</time>
				</header>
				
				<article>
					<?php echo $entry->content; ?>
				</article>
				
				<div class="details">
					<ul>
						<li>
							<span class="icon color icon145"></span>
							Posted by <?php echo anchor('#user/'.url_title($entry->name), $entry->name, 'class="none"'); ?>
						</li>
						<li>
							<span class="icon color icon42"></span>
							<?php 
								if($entry->count_comment > 1){
									echo anchor('blog/news/title/'.url_title($entry->title), $entry->count_comment.' Comments', 'class="none"'); 
								}elseif($entry->count_comment == 1){
									echo anchor('blog/news/title/'.url_title($entry->title), '1 Comment', 'class="none"');
								}else{
									echo anchor('blog/news/title/'.url_title($entry->title), 'No Comments', 'class="none"');
								}					
							?>
						</li>						
					</ul>
				</div>
				
			<?php endforeach; ?>
			<br class="clear" />
			<div style="width:680px; text-align: center; margin:15px 0">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php else: ?>
	    	
			<header style="margin-bottom: 10px;">
				<h2>Not found!</h2>
			</header>
			
			<article>
				The News you are searching is missing :(
			</article>

		<?php endif; ?>
		
	</section>
		
	</section>
</section>
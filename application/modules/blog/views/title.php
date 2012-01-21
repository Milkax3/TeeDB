<aside>
	<h2>Other News</h2>
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
				<h2><?php echo $news->title; ?></h2>
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
						Posted by <b><?php echo anchor('user/'.url_title($news->name), $news->name, 'class="none"'); ?></b>
					</li>
					<li>
						<span class="icon color icon42"></span>
						<b>
							<?php 
								if($news->count_comment > 1){
									echo $news->count_comment.' Comments'; 
								}elseif($news->count_comment == 1){
									echo '1 Comment';
								}else{
									echo 'No Comments';
								}					
							?>
						</b>
					</li>						
				</ul>
			</div>
			
			<br/>
			
			<section id="comments">
				<h2>Comments</h2>
	   			<?php if(isset($comments) && $comments): ?>
	   			
					<div id="lister">
			    		<ul>
			    			
							<div id="info">
								<?php echo validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'); ?>
							</div>
							
				    		<li style="width: 655px; height:190px; text-align: left;">		
								<?php echo form_open('blog/news/submit', 'id="comment"', array('id' => $news->id)); ?>
									<label for="comment">Your comment:</label><br />
									<?php echo form_textarea('comment',set_value('comment')); ?>
									<br/><br />
									<?php echo form_button('submit','Submit'); ?>
								<?php echo form_close(); ?>	
								<br class="clear" />				
							</li>
							<br class="clear" />
							
		    				<?php foreach($comments as $entry): ?>
				    			<li style="height: 90px">
									<time style="padding:0;" datetime="<?php echo date('c', human_to_unix($entry->create)); ?>">
										<?php echo datetime_to_human($entry->create); ?>
									</time><br/>
				    				<?php echo anchor('user/'.url_title($entry->name), $entry->name, 'class="none solid"'); ?> says:
				    			</li>
				    			<li style="width: 496px; margin-left:15px; text-align: left;">			    					
				    				<?php echo $entry->comment; ?>
								</li>
								<br class="clear" />
							<?php endforeach; ?>
							
						</ul>
						<br class="clear" />
						<div style="width:680px; text-align: center; margin:15px 0">
							<?php echo $this->pagination->create_links(); ?>
						</div>
					</div>
				<?php endif; ?>
			</section>
			
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
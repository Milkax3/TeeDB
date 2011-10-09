<aside>
	<div class="header">
		<img alt="Navigation" src="images/aside.jpg">
	</div>
	<div class="main">
	
		<h2>Overview</h2>
		<br>
		<ul>
			<li><?php echo anchor('teedb/skins/', 'More Skins'); ?></li>
			<li><?php echo anchor('profile/skins/'.$skin->username.'/', 'Skins by User'); ?></li>
		</ul>
		<br>
		<span class="click" id="upload">Upload your own skins!</span>
				
	</div>
	<div class="footer"></div>
</aside>	

<section id="content">
	<section id="skins">
		<div class="header">
			<img alt="skins" src="images/skins.jpg">
		</div>
		<div class="main">
			
			<section class="skin" id="<?php echo $skin->id; ?>" >
				<div  style="float:right">
					<img src="<?php echo base_url(); ?>upload/skins/<?php echo $skin->name; ?>.png" alt="Skin <?php echo $skin->name; ?>">
					<div style="font-size:11px; width:256px; text-align:center"><?php echo $skin->name; ?>.png (<?php echo $this->Skin->getSize($skin->name); ?>)
						<?php if(!$this->auth->getCurrentUserID()): ?>
							<?php echo anchor(uri_string().'#login', 'Login', 'class="loginRef"'); ?> to report!
						<?php else: ?>	
							<span class="report click">Report!</span>
						<?php endif; ?>						
					</div>
				</div>
				<figure style="float: left;">
					<img src="<?php echo base_url(); ?>upload/skins/previews/<?php echo $skin->name; ?>.png" alt="Skin <?php echo $skin->name; ?> Preview">			 
				</figure>
				<details open="open" style="float:left">
					<ul>
						<li><h3><?php echo $skin->name; ?></h3></li>
						<li><b>From:</b> <?php echo anchor('profile/name/'.url_title($skin->username), $skin->username); ?></li>
						<?php if($this->auth->getCurrentUserID()): ?>
							<li><b style="float:left">Like:</b> 
								<span class="top"></span>
								<span class="flop"></span>
							</li>
						<?php else: ?>
							<li><b>Like: <?php echo anchor(uri_string().'#login', 'Login', 'class="loginRef"'); ?> to rate!</b></li>
						<?php endif; ?>
						</li>
						<li style="clear:both;">&nbsp;</li>
						<?php $average = $this->Skin->getRate($skin->rate_sum, $skin->rate_count); ?>
						<li class="rate"><b>Rate: </b><span id="value"><?php echo $average*10; ?></span> (Votes: <span id="votes"><?php echo $skin->rate_count; ?></span>)
							<div class="rating_bar<?php echo ($skin->rate_count)? '_bad' : ''; ?>">
								<div style="width: <?php echo $average*80; ?>px;" id="ratebar">
									<span style="display: none;"><?php echo $average; ?></span>
								</div>
							</div>
						</li>	
						<li><b>Downloads:</b> <?php echo $skin->downloads; ?></li>
					</ul>
					<br>
					<?php echo anchor('teedb/download/skin/'.url_title($skin->name), '<button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Download</span></button>', 'class="image"'); ?>
				</details>	
			</section>
			
				
			<br style="clear:both">		
		</div>
		<div class="footer" style="text-align:center"></div>
			
	</section>
	<section id="comments">
		<div class="header">
			<img alt="Comments" src="images/comments.jpg">
		</div>
		<div class="main">
			<?php foreach($comments as $comment): ?>
				<section class="comment" id="comment-<?php echo $comment->id; ?>" style="padding-bottom:10px">
					<header style="float: left;">
						<figure style="float: left;">
							 <img src="<?php echo $this->User->getAvatar($comment->name); ?>" alt="Avatar">
						</figure>
						<details open="open" style="float: right">
							<ul>
								<li class="posted">Posted by <?php echo anchor('profile/name/'.url_title($comment->name), $comment->name); ?></li>
								<li class="time">
									<time datetime="<?php echo date('c', human_to_unix($comment->update)); ?>" >
										<?php echo datetime_to_human($comment->update); ?>
									</time>
								</li>					
							</ul>
						</details>
					</header>
					<article style="clear:both;">
						<?php echo $comment->comment; ?>
					</article>
				</section>
			<?php endforeach; ?>	
			<br/>
			<?php if(!$this->auth->getCurrentUserID()): ?>
				<b><?php echo anchor(uri_string().'#login', 'Login', 'class="loginRef"'); ?> to add a comment!</b>
			<?php else: ?>				
				<h3>Write a comment</h3>
				<hr>
				<div class="errorBox" style="padding-top:20px;"></div>
				<section id="writeComment">
					<header style="float: left;">
						<figure style="float: left;">
							 <img src="<?php echo $this->User->getAvatar($this->auth->getCurrentUserName()); ?>" alt="Avatar">
						</figure>
						<details open="open" style="float: right">
							<ul>
								<li class="posted"><?php echo anchor('profil/name/'.url_title($this->auth->getCurrentUserName()), $this->auth->getCurrentUserName()); ?></li>
								<li class="time">
									<time datetime="<?php echo date('c'); ?>" >
										<?php echo datetime_to_human(time()); ?>
									</time>
								</li>						
							</ul>
						</details>
					</header>
						<div style="clear:both;">
						<?php echo form_open('comment/submit', array('id' => 'commentForm', 'onsubmit'=>'return false;'), array('type' => 'skin', 'id' => $skin->id)); ?>
							<label for="commentbox"><b>Your comment: </b></label>
							<?php echo form_textarea('comment',set_value('comment'), 'id="commentbox"'); ?>
							<div style="width:100%; text-align:center; padding-top:20px">
								<?php echo form_submit('sub_com', 'Post'); ?>
							</div>
						<?php echo form_close(); ?>
					</div>
				</section>
			
			<?php endif; ?>					
		</div>
		<div class="footer">					
		</div>
	</section>
	
</section>

<div id="dialog-upload" title="Upload a skin" style="display:none;">
	<?php echo form_open_multipart('upload/skin', array('onsubmit' => 'return false;')); ?>
		<?php $this->load->view('skin/uploadfile'); ?>
	<?php echo form_close(); ?>
	<br>
	<div id="upload_skin" style="text-align:center">
		<button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Upload</span></button>
	</div>
</div>

<div id="dialog-report" title="Report" style="display:none;">
	<?php echo form_open('report/submit/', array('id' => 'reportForm', 'onsubmit' => 'return false;')); ?>
		<?php $this->load->view('report', array('type'=>'skin', 'id' => $skin->id,'name' => $skin->name)); ?>
	<?php echo form_close(); ?>
	<br>
	<div id="report_send" style="text-align:center">
		<button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Send</span></button>
	</div>
</div>
<div id="jungle" class="wrapper">
	<header id="<?php echo (isset($large) && $large)? 'large' : 'main'; ?>" class="center">
		
		<div id="logo">
			<a class="none" href="<?php echo base_url(); ?>">
				<img src="assets/images/logo.png" alt="Logo">
			</a>
		</div>
		
		<ul class="light border float right">
			<li><?php echo anchor('','main'); ?></li>
			<li><?php echo anchor('news','news'); ?></li>
			<li><?php echo anchor('faq','faq'); ?></li>
			<li><?php echo anchor('about','about'); ?></li>
		</ul>
		
		<?php if(isset($randomtee) && $randomtee): ?>
			<div id="randomtee">
				<?php echo anchor('teedb/skin/'.$randomtee->name, $randomtee->name, 'class="none solid"'); ?><br />
				<img src="uploads/skin/preview/<?php echo $randomtee->name.'.png'; ?>" alt="RandomTee">
			</div>
			<a type="application/rss+xml" href="feed/" id="rss" class="none"></a>
			<div id="butterfly"></div>
		<?php endif; ?>
		
	</header>
</div>

<nav class="wrapper light">
	<ul class="center float">
		<li><?php echo anchor('teedb/demos','Demos'); ?></li>
		<li><?php echo anchor('teedb/gameskins','Gameskins'); ?></li>
		<li><?php echo anchor('teedb/mapres','Mapres'); ?></li>
		<li><?php echo anchor('teedb/maps','Maps'); ?></li>
		<li><?php echo anchor('teedb/mods','Mods'); ?></li>
		<li><?php echo anchor('teedb/skins','Skins'); ?></li>
		
		<li class="right">
			<div class="dropdown right"><?php echo anchor('user/login','Login', 'class="select"'); ?></div>
			<ul style="width: 0px">
				<li>
					<?php if($this->auth != NULL && $this->auth->logged_in()): ?>
						<p>Hello <?php echo $this->auth->get_username(); ?>.</p>
						<br />
							<?php echo anchor('user/edit','Edit profile'); ?><br />
							<?php echo anchor('user/logout','Logout'); ?>
						</p>
					<?php else: ?>
						<?php echo form_open('user/login'); ?>
							<p>
								<label for="username">Username:</label><br />
								<?php echo form_input('username',set_value('username'),'id="loginName"'); ?>
								<br /><br />
								<label for="password">Password:</label><br />
								<?php echo form_password('password'); ?>
								<br /><br /><br />
								<?php echo form_submit('submit','Login'); ?><br />
							</p>
							<p style="text-align: center; font-size:12px;">
								<?php echo anchor('user/signup','Signup.'); ?>
								<?php echo anchor('user/lostpw','Forgot password?'); ?>
							</p>	
						<?php echo form_close(); ?>	
					<?php endif; ?>
				</li>
			</ul>
		</li>
		
	</ul>
</nav>

<div class="image_border open wrapper">
	<div class="center trans_border open"></div>
</div>

<div class="wrapper dark">
	<section id="slider" class="transition center">
		<div id="arrow_left"></div>
		<div id="slider_content"></div>
		<div id="arrow_right"></div>
	</section>
</div>

<div class="image_border close">
	<div class="center trans_border close"></div>
</div>

<section class="wrapper light center space">
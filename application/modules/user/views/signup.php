<section class="center">
	
	<section class="left col3">
		<h2>Have already an account?</h2>
		<ul>
			<li><?php echo anchor('user/login', 'Login'); ?></li>
		</ul>
	</section>
	
	<section class="left col3">
		<h2>User Signup</h2>
		<p class="info border"><span class="icon color icon112"></span>Enter a valid email address to activate your account via confirm link!</p>
		<?php 
			echo (isset($success) && $success)? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					Signup successful. Confirm link has been sent to your email address.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		
		<?php echo form_open('user/signup'); ?>
			<p>
				<label for="username">Username:</label><br />
				<?php echo form_input('username',set_value('username'),'id="username"'); ?>
				<br /><br />
				<label for="password">Password:</label><br />
				<?php echo form_password('password', '', 'id="password"'); ?>
				<br /><br />
				<label for="password">Confirm password:</label><br />
				<?php echo form_password('passconf', '', 'id="passconf"'); ?>
				<br /><br />
				<label for="password">Email:</label><br />
				<?php echo form_input('email',set_value('email'), 'id="email"'); ?>
				<br /><br /><br />
				<?php echo form_submit('submit','Submit'); ?><br />
			</p>
		<?php echo form_close(); ?>
	</section>
	
	<section class="left col3">
		<h2>Forgot password?</h2>
		<ul>
			<li><?php echo anchor('user/lostpw', 'Request a new one'); ?></li>
		</ul>
	</section>
	
</section>
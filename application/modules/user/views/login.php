<section class="center">
	
	<section class="left col3">
		<h2>User Login</h2>
		<?php 
			echo (isset($success) && $success)? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					Login successful.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		
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
		<?php echo form_close(); ?>	
	</section>
	
	<section class="left col3">
		<h2>Dont have an account?</h2>
		<ul>
			<li><?php echo anchor('user/signup', 'Signup'); ?></li>
		</ul>
	</section>
	
	<section class="left col3">
		<h2>Forgot password?</h2>
		<ul>
			<li><?php echo anchor('user/lostpw', 'Request a new One'); ?></li>
		</ul>
	</section>
	
</section>
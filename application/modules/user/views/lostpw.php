<section class="center">
	
	<section class="left col3">
		<h2>Have already an account?</h2>
		<ul>
			<li><?php echo anchor('user/login', 'Login'); ?></li>
		</ul>
	</section>
	
	<section class="left col3">
		<h2>Dont have an account?</h2>
		<ul>
			<li><?php echo anchor('user/signup', 'Signup'); ?></li>
		</ul>
	</section>
	
	<section class="left col3">
		<h2>Get a new password</h2>
		<?php 
			echo (isset($success) && $success)? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					A new password has been sent via email.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		
		<?php echo form_open('user/lostpw'); ?>
			<p>
				<label for="password">Email:</label><br />
				<?php echo form_input('email',set_value('email'), 'id="email"'); ?>
				<br /><br /><br />
				<?php echo form_submit('submit','Submit'); ?><br />
			</p>
		<?php echo form_close(); ?>
	</section>
	
</section>
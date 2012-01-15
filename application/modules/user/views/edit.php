<section class="center">
	
	<section class="left col3">
		<h2>Change password?</h2>
		
		<?php echo form_open('user/edit'); ?>
			<p>
				<label for="password">Password:</label><br />
				<?php echo form_password('password', '', 'id="password"'); ?>
				<br /><br />
				<label for="password">Confirm password:</label><br />
				<?php echo form_password('passconf', '', 'id="passconf"'); ?>
				<br /><br /><br />
				<?php echo form_submit('pw','Save new password'); ?><br />
			</p>
		<?php echo form_close(); ?>	
	</section>
	
	<section class="left col3">
		<h2>Change email?</h2>
		
		<?php echo form_open('user/edit'); ?>
			<p>
				<label for="password">Email:</label><br />
				<?php echo form_input('email',set_value('email'), 'id="email"'); ?>
				<br /><br /><br />
				<?php echo form_submit('email','Save new email'); ?><br />
			</p>
		<?php echo form_close(); ?>	
	</section>	
	
	<section class="left col3">
		<h2>Remove Account?</h2>
		<?php 
			echo (isset($success) && $success)? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					Changes saved successful.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		
		<p>
			Username:<br />
			<span class="solid">foobar</span>
			<br /><br />
			Email:<br />
			<span class="solid">foo@bar.de</span>
			<br /><br />
			Uploads:<br />
			<span class="solid">320</span>
			<br /><br /><br />
			<?php echo form_open('user/edit'); ?>
				<?php echo form_submit('delete','Delete Account'); ?><br />
			<?php echo form_close(); ?>	
		</p>
	</section>
	
</section>
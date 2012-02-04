<section class="center">
	
	<section class="left col3">
		<h2>Change password?</h2>
		
		<?php if(isset($success['pass'])): ?>			
		<?php echo ($success['pass'])? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					Password successful changed.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		<?php endif; ?>
		
		<?php echo form_open('user/edit/pass'); ?>
			<p>
				<label for="password">New password:</label><br />
				<?php echo form_password('new_password', '', 'id="password"'); ?>
				<br /><br />
				<label for="password">Confirm new password:</label><br />
				<?php echo form_password('passconf', '', 'id="passconf"'); ?>
				<br /><br /><br />
				<?php echo form_submit('pw','Save new password'); ?><br />
			</p>
		<?php echo form_close(); ?>	
	</section>
	
	<section class="left col3">
		<h2>Change email?</h2>		
		
		<?php if(isset($success['email'])): ?>			
		<?php echo ($success['email'])? 
				'<p class="success color border">
					<span class="icon color icon101"></span>
					Email successful changed.
				</p>'
				 : 
				 validation_errors('<p class="error color border"><span class="icon color icon100"></span>','</p>'
			);
		?>
		<?php endif; ?>
		
		<?php echo form_open('user/edit/email'); ?>
			<p>
				<label for="password">Email:</label><br />
				<?php echo form_input('email',set_value('email'), 'id="email"'); ?>
				<br /><br /><br />
				<?php echo form_submit('sub_email','Save new email'); ?><br />
			</p>
		<?php echo form_close(); ?>	
	</section>	
	
	<section class="left col3">
		<h2>Remove Account?</h2>	
		
		<?php if(isset($success['del'])): ?>
			<p class="info border"><span class="icon color icon112"></span>
				Are you really sure you want to remove your account with all your uploads?
			</p>
		<?php endif; ?>
		
		<p>
			<b>Username:</b><br />
			<span class="solid"><?php echo $this->auth->get_name(); ?></span>
			<br /><br />
			<b>Email:</b><br />
			<span class="solid"><?php echo $email; ?></span>
			<br /><br />
			<b>Uploads:</b><br />
			<span class="solid"><?php echo $uploads; ?></span>
			<br /><br /><br />
			<?php echo form_open('user/edit/del'); ?>
				<?php if(isset($success['del'])): ?>
					<?php echo form_submit('delete2','Yes, delete my account'); ?><br />					
				<?php else: ?>
					<?php echo form_submit('delete','Delete Account'); ?><br />
				<?php endif; ?>
			<?php echo form_close(); ?>	
		</p>
	</section>
	
</section>
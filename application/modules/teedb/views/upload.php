<aside>	
	<h2>Wrong upload form?</h2>
	<ul>
		<?php if($type != 'demos'): ?><li><?php echo anchor('upload/demo', 'Demo form'); ?></li><?php endif; ?>
		<?php if($type != 'gameskins'): ?><li><?php echo anchor('upload/demo', 'Gameskin form'); ?></li><?php endif; ?>
		<?php if($type != 'mapres'): ?><li><?php echo anchor('upload/demo', 'Mapres form'); ?></li><?php endif; ?>
		<?php if($type != 'maps'): ?><li><?php echo anchor('upload/demo', 'Map form'); ?></li><?php endif; ?>
		<?php if($type != 'skins'): ?><li><?php echo anchor('upload/demo', 'Skin form'); ?></li><?php endif; ?>
	</ul>
</aside>

<section id="content">
	<section id="upload">
		<h2>Skin upload</h2>
		<?php echo validation_errors('<p class="error">','</p>'); ?>
		
		<?php echo form_open('upload/skins'); ?>
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
</section>
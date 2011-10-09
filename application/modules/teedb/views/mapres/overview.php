<aside>
	<div class="header">
		<img alt="Navigation" src="images/aside.jpg">
	</div>
	<div class="main">
	
		<h2>Sorted by...</h2>
		<br>
		<ul>
			<li><?php echo ($order=='new' and $direction=='desc')? anchor('teedb/mapres/new/asc', 'Newest') : anchor('teedb/mapres/new/desc', 'Newest'); ?></li>
			<li><?php echo ($order=='rate' and $direction=='desc')? anchor('teedb/mapres/rate/asc', 'Rating') : anchor('teedb/mapres/rate/desc', 'Rating'); ?></li>
			<li><?php echo ($order=='dw' and $direction=='desc')? anchor('teedb/mapres/dw/asc', 'Downloads') : anchor('teedb/mapres/dw/desc', 'Downloads'); ?></li>
			<li><?php echo ($order=='name' and $direction=='asc')? anchor('teedb/mapres/name/desc', 'Name') : anchor('teedb/mapres/name/asc', 'Name'); ?></li>
			<li><?php echo ($order=='author' and $direction=='asc')? anchor('teedb/mapres/author/desc', 'Author') : anchor('teedb/mapres/author/asc', 'Author'); ?></li>
		</ul>
		<br>
		<span class="click" id="upload">Upload your own mapres!</span>
				
	</div>
	<div class="footer"></div>
</aside>	

<section id="content">
	<section id="mapress">
		<div class="header">
			<img alt="mapres" src="images/mapres.jpg">
		</div>
		<div class="main">
			<?php foreach($mapres as $entry): ?>
			
				<section class="mapres" id="<?php echo $entry->id; ?>" style="float:left; width:295px; height:66px">
					<figure style="float: left; width:64px; height:64px; vertical-align: middle;">
						 <img src="<?php echo base_url(); ?>upload/mapress/previews/<?php echo $entry->name; ?>.png" alt="Mapres <?php echo $entry->name; ?>" >
					</figure>
					<details open="open" style="float: right; width:227px; margin-left: 4px">
						<ul style="float:left; width:150px">
							<li><b>Name:</b> <?php echo anchor('teedb/mapres/'.url_title($entry->name), $entry->name); ?></li>
							<li><b>From:</b> <?php echo anchor('profile/name/'.url_title($entry->username), $entry->username); ?></li>
							<li><b style="float:left">Like:</b> 
								<?php if($this->auth->getCurrentUserID()): ?>
									<span class="top"></span>
									<span class="flop"></span>
								<?php else: ?>
									<b><?php echo anchor('#login', 'Login', 'class="loginRef"'); ?> to rate!</b>
								<?php endif; ?>
							</li>
						</ul>
						<ul style="float:left; width:77px">
							<li class="rate"><b>Rate:</b> <span><?php echo $this->Mapres->getRate($entry->rate_sum, $entry->rate_count)*10; ?></span></li>	
							<li><b>#Dw:</b> <?php echo $entry->downloads; ?></li>
							<li><b><?php echo anchor('teedb/download/mapres/'.url_title($entry->name), 'Download'); ?></b></li>					
						</ul>
					</details>				
				</section>
				
			<?php endforeach; ?>
			<br style="clear:both">		
		</div>
		<div class="footer" style="text-align:center">
			<?php echo $this->pagination->create_links(); ?>
		</div>
			
	</section>
</section>

<div id="dialog-upload" title="Upload a mapres" style="display:none;">
	<?php echo form_open_multipart('upload/mapres/', array('onsubmit' => 'return false;'));?>
		<?php $this->load->view('mapres/uploadfile'); ?>
	<?php echo form_close(); ?>
	<br>
	<div id="upload_mapres" style="text-align:center">
		<button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Upload</span></button>
	</div>
</div>
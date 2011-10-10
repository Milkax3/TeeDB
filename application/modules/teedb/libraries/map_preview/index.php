<html>
	<head>
		<title>Teeworlds Map Preview Tool</title>
	</head>
	<body style="background: url(bgpattern.png) repeat;">

		<form enctype="multipart/form-data" method="POST">
			Choose Entitie:<br>
			<select name="mod">
	      		<option value="0">Vanilla</option>
	      		<option value="1">Race</option>
	      		<option value="2">DDRace</option>
	    	</select>
	    	<br>
			Choose a map-file to upload:<br>
			<input name="uploadmap" type="file" /><br />
			<input type="submit" value="Generate Preview" />
		</form>
		
	</body>
</html>

<?php
	if(isset($_FILES['uploadmap'])){
	
		include 'map.php';
		
		@ini_set("memory_limit",'-1');
		@set_time_limit(600);
		
		$target_path = "upload/";	
		$target_path = $target_path.basename( $_FILES['uploadmap']['name']);
		
		if(!move_uploaded_file($_FILES['uploadmap']['tmp_name'], $target_path)) {
		    echo "There was an error uploading the file, please try again!";
			return;
		}
		    
		echo "The file ".  basename( $_FILES['uploadmap']['name'])." has been uploaded";
		echo "</br>Generating Preview...</br>";
		
		$image_path = 'upload/mapres';
		
		try{
			$map = new Map($target_path);
			//$map->save_images($image_path);
			//$map->save_preview($image_path.'/previews', TRUE);
			$src_preview = $map->draw_layers('upload/previews', $_POST['mod']);
			echo 'Gamelayer generated:</br><img src="upload/previews/'.basename( $_FILES['uploadmap']['name'], '.map').'_gamelayer.png" alt="Gamelayer" width="30%" height="30%"/></br>';
			echo 'Preview generated:</br><img src="'.$src_preview.'" alt="Preview" width="30%" height="30%"/></br>';
			// $names = $map->get_image_names();
			// foreach($names as $image){
				// echo $image.' generated:</br><img src="'.$image_path.'/'.$image.'.png" alt="'.$image.'" /></br>';
			// }
		}catch(Exception $e){
			echo '<b><font color="darkred">Exception catched:</font></b> "'.$e->getMessage().'"';
		}
	
		echo '</br>END';
	}
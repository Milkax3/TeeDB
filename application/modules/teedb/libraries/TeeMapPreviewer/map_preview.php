<?php 
	include('teemap.php');
	$path = 'D:\xampp\htdocs\Communitee/upload/maps/';	

	print_r($_POST); echo "<br>";
	print_r($_FILES); echo "<br><br>";
		
	if(!isset($_FILES['Map']))
		echo "ERROR! Formulardaten fehlerhaft.<br>";
	else{	
	//MAP PREVIEW:		
		foreach($_FILES as $map){
			//Upload-------------------------------------------------------
			$name = basename($map['name'],".map");
			$size = ($map['size']/1000).'kB';
			
			if(!is_dir($path))
				mkdir($path);
			$file = $path.basename($map['name']);
			move_uploaded_file($map['tmp_name'], $file);	
			
			//Read file----------------------------------------------------
			$upMap = new Teemap(); 
      $upMap->load($file);
      $upMap->show();
      var_dump($upMap);
    		
			//print info---------------------------------------------------
			/*
			echo '<b>Name:</b> '.$name.'<br>';
			echo '<b>Size:</b> '.$size.'<br>';
      */
		}			
	//END
	}
	include('index.php');
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Teepreview {
	/**
	 * Tee Preview Generation Script
	 * by Alban 'spl0k' FERON
	 *
	 * This file can be used to generate previews of the Teeworlds skins.
	 * It takes a png skin file, create a preview png file, and display it.
	 * I assumed that all the skin files have a size of 256x128 pixels.
	 * It uses the PHP GD library.
	 *
	 * -- USAGE --
	 * First, include this file in your website code.
	 * Then, just call the display_tee() function with the path of the skin file.
	 * i.e if you have a skin stored like that: path/to/your/skin.png, the call would be like
	 * display_tee("path/to/your/skin.png");
	 * It will create a new file: path/to/your/previews/skin.png
	 * Finally, it'll add the <img> tag.
	 * The previews aren't regenerated when a skin file is modified, you have to manually delete
	 * the preview file for this script to recreate it.
	 *
	 * -- REQUIREMENTS --
	 * PHP 4 or PHP 5
	 * PHP must be compiled with the GD library or the GD module must be active.
	 * If your site is hosted on a *nix based system, be sure to 'chmod o+w' the folder where
	 * you put your skins.
	 *
	 * -- CREDITS --
	 * This script was developed by spl0k for the teeworlds-db site.
	 *
	 * http://www.teeworlds.com/
	 * http://www.teeworlds-db.com/
	 * http://spl0k.unreal-design.com/
	 */
	
	
	/**
	 * Draw a body part centered
	 *
	 * @param dest (reference) - the image resource object to paint on
	 * @param src (reference) - the image resource object of the skin
	 * @param sprite - the name of the part to draw
	 * @param x - the X component of the center where to draw
	 * @param y - the Y component of the center where to draw
	 * @param w - the width of the part on the destination image
	 * @param h - the height of the part on the destination image
	 * @return a image resource object if successful, FALSE otherwise
	 */
	
	function gfx_draw(&$dest, &$src, $sprite, $x, $y, $w, $h) {
		// Positions of the parts on the skin. We assume that the skin size is 256x128
		switch($sprite) {
			case "body":
				$srcx = 0;
				$srcy = 0;
				$srcw = 96;
				$srch = 96;
				break;
			case "body_shadow":
				$srcx = 96;
				$srcy = 0;
				$srcw = 96;
				$srch = 96;
				break;
			case "foot":
				$srcx = 192;
				$srcy = 32;
				$srcw = 64;
				$srch = 32;
				break;
			case "foot_shadow":
				$srcx = 192;
				$srcy = 64;
				$srcw = 64;
				$srch = 32;
				break;
			case "eye":
			case "eye2":
				$srcx = 64;
				$srcy = 96;
				$srcw = 32;
				$srch = 32;
				break;
		}
		// Since the GD doesn't know to mirror images (negative resizing), we have
		// to do it by hand
		if($sprite == "eye2") {
			// First we create a temp image with just the eye
			$im = imagecreatetruecolor(32, 32);
			imagealphablending($im, false);
			imagecopy($im, $src, 0, 0, $srcx, $srcy, $srcw, $srch);
			// We mirror it...
			$im = $this->mirror_x($im);
			// and we draw it on the tee.
			return imagecopyresampled($dest, $im, $x-$w/2, $y-$h/2, 0, 0, $w, $h, $srcw, $srch);
		}
		return imagecopyresampled($dest, $src, $x-$w/2, $y-$h/2, $srcx, $srcy, $w, $h, $srcw, $srch);
	}
	
	/**
	 * Mirror an image
	 * Code snippet from php.net site, by send at mail dot 2aj dot net.
	 * Modified to mirror the X axis and not the Y axis.
	 *
	 * @see http://php.net/manual/function.imagecreatetruecolor.php#54155
	 * @param input_image_resource - the image to mirror
	 * @return the mirrored image
	 */
	function mirror_x($input_image_resource)
	{
	    $width = imagesx ( $input_image_resource );
	    $height = imagesy ( $input_image_resource );
	    $output_image_resource = imagecreatetruecolor ( $width, $height );
	    // If a pixel was transparent on the input, set it to transparent on the output too
	    imagealphablending($output_image_resource, false);
	    $x = 0;
	
	    while ( $x < $width )
	    {
	        for ( $i = 0; $i < $height; $i++ )
	            imagesetpixel ( $output_image_resource, $x, $i, imagecolorat ( $input_image_resource, ( $width - 1 - $x ), ( $i ) ) );
	        $x++;
	    }
	   
	    return $output_image_resource;
	}
	
	/**
	 * Extract the parts from the skin image and build the tee
	 * This function is adapted from Teeworlds game code (gc_render.cpp, render_tee(), line 137)
	 *
	 * @param dest (reference) - the image resource object to paint on
	 * @param src (reference) - the image resource object of the skin
	 * @return TRUE if fully drawn, FALSE otherwise
	 */
	function paint(&$dest, &$src) {
		// Position of the center of the tee in the new image
		$position_x = 32.0;
		$position_y = 36.0;
	
		// first pass we draw the outline
		// second pass we draw the filling
		for($p=0; $p<2; $p++)
		{
			$outline = ($p==0);
	
			for($f=0; $f<2; $f++)
			{
				// 96.0 is the default tee size.
				$animscale = 1.0;
				$basesize = 64.0;
				if($f == 1)
				{
	
					// draw body
					$body_pos_x = $position_x;
					$body_pos_y = $position_y - 4.0 * $animscale;
					$sprite = $outline?"body_shadow":"body";
					if(!$this->gfx_draw($dest, $src, $sprite, $body_pos_x, $body_pos_y, $basesize, $basesize))
						return false;
	
					// draw eyes
					if($p == 1)
					{
						$sprite = "eye";
						
						$eyescale = $basesize*0.40;
						$h = $eyescale;
						$eyeseparation = (0.075 - 0.010)*$basesize;
						$offset_x = 0.125 * $basesize;
						$offset_y = -0.05 * $basesize;
						if(!$this->gfx_draw($dest, $src, $sprite, $body_pos_x-$eyeseparation+$offset_x, $body_pos_y+$offset_y, $eyescale, $h) ||
						!$this->gfx_draw($dest, $src, $sprite."2", $body_pos_x+$eyeseparation+$offset_x, $body_pos_y+$offset_y, $eyescale, $h))
							return false;
					}
				}
	
				// draw feet
				$w = $basesize;
				$h = $basesize/2;
	
				if($outline)
					$sprite = "foot_shadow";
				else
					$sprite = "foot";
					
				if(!$this->gfx_draw($dest, $src, $sprite, $position_x+($f==0?-7.0:7.0)*$animscale, $position_y+10.0*$animscale, $w, $h))
					return false;
			}
		}
		return true;
	}
	
	/**
	 * Create the preview file
	 *
	 * @param file - path to the skin file
	 * @return TRUE if successful, FALSE otherwise
	 */
	function create_tee($file) {
		// load the skin file
		$src = @imagecreatefrompng($file);
		if($src === false)
			return false;
		// Create the preview image and set its background transparent
		$dest = imagecreatetruecolor(64, 64);
		$back = imagecolorallocatealpha($dest, 255, 255, 255, 127);
		imagealphablending($dest, false);
		imagesavealpha($dest, true);
		imagefill($dest, 0, 0, $back);
		// Reactivate alpha blending to not erase other layers when drawing a new body part
		imagealphablending($dest, true);
		// Generating the Tee.
		if(!$this->paint($dest, $src))
			return false;
		// Saving the image to the disk.
		
		$filepreview = strtr(basename($file),Array("ä"=>"ae","ö"=>"oe","ü"=>"ue"));
		if(!@imagepng($dest, dirname($file)."/preview/".$filepreview))
			return false;
		// Freeing memory
		imagedestroy($src);
		imagedestroy($dest);
		return true;
	}
	
	/**
	 * Main function, take a path to a skin file, generate the preview if needed and display it.
	 * The folder you put your skins in must be writable by all users in order for the script
	 * to create the preview folder.
	 * If there's a problem creating the preview folder or the preview itself, it displays nothing
	 *
	 * @param file - The path to the skin file
	 * @return TRUE if successful, FALSE if there's a problem
	 */
	function display_tee($file) {
		$bErr = false;
		// Check if the previews folder exists. If not, create it and generate the preview
		if(!is_dir(dirname($file)."/previews")) {
			if(!@mkdir(dirname($file)."/previews"))
				$bErr = true;
			else {
				@chmod(dirname($file)."/previews", 0777);
				if(!create_tee($file))
					$bErr = true;
			}
		}
		// else if the folder exists but not the preview, generate it
		else if(!is_file(dirname($file)."/previews/".basename($file))) {
			if(!create_tee($file))
				$bErr = true;
		}
	
			// display the preview
			echo "<img src=\"/".dirname($file)."/previews/".basename($file)."\" alt=\"".basename($file)."\" />";
		return !$bErr;
	}
}
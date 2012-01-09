<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Skin Preview Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Previews
 * @author		spl0k redesigned by Andreas Gehle
 * @link		http://spl0k.unreal-design.com
 */
class Skin_preview {

	protected $CI;
	
	protected $name		= '';
	protected $zoom		= 1;
	
	private $size;
	
	const BODY_SIZE 	= 96;
	const EYE_SIZE 		= 32;
	const HAND_SIZE 	= 32;
	const FEET_WIDTH 	= 64;
	const FEET_HEIGHT 	= 32;
		
	const PREV_FOLDER	= '/previews/';
	
	const EYE_NORMAL	= 1;
	const EYE_ANGRY		= 2;
	const EYE_SAD		= 3;
	const EYE_HAPPY		= 4;
	const EYE_PLUS		= 5;
	const EYE_KATA		= 6;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->CI =& get_instance();

		//Load additional libraries, helpers, etc.
		$this->CI->load->config('teedb/teedb');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Create the preview file
	 *
	 * @access public
	 * @param file Path to the skin file
	 * @return boolean
	 */
	public function create($file)
	{
		//Set preview image size
		$this->size = 64 * $this->zoom;
		
		//Set preview name
		$this->name = pathinfo($file, PATHINFO_FILENAME);
		
		//load the skin file
		if(!$src = @imagecreatefrompng($this->CI->config->item('upload_path_skins').'/'.$file))
		{
			return FALSE;
		}
		
		// Create the preview image and set its background transparent
		$image = imagecreatetruecolor($this->size, $this->size);
		imagealphablending($image, FALSE);
		imagesavealpha($image, TRUE);
		$trans_color = imagecolorallocatealpha($image, 255, 255, 255, 127);
		imagefill($image, 0, 0, $trans_color);
		
		// Reactivate alpha blending to not erase other layers when drawing a new body part
		imagealphablending($image, TRUE);
		
		// Generating the Tee.
		if(!$this->_paint($image, $src))
		{
			return FALSE;
		}
		imagedestroy($src);
		
		// Saving the image to the disk.
		$target = $this->CI->config->item('upload_path_skins').self::PREV_FOLDER.$this->name.'.png';
		if(!imagepng($image, $target))
		{
			return FALSE;
		}
		imagedestroy($image);
		
		return TRUE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Create full preview
	 * TODO
	 */
	public function create_full(&$file)
	{
		
	}

	// --------------------------------------------------------------------
	
	/**
	 * Extract the parts from the skin image and build the tee
	 * This function is adapted from Teeworlds game code (gc_render.cpp, render_tee(), line 137)
	 *
	 * @access private
	 * @param image The image resource object to paint on
	 * @param image The image resource object of the skin
	 * @param integer Move the tee preview on the x axis
	 * @param integer Move the tee preview on the y axis
	 * @param integer The eye mode. Values [1-6]
	 * @return boolean
	 */
	private function _paint(&$preview, &$src, $offset_x = 0, $offset_y = 0, $eye = self::EYE_NORMAL)
	{
		//Positions
		$feet_left_x = -7 + $offset_x;
		$feet_right_x = $feet_left_x + 14 + $offset_x;
		$feet_y = 30 + $offset_y;
		$eye_left_x = 23.04 + $offset_x;
		$eye_right_x = $eye_left_x + 8 + $offset_x;
		$eye_y = 16 + $offset_y;
		
		//Draw the background, tee shadow and outlines
		//Feet shadow
		imagecopy($preview, $src, $feet_left_x, $feet_y, 192, 64, self::FEET_WIDTH, self::FEET_HEIGHT);
		imagecopy($preview, $src, $feet_right_x, $feet_y, 192, 64, self::FEET_WIDTH, self::FEET_HEIGHT);
		//Body shadow
		imagecopyresampled($preview, $src, $offset_x, $offset_y, 96, 0, 64, 64, self::BODY_SIZE, self::BODY_SIZE);
		
		//Draw the tee
		//Foot left
		imagecopy($preview, $src, $feet_left_x, $feet_y, 192, 32, self::FEET_WIDTH, self::FEET_HEIGHT);
		//Body
		imagecopyresampled($preview, $src, $offset_x, $offset_y, 0, 0, 64, 64, self::BODY_SIZE, self::BODY_SIZE);
		//Foot right
		imagecopy($preview, $src, $feet_right_x, $feet_y, 192, 32, self::FEET_WIDTH, self::FEET_HEIGHT);
		//Eye left
		imagecopyresampled($preview, $src, $eye_left_x, $eye_y, 64, 96, 25.6, 25.6, self::EYE_SIZE, self::EYE_SIZE);
		//Eye right
		$eye_mirrored = &$this->_mirror_x($src, 64, 96, self::EYE_SIZE, self::EYE_SIZE);
		imagecopyresampled($preview, $eye_mirrored, $eye_right_x, $eye_y, 0, 0, 25.6, 25.6, self::EYE_SIZE, self::EYE_SIZE);
		imagedestroy($eye_mirrored);
	
		return TRUE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Mirror an image horizontally
	 *
	 * @param image The image copy from
	 * @param integer Copy from x
	 * @param integer Copy from y
	 * @param integer Width
	 * @param interger Height
	 * @return image The mirrored image
	 */
	private function _mirror_x(&$src, $pos_x, $pos_y, $width, $height)
	{
		$image_mirrored = imagecreatetruecolor($width, $height);
		imagealphablending($image_mirrored, FALSE);
		imagesavealpha($image_mirrored, TRUE);
		$trans_color = imagecolorallocatealpha($image_mirrored, 255, 255, 255, 127);
		imagefill($image_mirrored, 0, 0, $trans_color);
		
		imagealphablending($image_mirrored, TRUE);
		
		for($x=0; $x < $width; $x++)
		{
			imagecopy($image_mirrored, $src, $x, 0, $pos_x+($width-1-$x), $pos_y, 1, $height);
		}
	   
	    return $image_mirrored;
	}
}

/* End of file: Skin_preview.php */
/* Location: application/libraries/Skin_preview.php */
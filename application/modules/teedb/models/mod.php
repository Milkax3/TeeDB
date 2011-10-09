<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Mod Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Mod extends CI_Model {
	
	const TABLE = 'teedb_mods';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}
}

/* End of file: mod.php */
/* Location: application/modules/teedb/models/mod.php */
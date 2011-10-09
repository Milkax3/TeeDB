<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Map Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Gameskin extends CI_Model {
	
	const TABLE = 'teedb_gameskins';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}
}

/* End of file: gameskin.php */
/* Location: application/modules/teedb/models/gameskin.php */
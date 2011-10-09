<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Demo Model Class
 *
 * @package		Application
 * @subpackage	Models
 * @category	Model
 * @author		Andreas Gehle
 */
class Demo extends CI_Model {
	
	const TABLE = 'teedb_demos';
		
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->database();
	}
}

/* End of file: demo.php */
/* Location: application/modules/teedb/models/demo.php */
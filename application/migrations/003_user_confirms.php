<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Confirm Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_User_Confirms extends CI_Migration {
	
	/**
	 * Name of the table
	 */	
	const TABLE = 'user_confirms';
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists(self::TABLE))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_field("KEY `user_id` (`user_id`)");
			$this->dbforge->add_field("UNIQUE KEY `link` (`link`)");
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'link' => array('type' => 'VARCHAR', 'constraint' => '32', 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE, 'default' => NULL),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table(self::TABLE, TRUE);
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table(self::TABLE);
	}
}

/* End of file 003_user_confirms.php */
/* Location: ./application/migrations/003_user_confirms.php */
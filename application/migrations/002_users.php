<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Users extends CI_Migration {
	
	/**
	 * Name of the table
	 */	
	const TABLE = 'users';
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists(self::TABLE))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_field("UNIQUE KEY `name` (`name`)");
			$this->dbforge->add_field("UNIQUE KEY `email` (`email`)");
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => FALSE),
				'email' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'status' => array('type' => 'INT', 'constraint' => 4, 'null' => FALSE, 'default' => 0),
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

/* End of file 002_users.php */
/* Location: ./application/migrations/002_users.php */
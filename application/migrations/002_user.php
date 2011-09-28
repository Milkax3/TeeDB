<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('user'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);		
			$this->dbforge->add_field("UNIQUE KEY `name` (`name`)");
			$this->dbforge->add_field("UNIQUE KEY `email` (`email`)");
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'email' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'status' => array('type' => 'TINYINT', 'constraint' => 4, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('user', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('user');
	}
}
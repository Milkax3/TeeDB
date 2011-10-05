<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_TeeDB_Skin extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('teedb_skin'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_field("UNIQUE KEY `name` (`name`)");
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'discription' => array('type' => 'TEXT', 'null' => FALSE),
				'downloads' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('teedb_skin', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('teedb_skin');
	}
}
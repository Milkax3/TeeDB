<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_TeeDB_Rate extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('teedb_rate'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'type_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'type' => array('type' => 'ENUM', 'constraint' => "'blog','user','skin','mapres','map','gameskin','mod','demo'", 'null' => FALSE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'value' => array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('teedb_rate', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('teedb_rate');
	}
}
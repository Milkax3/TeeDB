<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Teerank_Matche extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('teerank_matche'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('map_id');
			$this->dbforge->add_key('mod_id');
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'map_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'mod_id' => array('type' => 'ENUM', 'constraint' => "'1on1','tournament'", 'null' => FALSE),
				'mod' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'server' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'port' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('teerank_matche', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('teerank_matche');
	}
}
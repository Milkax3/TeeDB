<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Sessions extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('sessions'))
		{
			$this->dbforge->add_key('session_id', TRUE);
			
			$this->dbforge->add_field(array(
				'session_id' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => FALSE, 'default' => '0'),
				'ip_address' => array('type' => 'VARCHAR', 'constraint' => '16', 'null' => FALSE, 'default' => '0'),
				'user_agent' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => FALSE),
				'last_activity' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'user_data' => array('type' => 'TEXT', 'null' => FALSE, 'default' => '')
			));

			$this->dbforge->create_table('sessions', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('sessions');
	}
}
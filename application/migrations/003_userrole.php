<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Userrole extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('userrole'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'role' => array('type' => 'ENUM', 'constraint' => "'editNews','writeNews','editComments','writeTournaments','openReports','enterDashboard'", 'null' => FALSE),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('userrole', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('userrole');
	}
}
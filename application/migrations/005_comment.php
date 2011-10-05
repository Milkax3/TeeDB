<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Comment extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('comment'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'comment' => array('type' => 'TEXT', 'null' => FALSE),
				'type_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'type' => array('type' => 'ENUM', 'constraint' => "'blog','user','skin','mapres','map','gameskin','mod','demo'", 'null' => FALSE),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('comment', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('comment');
	}
}
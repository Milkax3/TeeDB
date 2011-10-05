<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_TeeRank_Player extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('teerank_player'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_key('match_id');
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'match_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'score' => array('type' => 'INT', 'constraint' => 11, 'null' => FALSE, 'default' => 0),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('teerank_player', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('teerank_player');
	}
}
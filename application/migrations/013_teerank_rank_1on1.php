<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_TeeRank_Rank_1on1 extends CI_Migration {
	
	function up() 
	{	
		if ( ! $this->db->table_exists('teerank_rank_1on1'))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'score' => array('type' => 'INT', 'constraint' => 11, 'null' => FALSE, 'default' => 0),
				'oldPlace' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				'update' => array('type' => 'DATETIME', 'null' => FALSE),
				'create' => array('type' => 'DATETIME', 'null' => FALSE)
			));

			$this->dbforge->create_table('teerank_rank_1on1', TRUE);
		}
	}

	function down() 
	{
		$this->dbforge->drop_table('teerank_rank_1on1');
	}
}
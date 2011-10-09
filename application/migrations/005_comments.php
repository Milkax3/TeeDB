<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Comments extends CI_Migration {
	
	/**
	 * Name of the table
	 */	
	const TABLE = 'comments';
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists(self::TABLE))
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

/* End of file 005_comments.php */
/* Location: ./application/migrations/005_comments.php */
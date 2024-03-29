<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TeeDB Mods Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_TeeDB_Mods extends CI_Migration {
	
	/**
	 * Name of the table
	 */	
	const TABLE = 'teedb_mods';
	
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
			$this->dbforge->add_field("UNIQUE KEY `name` (`name`)");
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'server' => array('type' => 'INT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				'client' => array('type' => 'INT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
				'link' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'downloads' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
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

/* End of file 011_teedb_mods.php */
/* Location: ./application/migrations/011_teedb_mods.php */
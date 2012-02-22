<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TeeDB Rates Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_TeeDB_Downloads extends CI_Migration {
		
	/**
	 * Name of the table
	 */	
	const TABLE = 'teedb_downloads';
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		if ( ! $this->db->table_exists(self::TABLE))
		{
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'type_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'type' => array('type' => 'ENUM', 'constraint' => "'skin','mapres','map','gameskin','mod','demo'", 'null' => FALSE),
				'ip' => array('type' => 'BIGINT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'date' => array('type' => 'DATETIME', 'null' => FALSE)
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

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
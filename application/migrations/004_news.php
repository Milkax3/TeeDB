<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * News Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_News extends CI_Migration {
	
	/**
	 * Name of the table
	 */	
	const TABLE = 'news';
	
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
			$this->dbforge->add_field("UNIQUE KEY `title` (`title`)");
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'title' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'content' => array('type' => 'TEXT', 'null' => FALSE),
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
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

/* End of file 004_news.php */
/* Location: ./application/migrations/004_news.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		//IMPORTATNT: Enable Migratetion in config file only if needed
		//Set to false up after working.
		$this->load->library('migration');
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate current
	 * 
	 * This will migrate to the configed migration version
	 */
	public function current()
	{
		if ( ! $this->migration->current())
		{
			show_error($this->migration->error_string());
			exit;
		}

		$this->output->append_output("<br />Migration Successful<br />");
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate latest
	 * 
	 * This will migrate to the latest migration version
	 */
	public function latest()
	{
		if ( ! $this->migration->latest())
		{
			show_error($this->migration->error_string());
			exit;
		}

		$this->output->append_output("<br />Migration Successful<br />");
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate to version
	 * 
	 * This will migrate up/down to the given migration version
	 * 
	 * @param int
	 * @return void
	 */
	public function version($id = NULL)
	{
		// No $id supplied? Use the config version
		$id OR $id = $this->config->item('migration_version');

		if ( ! $this->migration->version($id))
		{
			show_error($this->migration->error_string());
			exit;
		}

		$this->output->append_output("<br />Migration Successful<br />");
	}
}

/* End of file migrate.php */
/* Location: ./application/controllers/migrate.php */
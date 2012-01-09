<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skin extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('teedb/Skin_preview');
		$this->load->helper('url');
	}
	
	public function index()
	{
		$file = 'coala';
		
		$this->skin_preview->create($file.'.png');
		$this->output->append_output('<img src="'.base_url().'uploads/skins/'.$file.'.png" />');
		$this->output->append_output('<img src="'.base_url().'uploads/skins/previews/'.$file.'.png" />');
	}
}
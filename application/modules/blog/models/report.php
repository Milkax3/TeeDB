<?php 
class Report extends Model{
	
	function __constructor(){
		// Call the Model constructor
		parent::Model();
	}
	
	function setReportByInput(){
		$this->db->set('type_id', $this->input->post('id'));
		$this->db->set('type', $this->input->post('type'));
		$this->db->set('report', $this->input->post('reportText'));
		$this->db->set('user_id', $this->auth->getCurrentUserID());
		$this->db->set('update', 'NOW()', FALSE);
		$this->db->set('create', 'NOW()', FALSE);
		$this->db->insert('report');
	}
}
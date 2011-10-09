<?php

class Reports extends Controller{
	
	private $name;

	function Reports(){
		parent::Controller();
	}
	
	public function submit(){			
		if($this->_submit_validate() === FALSE) {
			$this->load->view('html_blank',  array('echo' => '<div class="ui-widget">'.
					'<div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all">'.
					validation_errors('<p style="float:left;"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>', '</p>').
					'<div style="clear:both;"></div>'.
					'</div></div>'));
			return;
		}

		$this->load->model('Report');
		$this->Report->setReportByInput();
		
		$this->load->view('html_blank', array('echo' => '<div class="dialog-info" class="ui-widget" id="info">
				<div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em;">
					<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
						Your Report was sucsessfully sent.
					</p>
				</div>
			</div>
			<br />'));
		return;
	}

	private function _submit_validate(){
		$this->form_validation->set_rules('type', 'type',
			'trim|required|alpha_dash|callback__enumType');
		
		$this->form_validation->set_rules('id', 'ID',
			'trim|required|integer|is_natural_no_zero|min_length[1]|callback__issetID');

		$this->form_validation->set_rules('report', 'report selection',
			'trim|required|alpha_dash|callback__enumReport');

		$this->form_validation->set_rules('reportText', 'reporttext',
			'trim|required|callback__reportTrim|uniqueByType[report.report.'.$this->input->post('type').'.'.$this->input->post('id').']
			|htmlspecialchars|encode_php_tags|last[report.3.'.$this->input->post('type').'.'.$this->input->post('id').']');
		
		return $this->form_validation->run();
	}

	function _enumType($type) {
		$this->form_validation->set_message('_enumType','Invalid type.');
		
		switch($type){
			case 'news':
			case 'skin':
			case 'mapres': 
			case 'demo': 
			case 'map': 
			case 'gameskin': 
			case 'user':  
			case 'comment': 
				return TRUE;
			default: return FALSE;
		}		
	}
	
	function _enumReport($report) {
		$this->form_validation->set_message('_enumReport','Invalid report selection.');
		
		switch($report){
			case 'Bug': $_POST['reportText'] = 'Bug found.'; break;
			case 'Content': $_POST['reportText'] = 'Wrong Content.'; break;
			case 'Stolen': $_POST['reportText'] = 'Stolen: '.$this->input->post('reportText'); break;
			case 'Other': $_POST['reportText'] = 'Other: '.$this->input->post('reportText'); break;
			case 'Language': $_POST['reportText'] = 'Wrong Language.'; break;
				return TRUE;
			default: return FALSE;
		}		
	}
	
	function _reportTrim($text){
		$this->form_validation->set_message('_reportTrim','The %s field is required.');
		
		switch($text){
			case 'Other: Reason here...': 
			case 'Stolen: Proof here...': 
			case 'Stolen:': 
			case 'Other:': 
				return FALSE;
			default: return TRUE;
		}
	}

	function _issetID($id) {	
		$this->form_validation->set_message('_issetID','No entry found with this ID.');
		
		$type = $this->input->post('type');
		$this->load->model($type);
		return $this->$type->checkID($id);		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
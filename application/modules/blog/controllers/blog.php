<?php

class Blog extends Controller{

  function __construct(){
    parent::__construct();
  }
  
  public function delete(){
    $this->load->model('News');
    
    if($this->_delete_validate() === FALSE) {
      $data['echo'] = validation_errors('<p class="error">','</p>');
      $this->load->view('html_blank', $data);
      return;
    }
    
    if(!$this->auth->userCan('editNews') and $this->News->getUserID($this->input->post('id')) != $this->auth->getCurrentUserID()){
      $data['echo'] = 'You have not the rights to do that!';
      $this->load->view('html_blank', $data);
      return;      
    }
    
    $this->News->delete($this->input->post('id'));
      
    $data['echo'] = 'News successfully deleted';
    $this->load->view('html_blank', $data);
  }

  private function _delete_validate(){
    // validation rules
    $this->form_validation->set_rules('id', 'ID',
      'trim|required|integer|is_natural_no_zero|min_length[1]|callback__issetID');
    $this->form_validation->set_message('_issetID','No entry found with this ID.');

    return $this->form_validation->run();
  }
  
  function _issetID($id) {  
    return $this->News->checkID($id);
  }
}
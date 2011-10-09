<?php
/**
 * Ajax Comments Controller
 * @author Andi
 * Only for Post requests
 */
class Comments extends Controller{
	
	private $name;

	function Comments(){
		parent::Controller();
		if(!$this->auth->getCurrentUserID())
			return;
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
				
		$this->load->model(array('User', 'Comment'));		
		$com_id = $this->Comment->setComment($this->input->post('type'));
		$comment = $this->Comment->getComment($com_id, $this->input->post('type'));
		
		$this->load->view('html_blank', array('echo' => '<div class="ui-widget">'.
				'<div style="padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all">'.
				'<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>'.
				'Comment added.</p>'.
				'</div></div>
				<TRENNER>
				<section class="comment" id="comment-'.$comment->id.'" style="padding-bottom:10px">
					<header style="float: left;">
						<figure style="float: left;">
							 <img src="'.$this->User->getAvatar($comment->name).'" alt="Avatar">
						</figure>
						<details open="open" style="float: right">
							<ul>
								<li class="posted">Posted by '.anchor('profile/name/'.url_title($comment->name), $comment->name).'</li>
								<li class="time">
									<time datetime="'.date('c', human_to_unix($comment->update)).'" >
										'.datetime_to_human($comment->update).'
									</time>
								</li>						
							</ul>
						</details>
					</header>
					<article style="clear:both;">
						'.$comment->comment.'
					</article>
				</section>'));
		return;
	}

	private function _submit_validate(){
		$this->load->helper('type');
		$this->form_validation->set_rules('type', 'Type',
			'trim|required|alpha_dash|callback_checkCommentTypes');
		
		$this->form_validation->set_rules('id', 'ID',
			'trim|required|integer|is_natural_no_zero|min_length[1]|callback__issetID');

		$this->form_validation->set_rules('comment', 'comment',
			'trim|required|uniqueByType[comment.comment.'.$this->input->post('type').'.'.$this->input->post('id').']
			|htmlspecialchars|encode_php_tags|last[comment.3.'.$this->input->post('type').'.'.$this->input->post('id').']');
		
		$this->form_validation->set_message('checkCommentTypes','Invalid type.');
		$this->form_validation->set_message('_issetID','No entry found with this ID.');

		return $this->form_validation->run();
	}

	function _issetID($id) {	
		$type = $this->input->post('type');
		$this->load->model($type);
		return $this->$type->checkID($id);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
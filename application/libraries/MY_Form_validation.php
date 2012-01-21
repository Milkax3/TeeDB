<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Form Validation Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Validation
 * @author		Andreas Gehle
 */
class MY_Form_validation extends CI_Form_validation {

	/**
	 * Unique in table
	 * 
	 * @access	public
	 * @param	string
	 * @param	string	Must be in the format Table.column
	 * @return	bool
	 */
	public function unique($str, $params)
	{
		$this->CI->load->database();
		$this->CI->form_validation->set_message('unique', 'The %s is already in use.');

		list($table, $field) = explode(".", $params, 2);

		$query = $this->CI->db->select($field)->from($table)->where($field, $str)->limit(1)->get();

		if ($query->row())
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Exist in table
	 * 
	 * @access	public
	 * @param	string
	 * @param	string	Must be in the format Table.column
	 * @return	bool
	 */
	public function exist($str, $params)
	{
		$this->CI->form_validation->set_message('exist', 'The %s doesnt belong to any account.');
		return !$this->unique($str, $params);
	}

	// --------------------------------------------------------------------

	/**
	 * Spam protection
	 * 
	 * Checks if last {$max = 3} entries insert by the same user.
	 * Requires a 'user_id' and 'create' field in table.
	 * user_id - unsigned int foreign key
	 * create - datetime
	 * 
	 * @access	public
	 * @param	string
	 * @param	string	Must be in format Table or Table.Max
	 * @return	bool
	 */
	public function no_spam($value, $params)
	{
		$max = 3;
		
		$this->CI->load->database();
		$this->CI->form_validation->set_message('no_spam', 'Spam protection.');

		list($table, $max) = explode(".", $params, 2);

		$query = $this->CI->db->select('user_id')->from($table)->order_by('create')->limit($max)->get();

		if ($query->num_rows() < $max)
		{
			return TRUE;		
		}
		
		foreach ($query->result() as $row)
		{
			if (!isset($last))
			{
				$last = $row->user_id;
			}
			elseif ($last != $row->user_id)
			{
				return TRUE;
			}
		}
			
		return FALSE;
	}

}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */

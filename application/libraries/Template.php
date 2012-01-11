<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Template Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Output
 * @author		Andreas Gehle
 */
class Template {
	
	protected $CI;	
	
	protected $theme		= 'default';
	protected $layouts   	= array();
	protected $layout_data 	= array();	
	public $header_data		= array();
	protected $footer_data	= array();
	
	protected $css 			= array();
	protected $js 			= array();
	
	
	/**
	 * Constructor
	 */
	function __construct($config = array())
	{			
		$this->CI =& get_instance();
			
		if( count($config) > 0)
		{
			$this->initialize($config);
		}
		else
		{
			$this->_load_config_file();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	public function initialize($props = array())
	{
		if (count($props) > 0)
		{
			foreach ($props as $key => $val)
			{
				$this->$key = $val;
			}
		}
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Load template config
	 * 
	 * Load template specific config items from config/template.php
	 */
	private function _load_config_file()
	{
		if ( ! @include(APPPATH.'config/template'.EXT))
		{
			return FALSE;
		}

		foreach($template as $key => $item)
		{
			switch($key)
			{
				case 'title':
				case 'author':
				case 'description':
					$this->header_data[$key] = $item;
					break;
				case 'google_analytic_id':
					$this->footer_data[$key] = $item;
					break;
				default:
					$this->$key = $item;
					break;
			}
		}
		unset($template);

		return TRUE;
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Load template config
	 * 
	 * Load template specific config items from config/template.php
	 */
	public function view($view, $data = NULL){
		$this->CI->load->view('templates/'.$this->theme.'/header', $this->header_data);
		
		foreach($this->layouts as $layout)
		{
			if(isset($this->layout_data[$layout]))
			{
				$this->CI->load->view('templates/'.$this->theme.'/'.$layout, $this->layout_data[$layout]);				
			}
			else
			{
				$this->CI->load->view('templates/'.$this->theme.'/'.$layout);
			}
		}
		
		if($data == NULL)
		{
			$this->CI->load->view($view);
		}
		else {			
			$this->CI->load->view($view, $data);
		}
		
		$this->CI->load->view('templates/'.$this->theme.'/footer', $this->footer_data);
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Set layouts
	 * 
	 * Layouts will be loaded after header
	 */
	public function set_layout_data($layout, $data)
	{
		if( in_array($layout, $this->layouts))
		{
			$this->layout_data[$layout] = $data;
			return TRUE;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Set Subtitle
	 * 
	 * Subtitle will be add to title
	 */
	public function set_subtitle($subtitle)
	{
		if(isset($this->header_data['title']))
		{
			$this->header_data['title'] = $subtitle.' - '.$this->header_data['title'];
		}
		else
		{
			$this->header_data['title'] = $subtitle;
		}
	}
}
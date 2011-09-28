<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function compress()
{
	$CI =& get_instance();
	$buffer = $CI->output->get_output();
	 
	$search = array(
	    '/\>[^\S ]+/s',    //strip whitespaces after tags, except space
	    '/[^\S ]+\</s',    //strip whitespaces before tags, except space
	    '/(\s)+/s'    // shorten multiple whitespace sequences
	    );
	$replace = array(
	    '>',
	    '<',
	    '\\1'
	    );
	$buffer = preg_replace($search, $replace, $buffer);
	 
	$CI->output->set_output($buffer);
	$CI->output->_display();  
}

/**
 * Compress HTML Output (Also with CI Cache)
 * 
 * warning: if you generate XML, HTML Tidy will break it (by adding some HTML: doctype, head, body..) 
 * if not configured properly
 */
function compress_tidy()
{
	$CI =& get_instance();
	$buffer = $CI->output->get_output();
	 
	$options = array(
	    'clean' => true,
	    'hide-comments' => true,
	    'indent' => true
	    );
	 
	$buffer = tidy_parse_string($buffer, $options, 'utf8');
	tidy_clean_repair($buffer);
	// warning: if you generate XML, HTML Tidy will break it (by adding some HTML: doctype, head, body..) if not configured properly
	 
	$CI->output->set_output($buffer);
	$CI->output->_display();  
}
 
/* End of file compress.php */
/* Location: ./system/application/hools/compress.php */
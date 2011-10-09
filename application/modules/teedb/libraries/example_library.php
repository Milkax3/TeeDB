<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Example_library
{
	function __construct($config = NULL)
	{
		$CI =& get_instance();

		if ( ! is_null($config) )
		{
			ob_start();
			var_dump($config);
			$dump = ob_get_contents();
			ob_end_clean();

			$CI->output->append_output(
				"Example_library config file:<br />".$dump
			);
		}

		$CI->output->append_output(
			"Example_library constructed.<br /><br />"
		);
	}

	function example()
	{
		ob_start();
		var_dump(func_get_args());
		$dump = ob_get_contents();
		ob_end_clean();

  		$this->output->append_output(
			"Welcome from the module 'Example', library 'example_library', method 'example'.<br />".$dump
		);
	}

}

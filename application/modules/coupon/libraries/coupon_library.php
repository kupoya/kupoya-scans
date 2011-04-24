<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Base_Library
{

	private $_ci;
	
	function __construct()
	{
		$this->_ci =& get_instance();

	}
	
	
}
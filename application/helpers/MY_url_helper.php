<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter URL extended Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Liran Tal <liran@kupoya.com>
*/

// ------------------------------------------------------------------------


/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
function site_url($uri = '')
{
	
	// if we recieved a full path simply return it and do not change
	if ( (substr($uri, 0, 7) === 'http://') || (substr($uri, 0, 8) === 'https://') )
		return $uri;

	$CI =& get_instance();
	return $CI->config->site_url($uri);
}

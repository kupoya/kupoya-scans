<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter User Experience Helper
*
* @package		User Experience
* @subpackage	CodeIgniter
* @category		Helpers
* @author       Liran Tal <liran@kupoya.com>
*/



/**
 * user_language
 *
 * returns the language detected as appropriate for the user based on automatic detection
 * or statically defined.
 *
 * @access	public
 * @param	string
 * @return	string
 */
function user_language()
{
	
	$CI =& get_instance();
	$CI->load->library('session');
	
	$lang = $CI->session->userdata('user_language');
	if ($lang)
		return $lang;
		
	// if no language was detected we return default - english
	return 'en-us';
	
}

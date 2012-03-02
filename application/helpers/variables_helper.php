<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Database variables helper
*
* @package		Database
* @subpackage	CodeIgniter
* @category		Helpers
* @author       Liran Tal <liran@kupoya.com>
*/


// cache variables value for an hour
define('VARIABLES_GET_CACHE', 3600);

/**
 * variable_get
 *
 * returns a variable value by key
 *
 * @access	public
 * @param	string
 * @return	string
 */
function variable_get($strategy_id = null, $key = null)
{

	if (!$key || !$strategy_id)
		return false;
	
	$CI =& get_instance();
	// load required libraries
	$CI->load->library('cache');

	// load required models
	$CI->load->model('variables_model');
	
	$value = $CI->cache->model('variables_model', 'get_variable', 
								array($strategy_id, $key), VARIABLES_GET_CACHE);

	return $value;
}

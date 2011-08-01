<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter Microsite Helper
*
* @package		Microsite
* @subpackage	CodeIgniter
* @category		Helpers
* @author       Liran Tal <liran@kupoya.com>
*/



/**
 * html_tags
 *
 * returns allowed HTML tags to be used in HTML output string/view for microsites
 *
 * @access	public
 * @param	string
 * @return	string
 */
function html_tags()
{
	return '<p><h1><h2><h3><img><a><br>';

}

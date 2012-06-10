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


/**
 * time_ago
 * 
 * returns a 'time ago' formatted string based on a given date
 * 
 */
function time_ago($date)
{
	
	if (empty($date)) {
		return FALSE;
	}

	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	$now = time();
	$unix_date = strtotime($date);

	// check validity of date
	if (empty($unix_date)) {
		return FALSE;
	}

	// is it future date or past date
	if ($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense = "ago";
	} else {
		$difference = $unix_date - $now;
		$tense = "from now";
	}

	for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	}

	$difference = round($difference);

	if ($difference != 1) {
		$periods[$j].= "s";
	}

	return "$difference $periods[$j] {$tense}";

}
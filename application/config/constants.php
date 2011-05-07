<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
 * Detect AJAX Request for MY_Session
 */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'); 


/*
 * Adapting the implementation for automatically setting the base_url 
 * from CodeIgniter's wiki: http://codeigniter.com/wiki/Automatic_configbase_url/
 * 
 * setup the base_url. i.e: http://somesite/daloradius-ng
 */
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http").
 			"://".$_SERVER['HTTP_HOST'].
 			str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

// setup the base_uri
// i.e: daloradius-ng/
$base_uri = parse_url($base_url, PHP_URL_PATH);
if(substr($base_uri, 0, 1) != '/') $base_uri = '/'.$base_uri;
if(substr($base_uri, -1, 1) != '/') $base_uri .= '/';


// the application_folder
$base_app_folder = 'application/';

define('BASE_URL', $base_url);
define('BASE_URI', $base_uri);
define('APPPATH_URI', $base_uri.$base_app_folder);
define('APPPATH_URL', $base_url.$base_app_folder);


// we dont need these variables any more
unset($base_uri, $base_url, $base_app_folder);


/* End of file constants.php */
/* Location: ./application/config/constants.php */
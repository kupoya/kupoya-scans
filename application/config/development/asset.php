<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Asset Directory
|--------------------------------------------------------------------------
|
| Absolute path from the webroot to your CodeIgniter root. Typically this will be your APPPATH,
| WITH a trailing slash:
|
|	/assets/
|
*/

$config['asset_location'] = 'views/assets/';
$config['asset_dir'] = APPPATH_URI . $config['asset_location'];

/*
|--------------------------------------------------------------------------
| Asset URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	/assets/
|
*/

$config['asset_url'] = config_item('base_url').APPPATH . $config['asset_location'];

/*
|--------------------------------------------------------------------------
| Theme Asset Directory
|--------------------------------------------------------------------------
|
*/

//$config['theme_asset_dir'] = APPPATH_URI . 'themes_2/';
$config['theme_asset_dir'] = BASE_URI . 'themes/';

/*
|--------------------------------------------------------------------------
| Theme Asset URL
|--------------------------------------------------------------------------
|
*/

//$config['theme_asset_url'] = config_item('base_url').APPPATH.'themes_2/';
$config['theme_asset_url'] = config_item('base_url').'themes/';

/*
|--------------------------------------------------------------------------
| Asset Sub-folders
|--------------------------------------------------------------------------
|
| Names for the img, js and css folders. Can be renamed to anything
|
|	/assets/
|
*/
$config['asset_img_dir'] = 'img';
$config['asset_js_dir'] = 'js';
$config['asset_css_dir'] = 'css';
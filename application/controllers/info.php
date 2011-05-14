<?php

class Info extends MY_Controller {
	
	const INFO_PAGE_CACHE_TIME = 3600;
	
	
	function __construct()
	{
		parent::__construct();
		$this->lang->load(array('app'), 'english');

	}
	
	
	/**
	 * Privacy Policy page
	 * build the cached privacy policy page
	 */
	function privacy_policy() {
		
		$data = array();
		$this->template->set_cache(self::INFO_PAGE_CACHE_TIME);
		$this->template->build('privacy_policy', $data);
		
	}
	
	
}
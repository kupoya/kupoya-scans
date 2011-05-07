<?php 

// requires the facebook php sdk
//error_log('inside fbconnect class');
//error_log(APPPATH);
require_once(APPPATH.'libraries/facebook/facebook.php');
//require('facebook/facebook.php');

// extend and build upon the facebook php sdk
class FBConnect extends Facebook {
	
	public $fb = null;
	
	// CI super global object
	private $_ci;
	
	public $config = null;
	
	public $urlNext = null;
	public $urlCancel = null;
	
	// the user object
	public $user = null;
	// the user id
	public $user_id = null;
	
	public function __construct($initialize = array()) {
		
		$this->_ci =& get_instance();
		
		//loading the config paramters for facebook (where we stored our Facebook API and SECRET keys
		$ret = $this->_ci->config->load('facebook');
		if ($ret !== false)
			$this->config = $this->_ci->config->item('facebook');
		
		//make sure the session library is initiated. may have already done this in another method.
		$this->_ci->load->library('session');
		
		if (!isset($initialize['config']) || !$initialize['config']) {
			$params = array(
				'appId'		=> $this->config['app_id'],
				'secret'	=> $this->config['app_secret'],
			 	'cookie'	=> true,
				//'domain'
				//'fileUpload'
			);
		}
		
		parent::__construct($params);
		
		
		if (!isset($initialize['initSession']) || $initialize['initSession'] === true) {
						
			// if session is valid, attempting to get user info
			if($this->getSession()) {
				try {
					//get information from the fb object
			    	$this->user_id = $this->getUser(); 
			    	$this->user = $this->api('/me');
			    	
			  	} catch (FacebookApiException $e) {
			    	error_log($e);
			  	}
			}

			return $this->session;
			
		}
	
		
	}
	
	
	/*
	public function getLogoutUrl($params=array()) {
		
		return parent::getLogoutUrl($params);
		
	}
	*/
	
	
	public function getLoginUrl() {
		

		$params['req_perms'] = $this->config['req_perms'];
		$params['next'] = $this->urlNext;
		
		return parent::getLoginUrl($params);
		
	}
	
	
	
	
	/*
	public static function getInstance() {
		
		if (!self::$fb) {
			self::$fb = new fbconnect();
		}
		
		return self::$fb;
		
	}
	*/
	
}
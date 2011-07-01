<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * MY_Log
 * extends the log class with dispatching jobs to a job server for sending emails
 * on ERROR logs
 * 
 * @author liran
 */
class MY_Log extends CI_Log {

	protected $_ci;
	
	
	/**
	 * __construct
	 * class constructor
	 */
	public function __construct() {
		parent::__construct();
	}
	
	
	/**
	 * write_log
	 * overrides write_log function with detecting for conditions to send an email alert
	 * @see CI_Log::write_log()
	 */
    public function write_log($level = 'error', $msg, $php_error = FALSE)
	{

		parent::write_log($level, $msg, $php_error);
		
		if (ENVIRONMENT === 'production' && strtoupper($level) === 'ERROR') {

			$this->_ci =& get_instance();
			
	        $message = 
	            $level . ' - ' . $this->_ci->router->fetch_class() . ' - ' . $this->_ci->router->fetch_method() .
	            ' - ' . date($this->_date_fmt). ' --> ' . $msg . "\n";

			// create the jobserver client to dispatch jobs
			if (class_exists('GearmanClient')) {
				$gm_client = new GearmanClient();
				// initialize localhost server with default connection info
				$gm_client->addServer();
				// perform background job
				$gm_client->doBackground('email-alerts', serialize($message));
			}
		
		}
		
	}
	
}
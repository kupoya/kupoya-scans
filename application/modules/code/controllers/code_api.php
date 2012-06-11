<?php

/**
 * 
 * This class provides api to brand's codes.
 * Mostly used by injecting AJAX code on the client and callbacks are handled
 * in this class.
 * 
 * Class extends CI_Controller and not MY_Controller to be as efficient as possible
 * 
 * @author liran
 * @see layouts/partials/save_request_info
 */
class Code_api extends CI_Controller {
		
	
	/**
	 * 
	 * Generic constructor
	 */
	public function __construct() {		
		parent::__construct();
		
	}
	
	
	/**
	 * 
	 * AJAX callback handler
	 * Should handle first time requests to record them in the database with all request
	 * information such as IP, User Agent, Timestamp, etc and also increment exposure
	 * count for the strategy 
	 */
	public function save_request_info() {
		
		if ($this->input->is_ajax_request()) {
			$this->_save_request_info();
			$this->_inc_exposure_count();
		}

	}
	
	
	/**
	 * 
	 * Saving request information
	 * (used to be in mongodb, we moved now to mysql to consolidate tech for quicker maintenance and dev)
	 */
	protected function _save_request_info() {

		$strategy = $this->session->userdata('strategy');
			
		// still can't find strategy in session? go rest in null land
		if (!$strategy)
			return false;
			
		$strategy_id = $strategy['id']; 
		
		$this->load->library('user_agent');
		// $this->load->library('mongo_db');
		
		$req_info = array();
		
		$time = new DateTime();
		
		$req_info['strategy_id'] = $strategy_id;
		$req_info['ip_address'] = $this->session->userdata('ip_address');
		$req_info['time'] = $time->format('Y-m-d H:i:s');
		//$req_info['robot'] = $this->agent->robot();
		$req_info['mobile'] = $this->agent->mobile();
		$req_info['platform'] = $this->agent->platform();
		$req_info['browser'] = $this->agent->browser();
		$req_info['version'] = $this->agent->version();
		$req_info['agent_string'] = $this->agent->agent_string();
				

		$this->db->insert('stat_strategy_requests', $req_info);	
		
	}
	
	
	/**
	 * 
	 * Increment exposure count field for strategy
	 * @param integer $strategy_id the strategy_id, if not present session is used to guess strategy_id
	 */
	protected function _inc_exposure_count($strategy_id = false) {
	
		$this->load->model('strategy_model');
		
		if (!$strategy_id) {
			$strategy = $this->session->userdata('strategy');
			
			// still can't find strategy in session? go rest in null land
			if (!$strategy)
				return false;
			
			$strategy_id = $strategy['id']; 
		}
		
		$this->strategy_model->increment_exposure_count($strategy_id);
	}
	
	
	
	
}
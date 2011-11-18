<?php

Class Advertisement extends MY_Controller {
	

	public function __construct() {

		parent::__construct();

		// check brand and product is in session if segments aren't populated
		$brand = $this->session->userdata('brand');
		$code_id = $this->session->userdata('code_id');
		$strategy = $this->session->userdata('strategy');

		// if brand and products are provided (probably redirected by our system)
		// then save this info in the user's session
		if ( !$brand['id'] || !$code_id || !$strategy['id'] ) {
			// @TODO should we just redirect to the welcome page?
			log_message('debug', ' === no brand_id || code_id || strategy_id so redirecting to: auth/invalid');
			redirect('auth/invalid');
		}
		
		
		$this->load->model('advertisement_model');
		
		$language = $this->getLanguage();
		$this->lang->load('app', $language);
		
		$this->load->library('cache');
		
	}
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('advertisement/advertisement_invalid', $data);
		
	}
	
	
	
	
	public function index() {
		
		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');
		
		// check advertisement is still valid to display
		$ret = $this->advertisement_model->check_valid($data['strategy']);
		if ($ret === false) {
			
			$flash_value = $this->lang->line('campaign_ended');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('advertisement/invalid');
		}
		

		// get advertisement info
		$advertisement_info = $this->cache->model('advertisement_model', 'get_by_strategy', 
												array($data['strategy']['id']), $this->MODEL_CACHE_SECS);
		if (!$advertisement_info) {
			// no advertisement record in the database?
			redirect('code/invalid');
		}
		
		
		$this->_firstLogin();
				
		// check if we should forward to a url		
		if ( isset($advertisement_info['redirect_url']) && !empty($advertisement_info['redirect_url'])) {
			redirect($advertisement_info['redirect_url']);
		}
		
		// get blocks for this view
		$blocks = $this->cache->model('template_model', 'get_blocks_by_strategy', 
												array($data['strategy']['id'], 'coupon'), $this->MODEL_CACHE_SECS);
		
		$data['blocks'] = $blocks;
		
		$data['advertisement'] = $advertisement_info;
		$this->template->build('advertisement/advertisement', $data);
		
	}

}
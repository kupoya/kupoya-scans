<?php

Class Registration extends MY_Controller {
	
	const MODEL_CACHE_SECS = 3600;
	
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
		
		
		$this->load->model('registration_model');
		
		$language = $this->getLanguage();
		$this->lang->load('registration/registration', $language);
		$this->lang->load('app', $language);
		
		$this->load->library('cache');
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->load->helper('user_experience');

	}
	
	
	
	
	public function index() {
		
		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');

		// check strategy is still valid to display
		$ret = $this->registration_model->check_valid($data['strategy']);
		if ($ret === false) {
			
			$flash_value = $this->lang->line('campaign_ended');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('auth/invalid');
		}
		

		// get strategy info
		$registration_info = $this->cache->model('registration_model', 'get_by_strategy', 
												array($data['strategy']['id']), self::MODEL_CACHE_SECS);
		if (!$registration_info) {
			// no record in the database?
			redirect('code/invalid');
		}


		$this->_firstLogin();
		
		$data['registration'] = $registration_info;
		$this->template->build('registration/registration', $data);
		
	}
	
	
	public function confirm() {
		
		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');
		
		$registration_info = $this->cache->model('registration_model', 'get_by_strategy', 
												array($data['strategy']['id']), self::MODEL_CACHE_SECS);
		if (!$registration_info) {
			// no record in the database?
			redirect('code/invalid');
		}

		$data['registration_info'] = $registration_info;
		
		$this->form_validation->set_rules('name', 'name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('contact', 'attending', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('message', 'message', 'trim|max_length[65530]');
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		
		$data['name'] = $this->input->post('name');
		$data['contact'] = $this->input->post('contact');
		$data['message'] = $this->input->post('message');
		$data['time'] = date('Y-m-d H:i:s');
		
		if ($this->input->post('submit')) {
		
			if ($this->form_validation->run() == FALSE) {
				
				// validation error, bring-up the form
				$this->template->build('registration/registration', $data);
				
			} else {
			
				// validation successful
				// perform strategy actions
				
				$ret = $this->registration_model->insert($data['strategy']['id'], $data);
				// notify the strategy owner of new entry
				
				if ($ret) {
					// create the jobserver client to dispatch jobs
					if (class_exists('GearmanClient')) {
						$gm_client = new GearmanClient();
						// initialize localhost server with default connection info
						$gm_client->addServer();
						// perform background job
						$gm_client->doBackground('registration_email_notification', serialize($data));
					}
				}
				
				
				$this->template->build('registration/registration_confirm', $data);
			}
			
		} else {
			
			// no post was provided, redirect to index
			redirect('registration/index');
		}
		
		
		
	}
	

}
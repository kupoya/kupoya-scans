<?php

Class Wedding extends MY_Controller {
	
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
		
		
		$this->load->model('wedding_model');
		
		$language = $this->getLanguage();
		$this->lang->load('wedding/wedding', $language);
		$this->lang->load('app', $language);
		
		$this->load->library('cache');
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->load->helper('user_experience');

	}
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('wedding/wedding_invalid', $data);
		
	}
	
	
	
	
	public function index() {
		
		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');

		// check wedding is still valid to display
		$ret = $this->wedding_model->check_valid($data['strategy']);
		if ($ret === false) {
			
			$flash_value = $this->lang->line('campaign_ended');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('wedding/invalid');
		}
		

		// get wedding info
		$wedding_info = $this->cache->model('wedding_model', 'get_by_strategy', 
												array($data['strategy']['id']), self::MODEL_CACHE_SECS);
		if (!$wedding_info) {
			// no advertisement record in the database?
			redirect('code/invalid');
		}

		$this->_firstLogin();

		$data['wedding'] = $wedding_info;
		$this->template->build('wedding/wedding', $data);
		
	}
	
	
	public function confirm() {
		
		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');
		
		$wedding_info = $this->cache->model('wedding_model', 'get_by_strategy', 
												array($data['strategy']['id']), self::MODEL_CACHE_SECS);
		if (!$wedding_info) {
			// no advertisement record in the database?
			redirect('code/invalid');
		}

		$data['wedding_info'] = $wedding_info;
		
		$this->form_validation->set_rules('name', 'name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('attending', 'attending', 'trim|required|max_length[1]|numeric');
		$this->form_validation->set_rules('attendees', 'attendees', 'trim|max_length[3]|numeric');
		$this->form_validation->set_rules('message', 'message', 'trim|max_length[1024]');
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		
		$data['name'] = $this->input->post('name');
		$data['attending'] = $this->input->post('attending');
		$data['attendees'] = $this->input->post('attendees');
		// if attendees were not provided we set it to 0
		if (!$data['attendees'])
			$data['attendees'] = '0';
		$data['message'] = $this->input->post('message');
		
		$data['time'] = date('Y-m-d H:i:s');
		
		if ($this->input->post('submit')) {
		
			if ($this->form_validation->run() == FALSE) {
				
				// validation error, bring-up the form
				$this->template->build('wedding/wedding', $data);
				
			} else {
			
				// validation successful
				// perform strategy actions
				
				$ret = $this->wedding_model->add_guest($data['strategy']['id'], $data);
				// notify the strategy owner of this new guest addition
				if ($ret) {
					// create the jobserver client to dispatch jobs
					if (class_exists('GearmanClient')) {
						$gm_client = new GearmanClient();
						// initialize localhost server with default connection info
						$gm_client->addServer();
						// perform background job
						$gm_client->doBackground('wedding_email_notification', serialize($data));
					}
				}
				
				
				$this->template->build('wedding/wedding_confirm', $data);
			}
			
		} else {
			
			// no post was provided, redirect to wedding form
			//$this->template->build('wedding/wedding', $data);
			redirect('wedding/index');
		}
		
		
		
	}
	

}
<?php

class Coupon extends MY_Controller {


	public function __construct()
	{
		
		//parent::MY_Controller();
		parent::__construct();
	
		// check brand and product is in session if segments aren't populated
		$brand = $this->session->userdata('brand');
		$code_id = $this->session->userdata('code_id');
		$strategy = $this->session->userdata('strategy');

log_message('debug', ' === BRNAD ID: '.$brand['id']);
log_message('debug', ' === CODE ID: '.$code_id);
log_message('debug', ' === STRATEGY ID: '.$strategy['id']);

		// if brand and products are provided (probably redirected by our system)
		// then save this info in the user's session
		if ( !$brand['id'] || !$code_id || !$strategy['id'] ) {
			// @TODO should we just redirect to the welcome page?
			log_message('debug', ' === no brand_id || code_id || strategy_id so redirecting to: auth/invalid');
			redirect('auth/invalid');
		}

		// require logged-in user
		$this->_requireLogin();
		
		$this->load->model('coupon_model');
		$this->load->model('strategy_model');
		$this->load->library('cache');
		
		$this->load->helper('user_experience');
		
		$language = $this->getLanguage();
		$this->lang->load('coupon/coupon', $language);
		$this->lang->load('app', $language);

	}
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('coupon/coupon_invalid', $data);
		
	}
	
	
	
	public function index() {

		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');
		//$data['fbUser'] = $this->fbconnect->user;
		
		// get blocks for this view
		$blocks = $this->cache->model('template_model', 'get_blocks_by_strategy', 
												array($data['strategy']['id'], 'coupon'), $this->MODEL_CACHE_SECS);
		
		$data['blocks'] = $blocks;
		$this->template->build('coupon/coupon', $data);
		
	}
	
	
	 
	public function confirm() {

		$ret = false;

		$brand_id = $this->input->post('brand_id');
		if (!isset($brand_id) || !$brand_id || !is_numeric($brand_id)) {
			redirect('coupon/view');
		}

		$brand = $this->session->userdata('brand');

		// error getting business id? kinda odd, redirect back to coupon view page
		if (!isset($brand['id']) || !$brand['id']) {
			redirect('coupon/view');
		}

		// we consider only the last 4 characters to be the brand id
		if (substr($brand['id'], 0, 4) === substr($brand_id, 0, 4))
		{
			// if they are equal then the business has typed in his business id and confirmed
			// this coupon so let's update in the database

			$coupon = $this->session->userdata('coupon');
			if (isset($coupon['id'])) {

				// load coupon validation model
				$this->load->model('couponvalidate_model');
			
				// validated the coupon
				$result = $this->couponvalidate_model->validate_coupon($coupon['id']);

				// update session data
				$coupon['status'] == 'validated';
				$this->session->set_userdata('coupon', $coupon);

				$ret = true;
			}
		}

		if ($ret === true) {
			redirect('coupon/validated');
		} else {
			redirect('coupon/view');
		}
	}
	

	public function validated() {

		$coupon = $this->session->userdata('coupon');

		if ($coupon && isset($coupon['status']) && $coupon['status'] == 'validated') {

			$brand = $this->session->userdata('brand');
			$strategy = $this->session->userdata('strategy');
			$user = $this->session->userdata('user');
			$coupon = $this->session->userdata('coupon');

			$data = array();

			$data['brand'] = $brand;
			$data['strategy'] = $strategy;
			$data['coupon'] = $coupon;

			return $this->template->build('coupon/coupon_validated', $data);

		} else {
			redirect('coupon/view');
		}
	}

	public function view() {
		
		$brand = $this->session->userdata('brand');
		$strategy = $this->session->userdata('strategy');
		$user = $this->session->userdata('user');
		$coupon = $this->session->userdata('coupon');
		$medium = $this->session->userdata('medium');		
		
		// validate the user is able to use the coupon
		$this->load->model('couponvalidate_model');

		if (isset($strategy['id']))
			$coupon_settings = $this->coupon_model->get_coupon_settings($strategy['id']);
		else {
			$coupon_settings = array();
		}
		
		// check if the user already used up a coupon, if so, deliver it to him
		$coupon = $this->couponvalidate_model->check_coupon_used_by_user($strategy['id'], $user['id']);
		if ($coupon) {

			// create some coupon code
			$data = array();
			
			$data['brand'] = $brand;
			$data['strategy'] = $strategy;
			$data['coupon'] = $coupon;
			$data['coupon_settings'] = $coupon_settings;
			
			// set the coupon's info in the session
			$this->session->set_userdata('coupon', $data['coupon']);

			// check if business has validated this coupon and redirect to validated()
			if (isset($coupon['status']) && $coupon['status'] == 'validated')
				redirect('coupon/validated');
			
			// get blocks for this view
			$blocks = $this->cache->model('template_model', 'get_blocks_by_strategy', 
												array($strategy['id'], 'coupon_view'), $this->MODEL_CACHE_SECS);
		
			$data['blocks'] = $blocks;
			
			return $this->template->build('coupon/coupon_view', $data);
			
		}
		
		
		
		$ret = $this->couponvalidate_model->validate_user($strategy['id'], $user['id']);
		// if it returns false then the user used a coupon in the last 24 hours
		if ($ret === false) {
			log_message('error', 'kupoya = user did not pass coupon validation');

			// set session error message for next view to display it to the user
			$flash_value = $this->lang->line('error_check_validation');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('coupon/invalid');
		}
		
		
		
		
		$coupon = $this->coupon_model->get_coupon_by_strategy_procedure($strategy, $user);
		// no coupons left
		if ($coupon === false) {			
			// set session error message for next view to display it to the user
			$flash_value = $this->lang->line('error_no_coupons');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('coupon/invalid');
		}
		
		// perform medium actions
		$this->load->model('medium_handler');
log_message('debug', ' === calling medium_handler->perform_action');
		$ret = $this->medium_handler->perform_action($medium);
log_message('debug', ' === which returned: '.$ret);
		if (!$ret) {
			log_message('error', ' kupoya = could not complete medium_handler->perform_action');
			// unable to post to facebook, remove coupon
			$this->coupon_model->del_coupon($coupon['id']);
			
			$login_url = $this->session->userdata('login_url');
			redirect($login_url);
		}
		

		
		// add flag that coupon has been used
		$coupon['used'] = true;
		
		// create some coupon code
		$data = array();
		
		$data['brand'] = $brand;
		$data['strategy'] = $strategy;
		
		$data['ret'] = $ret;
		$data['coupon'] = $coupon;
		$data['coupon_settings'] = $coupon_settings;
	
		$data['user'] = $user;
		
		// create the jobserver client to dispatch jobs
		if (class_exists('GearmanClient')) {
			$gm_client = new GearmanClient();
			// initialize localhost server with default connection info
			$gm_client->addServer();
			// perform background job
			$gm_client->doBackground('coupon_email_notification', serialize($data));
		}

		// get blocks for this view
		$blocks = $this->cache->model('template_model', 'get_blocks_by_strategy', 
												array($strategy['id'], 'coupon_view'), $this->MODEL_CACHE_SECS);
		
		$data['blocks'] = $blocks;
		
		// set the coupon's info in the session
		$this->session->set_userdata('coupon', $data['coupon']);
		
		//$this->load->view('coupon_create', $data);
		$this->template->build('coupon/coupon_view', $data);
		
	}	
	
}

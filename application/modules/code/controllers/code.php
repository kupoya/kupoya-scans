<?php 

class Code extends MY_Controller {
	
	
	public function __construct() {
		
		parent::__construct();

		$this->load->model('brand_model');
		$this->load->model('code/code_model');
		$this->load->model('strategy_model');
		$this->load->model('medium_model');	
		
		//$this->load->model('user_model');
		$this->load->library('security');
		$this->load->helper('security');
		$this->load->helper('url');
		
		$this->load->library('FBConnect', array('initSession' => false));
		
		$this->load->library('user_agent');
		
		$this->lang->load(array('code/code', 'app'), 'english');
		
		$this->load->helper('array');
		
	}
	
	
	
	
	
	protected function _validate() {
log_message('debug', ' === checking if user is mobile: '.$this->agent->is_mobile());
		if (!$this->agent->is_mobile()) {
log_message('debug', ' === user is not mobile device');
			redirect('code/invalid');
		}
	
		return true;
			
	}
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('code/code_invalid', $data);
		
	}
	
	
	
	public function index($brand_id = 0, $code_id = 0)
	{
		
		// validate user access to our system
		// @TODO add this validation to disallow PC users
		//$this->_validate();
		
		if (!$brand_id === 0 || $code_id === 0)
			redirect('code/invalid');
		
		$brand_id = xss_clean($brand_id);
		$code_id = xss_clean($code_id);
		
log_message('debug', ' === brand_id: '.$brand_id);
log_message('debug', ' === code_id: '.$code_id);
// check for given brandId and productId
/*
if (!$brandId || !$productId) {
	log_message('debug', ' === invalid 1');
	redirect('auth/invalid');
}
*/

		// initialize template data variable
		$data = array();
		
		// get campaign
		$campaign_id = $this->code_model->get_campaign_by_brand_code($brand_id, $code_id);
		if (!$campaign_id) {
			log_message('debug', ' === invalid campaign_id: '.$campaign_id);
			redirect('code/invalid');
		}


		$this->session->set_userdata('code_id', $code_id);
		$this->session->set_userdata('campaign_id', $campaign_id);
		
		
		// if we got the brand and code ok, let's pull up brand information
		$brand_info = $this->brand_model->get_brand_info($brand_id);
		// push brand info into session for other pages
		if ($brand_info) { 
			$this->session->set_userdata('brand', $brand_info);
		}
				
		// get strategy
		$strategy_info = $this->strategy_model->get_strategy_by_campaign($campaign_id);
		if ($strategy_info === false) {
			log_message('debug', ' === invalid strategy_info: '.$strategy_info);
			redirect('code/invalid');
		}
		
		$this->session->set_userdata('strategy', $strategy_info);
log_message('debug', ' === strategy_info: '.$strategy_info['id']);
		
		// increment strategy exposure count
		$this->strategy_model->increment_exposure_count($strategy_info['id']);


		// get the medium/action sets for this strategy
		// for that we need to get the plan first which the strategy is associated with
		$plan_id = $strategy_info['plan_id'];
		if (!$plan_id) {
			log_message('debug', ' === no plan id defined: '.$strategy_info['type']);
			redirect('code/code_invalid');
		}
		
		$medium_info = $this->medium_model->get_mediums_by_plan_id($plan_id);
		if (!$medium_info) {
			log_message('debug', ' === medium error: '.$strategy_info['type']);
			redirect('code/code_invalid');
		}
		
		// set medium in session
		$this->session->set_userdata('medium', $medium_info);
		
		// if no medium is set we redirect directly to the strategy view page
		if (isset($medium_info['none'])) {			
			$strategy_type = $strategy_info['type'];
			if (!$strategy_type) {
				log_message('debug', ' === no strategy type defined: '.$strategy_info['type']);
				redirect('code/code_invalid');
			}
			
			redirect($strategy_type.'/index');
		}
		
		


		// create nextUrl string for facebook redirect after successful authentication.
		// this is done based on session data where these values were saved when the user
		// attempted accessing the app without authenticating first

		//$nextUrl = site_url("coupon/index/$brandId/$productId");
		//$nextUrl = site_url("auth/login/$brand_info/$code_id");
		$nextUrl = site_url("auth/connect_facebook/login");
//log_message('debug', ' === 3');
		$this->fbconnect->urlNext = $nextUrl; 
		$fbLoginUrl = $this->fbconnect->getLoginUrl();
		
//log_message('debug', ' === 4');
		$data['facebook'] = array(
			'app_id'		=> $this->fbconnect->getAppId(),
			'perms'			=> $this->fbconnect->config['req_perms'],
			'display'		=> 'touch',
			'nextUrl'		=> $nextUrl,
			//'session'		=> $this->fbconnect->getSession(),
			//'user'			=> $this->fbconnect->user,
			'loginUrl'		=> $fbLoginUrl,
		);
				
		// add the brand information to the view variables 
		$data['brand'] = $brand_info;
		$data['strategy'] = $strategy_info;
		$data['medium'] = $medium_info;
		
		log_message('debug', ' === 6');
		$this->template->build('code/login', $data);
		
	}
	
}
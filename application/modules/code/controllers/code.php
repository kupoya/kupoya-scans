<?php 

class Code extends MY_Controller {
	
	const MODEL_CACHE_SECS = 3600;
	
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
		
		$this->load->library('cache');
		
		$this->lang->load(array('code/code', 'app'), 'english');
		
		$this->load->helper('array');
		
	}
	
	
	
	
	
	protected function _validate() {
		
		// check if the useragent for is detected as a mobile device
		if (!$this->agent->is_mobile()) {
			// if it's not a mobile device we redirect to the code invalid page
			redirect('code/invalid');
		}
	
		return true;

	}
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->set_cache(3600);
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
		$campaign_id = $this->cache->model('code_model', 'get_campaign_by_brand_code', 
												array($brand_id, $code_id), self::MODEL_CACHE_SECS);
		if (!$campaign_id) {
			log_message('debug', ' === invalid campaign_id: '.$campaign_id);
			redirect('code/invalid');
		}
		
		
		// if we got the campaign and code ok, let's pull up brand information
		$brand_info = $this->cache->model('brand_model', 'get_brand_info', 
												array($brand_id), self::MODEL_CACHE_SECS);
		// either brand doesnt exist or is blocked
		if (!$brand_info) { 
			log_message('debug', ' === invalid brand_id: '.$brand_id);
			redirect('code/invalid');
		}
				
		// get strategy
		$strategy_info = $this->cache->model('strategy_model', 'get_strategy_by_campaign', 
												array($campaign_id), self::MODEL_CACHE_SECS);
		if ($strategy_info === false) {
			log_message('debug', ' === invalid strategy_info: '.$strategy_info);
			redirect('code/invalid');
		}
		log_message('debug', ' === strategy_info: '.$strategy_info['id']);
		
		
		// increment strategy exposure count
		// @TODO this query slows down from 75rp/s and 13tpr to 17rp/s and 57tpr (on own localhost machine)
		// possibly implement via ajax?
		$this->strategy_model->increment_exposure_count($strategy_info['id']);

		
		// get the medium/action sets for this strategy
		// for that we need to get the plan first which the strategy is associated with
		$plan_id = $strategy_info['plan_id'];
		if (!$plan_id) {
			log_message('debug', ' === no plan id defined: '.$strategy_info['type']);
			redirect('code/code_invalid');
		}

		
		$medium_info = $this->cache->model('medium_model', 'get_mediums_by_plan_id',
												array($plan_id), self::MODEL_CACHE_SECS);
		if (!$medium_info) {
			log_message('debug', ' === medium error: '.$strategy_info['type']);
			redirect('code/code_invalid');
		}

		
		// save all data we got so far to the session
		$this->session->set_userdata(array(
				'code_id' => $code_id,
				'campaign_id' => $campaign_id,
				'brand' => $brand_info,
				'strategy' => $strategy_info,
				'medium' => $medium_info,
			)
		);


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
		$nextUrl = site_url("auth/connect_facebook/login");
		$this->fbconnect->urlNext = $nextUrl; 
		
		// get the login url with all of facebook url info
		$fbLoginUrl = $this->fbconnect->getLoginUrl();
		
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
		$data['code'] = $code_id;
		$data['strategy'] = $strategy_info;
		$data['medium'] = $medium_info;
				
		$this->template->build('code/login', $data);
		
		
	}
	
}
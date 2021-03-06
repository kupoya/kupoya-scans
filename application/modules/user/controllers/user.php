<?php 

class User extends MY_Controller {
	
	
	public function __construct() {
		
		parent::__construct();

		$this->load->model('brand_model');
		$this->load->model('code/code_model');
		$this->load->model('strategy_model');
		$this->load->model('medium_model');	
		
		//$this->load->model('user/user_model');
		$this->load->helper('security');
		$this->load->helper('url');
		
		$this->load->library('FBConnect', array('initSession' => false));
		
		$this->load->library('user_agent');
		
		$this->load->library('cache');
			
		$this->load->helper('array');
		$this->load->helper('user_experience');
		$this->load->helper('date');

		//$language = $this->getLanguage();
		/*
		@TODO hard-coding the language to french, lets test with user detection
			$language = 'fr';
			$this->userexp->language_set($language);
		*/

		$language = $this->userexp->language_detect();
		if ($language)
			$this->performLanguageOperations($language);

		$this->lang->load('coupon/coupon', $language);
		$this->lang->load('user/user', $language);
		$this->lang->load('app', $language);

	}
	
	
	

	
	public function index($type = 'active')
	{
		$destination = $this->input->get('destination');
		if (isset($destination) && !empty($destination)) {
			if ($this->_isLoggedIn() === TRUE) {
				redirect($destination);
			}
		}

		$data = array();

		// get user from session
		$user = $this->session->userdata('user');
		if (!isset($user['id']) || !$user['id'] || $this->_requireLogin() !== true) {
			if (isset($destination) && !empty($destination)) {
				redirect('auth/login?destination='.$destination);
			}
			redirect('auth/login');
		}
		
		$this->load->model('coupon/coupon_model');

		if ($type == 'active')
			$status = 'used';
		else 
			$status = 'validated';

		// get coupons according to status
		$my_coupons = $this->coupon_model->get_coupons_by_user($user['id'], $status);

		// set header navigation, active menu, etc
		$my_coupons_nav['type'] = $type;
		$str = $this->load->view('my_coupons_nav', $my_coupons_nav, true);

		$data['user'] = $user;
		$data['my_coupons'] = $my_coupons;

		$this->template->set('page_title', $this->lang->line('My_Deals'));
		$this->template->set('header_content', $str);

		$this->template->build('user/my_coupons', $data);
				
	}
	
}
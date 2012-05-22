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

		$language = $this->getLanguage();
		$this->lang->load('coupon/coupon', $language);
		$this->lang->load('app', $language);
		
	}
	
	
	

	
	public function index()
	{
		$data = array();

		// get user from session
		$user = $this->session->userdata('user');
		if (!isset($user['id']) || !$user['id'] || $this->_requireLogin() !== true)
			redirect('auth/login');
		
		$this->load->model('coupon/coupon_model');
		$my_coupons = $this->coupon_model->get_coupons_by_user($user['id']);

		$data['user'] = $user;
		$data['my_coupons'] = $my_coupons;
		
		$this->template->build('user/my_coupons', $data);
				
	}
	
}
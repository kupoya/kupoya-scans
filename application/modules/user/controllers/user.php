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
		$this->lang->load('user/user', $language);
		$this->lang->load('app', $language);

	}
	
	
	

	
	public function index($type = 'active')
	{
		$data = array();

		// get user from session
		$user = $this->session->userdata('user');
		if (!isset($user['id']) || !$user['id'] || $this->_requireLogin() !== true)
			redirect('auth/login');
		
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

		$this->template->set('page_title', 'My Coupons');
		$this->template->set('header_content', $str);

		$this->template->build('user/my_coupons', $data);
				
	}
	
}
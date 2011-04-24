<?php

class Coupon extends MY_Controller {


	public function __construct() {
		
		//parent::MY_Controller();
		parent::__construct();
		
		log_message('debug', ' === MY_Controller completed ok, continuing to Coupon processing');
		
		// load security helper to sanitize data
		$this->load->library('security');
		$this->load->helper('security');
		
		// check uri segments for brand and product id
		$brandId = $this->uri->segment(3);
		$productId = $this->uri->segment(4);
		
		//var_dump($this->uri);
		
		//log_message('debug', ' === BRNAD ID: '.$brandId);
		//log_message('debug', ' === PRODUCT ID: '.$productId);
		
		// check brand and product is in session if segments aren't populated
		if (!$brandId)
			$brandId = $this->session->userdata('brandId');
		
		if (!$productId)
			$productId = $this->session->userdata('productId');

		
		//log_message('debug', ' === BRNAD ID: '.$brandId);
		//log_message('debug', ' === PRODUCT ID: '.$productId);
		
		// if brand and products are provided (probably redirected by our system)
		// then save this info in the user's session
		if ( ($brandId !== false) && ($productId !== false) ) {

			// sanitize data
			$brandId = xss_clean($brandId);
			$productId = xss_clean($productId); 
			
			log_message('debug', ' === brandId: '.$brandId);
			log_message('debug', ' === productId: '.$productId);
			
			log_message('debug', ' === add brandId and productId to user session: ');
			$this->session->set_userdata(array('brandId' => $brandId, 'productId' => $productId));
			log_message('debug', ' === add: finished');
			// forward to login page if required
						
		} else {
			// @TODO should we just redirect to the welcome page?
			log_message('debug', ' === redirecting to: auth/invalid');
			redirect('auth/invalid');
		}
		
		
		log_message('debug', ' === requiring login');
		$this->_requireLogin();

		$this->load->library('FBConnect');
		
	}
	
	/*
	public function invalid() {
		
		$data = array();
		//$this->load->view('coupon_invalid', $data);
		$this->template->build('coupon/coupon_invalid', $data);
		
	}
	*/
	
	/*
	public function index()
	{
		
		$data = array();
		$this->load->library('FBConnect');
		
		$data['facebook'] = array(
			'app_id'		=> $this->fbconnect->getAppId(),
			'perms'			=> $this->fbconnect->config['req_perms'],
			//'session'		=> $this->fbconnect->getSession(),
			//'user'			=> $this->fbconnect->user,
		);
		
		// forward the user to the coupon creation page
		$couponURL = 'welcome/coupon/1/1';
		
		//$couponInfo = array(
		//			'brandId' => 1,
		//			'productId' => 1,
		//			);
		//$this->session->set_userdata($couponInfo);
		

   		//var_dump($data);
		$this->load->view('welcome_message', $data);
		
	}
	*/
	
	

	
	public function index($brandId = null, $productId = null)
	{
		
		//$this->Login();

		$meta = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>';
		$this->template->prepend_metadata($meta);
		
		
		// if nothing was specified return to welcome page 
		if ($brandId == null || $productId == null)
			redirect('auth/index');
		
		// check permissions via fql api:
		/*
		 * SELECT publish_stream FROM permissions WHERE uid = 1234
		 */
		$fql_query = array(
			'method'	=> 'fql.query',
			'query'		=> 'SELECT publish_stream FROM permissions WHERE uid = '.$this->fbconnect->user_id
		);
		$fqlInfo = $this->fbconnect->api($fql_query);
		
   		$data = array(
   					'fql'			=> $fqlInfo,
					//'facebook'		=> $this->fbconnect->fb,
					//'fbSession'		=> $this->fbconnect->fbSession,
					//'user'			=> $this->fbconnect->user,
					//'uid'			=> $this->fbconnect->user_id,
					//'fbLogoutURL'	=> $this->fbconnect->fbLogoutURL,
					//'fbLoginURL'	=> $this->fbconnect->fbLoginURL,	
					//'base_url'		=> site_url('login/facebook'),
					
					//'base_url'		=> site_url($couponURL),
   		
					//'appkey'		=> $this->fbconnect->appkey,
					);			
		
		$data['fbUser'] = $this->fbconnect->user;
		
		//$this->load->view('coupon', $data);
		$this->template->build('coupon/coupon', $data);
		
	}
	
	
	
	public function coupon_create() {
		
		//$this->Login();
		
		if (!$this->fbconnect->user_id)
			return false;
		
		// post to facebook
		$post = array( 'message' => 'I love aroma!!!', 
					'link' => 'http://scanalo-kicks-ass.com',
					'name' =>  'I checked it via Scanalo!',
					'description' => 'I just got a free Coffee from Aroma for checking in with facebook',
					//'picture'=> $iconUrl,
		);
		try {
			$ret = $this->fbconnect->api('me/feed', 'POST', $post);
		} catch (FacebookApiException $e) {
			error_log($e);
			echo('error happened - you need to allow Scanalo APP permission to post to your wall');
			return false;
			// if not permissions forward to apply permissions we need:
			//$url = "http://www.facebook.com/connect/prompt_permissions.php?api_key=***REMOVED***&v=1.0&ext_perm=publish_stream&next=http://datacenter.enginx.com/scanalo/welcome/coupon/1/1";
		}
		
		// create some coupon code
		$data = array();
		$data['ret'] = $ret;
		$data['couponCode'] = time().'-'.rand(1,1000);
	
		$this->load->view('coupon_create', $data);
		//$this->template->build('base/coupon_create', $data);

		// destroy the session
		//$this->session->sess_destroy();
		
		
	}
	
	/*
	
	public function __construct()
	{

		parent::__construct();
		
//		var_dump(__DIRECTORY__);
		//$moduleClass = basename(__FILE__, ".php");
		
		//parent::__construct($moduleClass);

		//var_dump($this->data->view['sections']['Management']);

		// load the users_m model
		//$this->load->model('users/users_model');
		
		// load the menu library
		//$this->load->library('menu/menu');
		
		$this->template->enable_parser(FALSE); // default true
		$this->template->set_layout('default/layout_base');
		$this->template->set_partial('header', 'base/partials/header', TRUE);
		
		//$metadata = "<script type='text/javascript' src='../test.js/'></script>";
		//$this->template->append_metadata = $metadata;
		
		//$metadata = $this->load->view('base/partials/metadata', NULL, true);
		//var_dump($metadata);
		//exit;
		
		//$this->template->append_metadata($metadata);
		//$this->template->set_partial('metadata', 'base/partials/metadata', TRUE);
		
		
		// **************************************************************************************** //
		// load all forms which will be used in this view
		// **************************************************************************************** //
		$this->load->model('users/users_form_model');
		$userAddForm = $this->users_form_model->getFormFields('userAdd');
		$userEditForm = $this->users_form_model->getFormFields('userEdit');
				
		Formation::add_form('create_user', array('action' => base_url().'users/create',
		 											'method' => 'post',
													'class' => '',
											)
							);
		
		
		Formation::add_form('edit_user', array('action' => base_url().'users/edit',
		 											'method' => 'post',
													'class' => '',
											)
							);
		Formation::add_fields('edit_user', $userEditForm);	
		// **************************************************************************************** //
		
		
		
		
		
	}
	
	function index()
	{
		
		$data = array();
		
		$this->load->model('menu/menu_model');
		$menu = $this->menu_model->getMenu();
		$data['menu'] = $menu;
		//var_dump($menu);
						
		//Events::register('event_test1', array('Base', 'method_test'), 1);

		$data['title'] = "My Real Title";
						
	    //$this->template->append_metadata( js('test.js', 'users') );
	    //$this->template->append_metadata( css('widgets.css', 'widgets') );
		
		//$this->template->append_metadata(js('test.js', 'users'));
		$this->template->build('base/body_3', $data);
		
		
	}
	*/
	

	
	
}

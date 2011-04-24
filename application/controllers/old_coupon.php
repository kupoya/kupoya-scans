<?php 

class Coupon extends MY_Controller {
	
	
	
	public function __construct() {
		
		parent::MY_Controller();
		
		// load security helper to sanitize data
		$this->load->helper('security');
		
		// check uri segments for brand and product id
		$brandId = $this->uri->segment(3);
		$productId = $this->uri->segment(4);
		
		// if brand and products are provided (probably redirected by our system)
		// then save this info in the user's session
		if ( ($brandId !== false) && ($productId !== false) ) {

			// sanitize data
			$brandId = xss_clean($brandId);
			$productId = xss_clean($productId); 
			
			error_log('brandId: '.$brandId);
			error_log('productId: '.$productId);
			
			error_log('add brandId and productId to user session: ');
			$this->session->set_userdata(array('brandId' => $brandId, 'productId' => $productId));
			error_log('add: finished');
			// forward to login page if required
		}
		

	}
	
	
	public function invalid() {
		
		$data = array();
		$this->load->view('coupon_invalid', $data);
		
	}
	
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
		
		$this->Login();
		
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
		
		$this->load->view('coupon', $data);
		
	}
	
	
	
	public function coupon_create() {
		
		$this->Login();
		
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

		// destroy the session
		//$this->session->sess_destroy();
		
		
	}
	
}
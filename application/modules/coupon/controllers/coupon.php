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
		
		$this->lang->load(array('coupon/coupon', 'app'), 'english');

	}
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('coupon/coupon_invalid', $data);
		
	}
	
	
	
	public function index()
	{
		
		//$meta = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>';
		//$this->template->prepend_metadata($meta);
			
		// get product information
		//$productInfo = $this->product_model->getProductInfo($brandId, $productId);
		// push brand info into session for other pages 
		//$this->session->set_userdata['product'] = $productInfo;
			
		// check permissions via fql api:
		/*
		 * SELECT publish_stream FROM permissions WHERE uid = 1234
		 */
		
		
		/*
		$fql_query = array(
			'method'	=> 'fql.query',
			'query'		=> 'SELECT publish_stream FROM permissions WHERE uid = '.$this->fbconnect->user_id
		);
		$fqlInfo = $this->fbconnect->api($fql_query);
log_message('debug', ' === fql info '.$fqlInfo);

		
   		$data = array(
   					'fql'			=> $fqlInfo,
   					//'friends'		=> $my_friends,
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
		*/
		
		// add the brand information to the view variables
		//$data['product'] = $productInfo;

		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');
		//$data['fbUser'] = $this->fbconnect->user;
		
		$this->template->build('coupon/coupon', $data);
		
	}
	
	
	 
	
	public function view() {
				
		//$this->load->library('Barcode/Image_Barcode_code128');
		//$this->load->library('Barcode');
		
		$brand = $this->session->userdata('brand');
		$strategy = $this->session->userdata('strategy');
		$user = $this->session->userdata('user');
		$coupon = $this->session->userdata('coupon');
		$medium = $this->session->userdata('medium');
		
		// validate the user is able to use the coupon
		$this->load->model('couponvalidate_model');
		
		// check if the user already used up a coupon, if so, deliver it to him
		$coupon = $this->couponvalidate_model->check_coupon_used_by_user($strategy['id'], $user['id']);
		if ($coupon) {

			log_message('debug', ' === user already used this coupon');
			
			// create some coupon code
			$data = array();
			
			$data['brand'] = $brand;
			$data['strategy'] = $strategy;
			$data['coupon'] = $coupon;
			
			// set the coupon's info in the session
			$this->session->set_userdata('coupon', $data['coupon']);
			
			return $this->template->build('coupon/coupon_view', $data);
			
		}
		
		$ret = $this->couponvalidate_model->validate_user($strategy['id'], $user['id']);
		// if it returns false then the user used a coupon in the last 24 hours
		if ($ret === false) {
log_message('debug', ' === user did not pass coupon validation');


			// set session error message for next view to display it to the user
			$flash_value = $this->lang->line('error_check_validation');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('coupon/invalid');
		}
		
		
		$coupon = $this->coupon_model->get_coupon_by_strategy($strategy['id']);
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
log_message('debug', ' === ret didnt return good...');
			// just in case, make sure tables are unlocked
			$this->db->query('UNLOCK TABLES');
			// unable to post to facebook, mark coupon as used
			$this->coupon_model->set_coupon_status($coupon['id'], 'new');
			
			$login_url = $this->session->userdata('login_url');
			redirect($login_url);	
			//redirect('code/index');
		}
		
/*		
		$this->load->model('brand_model');
		$brand_contact = $this->brand_model->get_brand_contact_info($brand['id']);
		
		$message = (!empty($strategy['description'])) ? $strategy['description'] : $brand['description'];
		$link = (!empty($strategy['website'])) ? $strategy['website'] : $brand['website'];
		$name = (!empty($strategy['name'])) ? $strategy['name'] : $brand['name'];
		$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
		
		$message = "Hi all, I've just visited ".$brand['name']." in ".$brand_contact['address']." and enjoyed ".$message;
		
		if (empty($link))
			$link = "http://www.kupoya.com";
			
		$description = ''; 
		
		$post = array( 'message' => $message, 
					'link' => $link,
					'name' =>  $name,
					'description' => $description,
					'picture'=> $picture,
		);
		
		try {
			$ret = $this->fbconnect->api('me/feed', 'POST', $post);
		} catch (FacebookApiException $e) {
log_message('debug', ' === error happened - you need to allow Scanalo APP permission to post to your wall');
			//return false;
			// if not permissions forward to apply permissions we need:
			//$url = "http://www.facebook.com/connect/prompt_permissions.php?api_key=***REMOVED***&v=1.0&ext_perm=publish_stream&next=http://datacenter.enginx.com/scanalo/welcome/coupon/1/1";

			// just in case, make sure tables are unlocked
			$this->db->query('UNLOCK TABLES');
			// unable to post to facebook, mark coupon as used
			$this->coupon_model->set_coupon_status($coupon['id'], 'new');
			redirect('auth/index');
		}
		*/

		// prepare data to be inserted to db 
		$coupon_data['status'] = 'used';
		$coupon_data['user_id'] = $user['id'];
		$coupon_data['purchased_time'] = date('Y-m-d H:i:s');
		$ret = $this->coupon_model->set_coupon_used($coupon['id'], $coupon_data);
		if (!$ret) {
			// just in case, make sure tables are unlocked
			$this->db->query('UNLOCK TABLES');
			// unable to set coupon as used, mark it as new
			$this->coupon_model->set_coupon_status($coupon['id'], 'new');
			redirect('auth/index');
		}
		
		// add flag that coupon has been used
		//$coupon['used'] = true;
		
		// create some coupon code
		$data = array();
		
		$data['brand'] = $brand;
		$data['strategy'] = $strategy;
		
		$data['ret'] = $ret;
		$data['coupon'] = array_merge($coupon_data, $coupon);
	
		// set the coupon's info in the session
		$this->session->set_userdata('coupon', $data['coupon']);
		
		//$this->load->view('coupon_create', $data);
		$this->template->build('coupon/coupon_view', $data);

		// destroy the session
		//$this->session->sess_destroy();
		
		
	}	
	
}

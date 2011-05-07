<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	
	function index()
	{
		$this->load->view('welcome_message');
	}
	
	/*
	public function index()
	{
		
		$this->mytests();
		
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
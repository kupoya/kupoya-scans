<?php

class Lottery extends MY_Controller {


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
		
		$this->load->model('lottery_model');
		$this->load->model('strategy_model');
		
		$this->load->helper('user_experience');
		
		$language = $this->getLanguage();
		$this->lang->load('lottery/lottery', $language);
		$this->lang->load('app', $language);

	}
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('lottery/lottery_invalid', $data);
		
	}
	
	
	
	public function index() {

		$data['brand'] = $this->session->userdata('brand');
		$data['strategy'] = $this->session->userdata('strategy');
		//$data['fbUser'] = $this->fbconnect->user;
		
		// add the lottery ticket count
		$lottery['tickets_usage_info'] = $this->lottery_model->get_lottery_usage($data['strategy']);
		$data['lottery'] = $lottery;
		
		$this->template->build('lottery/lottery', $data);
		
	}
	
	
	 
	
	public function view() {
		
		$brand = $this->session->userdata('brand');
		$strategy = $this->session->userdata('strategy');
		$user = $this->session->userdata('user');
		$lottery = $this->session->userdata('lottery');
		$medium = $this->session->userdata('medium');		
		
		
		// validate the user is able to opt-in to the lottery
		$this->load->model('lotteryvalidate_model');
		
		
		// check if the user already recieved a lottery ticket, if so, deliver it to him
		$lottery = $this->lotteryvalidate_model->check_lottery_used_by_user($strategy['id'], $user['id']);
		if ($lottery) {

			// create lottery ticket info
			$data = array();
			
			$data['brand'] = $brand;
			$data['strategy'] = $strategy;
			$data['lottery'] = $lottery;
			
			// set the lottery info in the session
			$this->session->set_userdata('lottery', $data['lottery']);
			
			return $this->template->build('lottery/lottery_view', $data);
			
		}
		
		
		
		// perform strategy-level validation
		$ret = $this->lotteryvalidate_model->validate_user($strategy['id'], $user['id']);
		if ($ret === false) {
			log_message('error', 'kupoya = user did not pass lottery validation');

			// set session error message for next view to display it to the user
			$flash_value = $this->lang->line('error_check_validation');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('lottery/invalid');
		}
		
		
		
		
		$ticket = $this->lottery_model->get_ticket_by_strategy_procedure($strategy, $user);
		// no lottery tickets left
		if ($ticket === false) {			
			// set session error message for next view to display it to the user
			$flash_value = $this->lang->line('error_no_tickets');
			$this->session->set_flashdata('error', $flash_value);
			
			redirect('lottery/invalid');
		}
		
		// perform medium actions
		$this->load->model('medium_handler');
log_message('debug', ' === calling medium_handler->perform_action');
		$ret = $this->medium_handler->perform_action($medium);
log_message('debug', ' === which returned: '.$ret);
		if (!$ret) {
			log_message('error', ' kupoya = could not complete medium_handler->perform_action');
			// unable to post to facebook, remove lottery ticket entry
			$this->lottery_model->del_ticket($ticket['id']);
			
			$login_url = $this->session->userdata('login_url');
			redirect($login_url);
		}
		

		// create lottery ticket code
		$data = array();
		
		$data['brand'] = $brand;
		$data['strategy'] = $strategy;
		
		$data['ret'] = $ret;
		$data['lottery'] = $ticket;
	
		$data['user'] = $user;
		
		// create the jobserver client to dispatch jobs
		if (class_exists('GearmanClient')) {
			$gm_client = new GearmanClient();
			// initialize localhost server with default connection info
			$gm_client->addServer();
			// perform background job
			$gm_client->doBackground('email-notification', serialize($data));
		}
		
		
		// set the lottery info in the session
		$this->session->set_userdata('lottery', $data['lottery']);
		
		$this->template->build('lottery/lottery_view', $data);
		
	}	
	
}

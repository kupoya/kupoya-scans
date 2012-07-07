<?php

class Notifications_Model extends CI_Model {

	public $language = 'en-us';
	

	public function Notifications_Model()
	{
		parent::__construct();
		
		$this->load->library('user_agent');
		$this->load->helper('url');


		$strategy = $this->session->userdata('strategy');
		if ($strategy && isset($strategy['language']) && !empty($strategy['language']))
			$this->language = $strategy['language'];
		else
			$this->language = $this->userexp->language_detect();

		$this->lang->load('app', $this->language);
		$this->lang->load('coupon/notification', $this->language);

	}
	


	public function get_coupon_tokens($data) {
	
		$values = array(
			$data['strategy']['name'],
			$data['strategy']['description'],
			site_url($data['strategy']['picture']),
			$data['coupon']['serial'],
			$data['coupon']['purchased_time'],
			$data['coupon']['id'],

			// template texts			
			$this->lang->line('Congrats'),
			$this->lang->line('click_here_to_get_it'),
			$this->lang->line('menu:My_Deals'),
			$this->lang->line('menu:Info'),
			
			
		);
		
		$place_holders = array(
			'___STRATEGY_NAME___',
			'___STRATEGY_DESCRIPTION___',
			'___BRAND_PICTURE___',
			'___COUPON_CODE___',
			'___PURCHASED_TIME___',
			'___COUPON_ID___',

			// template texts
			'___LANG_CONGRATS___',
			'___LANG_CLICK_HERE_TO_GET_IT___',
			'___LANG_MY_DEALS___',
			'___LANG_INFO___',


		);

		return array('place_holders' => $place_holders, 'values' => $values);

	}


	/**
	 * get a variable by it's key
	 * @param string $key
	 * @return string $ret
	 */
	public function get_variable($strategy_id = null, $key = null)
	{
		if (!$key || !$strategy_id)
			return false;

		$sql = 'SELECT `value` FROM `variables` WHERE `strategy_id` = ? AND `key` = ?';
		$query = $this->db->query($sql, array($strategy_id, $key));
		if (!$query)
			return false;

		$ret = false;
		if ($query->num_rows() > 0) {
			$ret = $query->row_array();
		}

		if (isset($ret['value']))
			return $ret['value'];
		
		return false;
	}
		
	
}
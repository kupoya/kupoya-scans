<?php

class CouponValidate_Model extends CI_Model {


	const COUPON_GET_DELAY = 43200;
	const USER_FRIENDS_MIN_COUNT = 5;

	public function CouponValidate_Model()
	{

		parent::__construct();
		
		$this->load->model('user_model');
		
	}


	
	
	
	public function validate_user($strategy_id = 0, $user_id = 0)
	{
		
		if ( ($strategy_id === 0) || ($user_id === 0) )
			return false;
			
log_message('debug', ' === validating user for coupon');
		// we start off by assuming this user is ok and then perform checks to validate 
		
		$ret = true;
		$ret = $ret && $this->check_coupon_used_by_user($strategy_id, $user_id);
		//$ret = $ret && $this->check_user_has_friends($user_id);
		
log_message('debug', ' === validation returned: '.$ret);
		return $ret;
		
			
	}
	
	
	
	
	
	public function check_user_has_friends($user_id = 0)
	{
		
		$user_count_info = $this->user_model->get_user_friends_count($user_id);
log_message('debug', ' === validating user friends count: '. (int)$user_count_info['count']);
		if ((int)$user_count_info['count'] > self::USER_FRIENDS_MIN_COUNT)
			return true;
		
log_message('debug', ' === validating user: check user has friends - returned BAD');
		return false;
		
	}
	
	
	
	

	public function check_coupon_used_by_user($strategy_id = 0, $user_id = 0)
	{

		if ( ($strategy_id === 0) || ($user_id === 0) )
			return false;

		// 12 hour check
		$sql = "
			SELECT coupon.id, coupon.purchased_time
			FROM coupon
			JOIN coupon_settings ON coupon_settings.id = coupon.instance_id
			WHERE
			 coupon_settings.strategy_id = ?
			AND
			 coupon.user_id = ?
			AND ( UNIX_TIMESTAMP( ) - UNIX_TIMESTAMP( coupon.purchased_time ) ) < ?
			LIMIT 1
		";
		$query = $this->db->query($sql, array($strategy_id, $user_id, self::COUPON_GET_DELAY));
		if (!$query)
			return false;

		// if we don't find any record that which indicates the user made a purchase in the last day
		// then we allow the user is validated ok
		if ($query->num_rows() === 0) {
log_message('debug', ' === validating user: check coupon used by user - returned ok');
			return true;
		}
		
		return false;
		
	}
	

}
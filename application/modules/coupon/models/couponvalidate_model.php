<?php

class CouponValidate_Model extends CI_Model {

	// delay for setting restriction on the intervals between getting a coupon or being rejected
	// currently set for 12 hours intervals
	const COUPON_GET_DELAY = 43200;
	
	// user's friends count setting for verifying that the user has enough friends to be considered
	// as legitimate facebook account  
	const USER_FRIENDS_MIN_COUNT = 5;

	
	
	public function CouponValidate_Model()
	{

		parent::__construct();
		
		$this->load->model('user_model');
		
	}


	
	
	/**
	 * 
	 * perform user validation actions
	 * @param integer $strategy_id the strategy id
	 * @param integer $user_id the user id
	 */
	public function validate_user($strategy_id = 0, $user_id = 0)
	{
		
		if ( ($strategy_id === 0) || ($user_id === 0) )
			return false;
			
		// we start off by assuming this user is ok and then perform checks to validate 
		$ret = true;
		
		if (ENVIRONMENT === 'production') {
			$ret = $ret && $this->check_user_has_friends($user_id);
			$ret = $ret && $this->check_coupon_used_by_user($user_id);
		}
			
		if (!$ret)
			log_message('debug', ' === user failed validation');
			
		return $ret;
		
			
	}
	
	
	
	/**
	 * 
	 * checks user has enough friends to be considered as a legitimate user
	 * @param integer $user_id the user id
	 */
	public function check_user_has_friends($user_id = 0)
	{
		
		$user_count_info = $this->user_model->get_user_friends_count($user_id);
		if ((int)$user_count_info['count'] > self::USER_FRIENDS_MIN_COUNT)
			return true;
		
		log_message('debug', ' === user rejected due to friends count validation: '.self::USER_FRIENDS_MIN_COUNT);
		return false;
		
	}
	
	
	
	
	/**
	 * 
	 * check if the user already recieved a coupon in the last interval (12 hours or so)
	 * @param integer $strategy_id the strategy id
	 * @param integer $user_id the user id
	 */
	public function check_coupon_used_by_user($strategy_id = 0, $user_id = 0)
	{

		if ( ($strategy_id === 0) || ($user_id === 0) )
			return false;

		// 12 hour check
		$sql = "
			SELECT coupon.serial, coupon.status, coupon.user_id, coupon.purchased_time
			FROM coupon
			JOIN coupon_settings ON coupon_settings.strategy_id = ?
			WHERE
			 coupon.strategy_id = ?
			AND
			 coupon.user_id = ?
			AND ( UNIX_TIMESTAMP( ) - UNIX_TIMESTAMP( coupon.purchased_time ) ) < ?
			LIMIT 1
		";
		$query = $this->db->query($sql, array($strategy_id, $strategy_id, $user_id, self::COUPON_GET_DELAY));
		if (!$query)
			return false;

		// if we don't find any record that which indicates the user made a purchase in the last day
		// then we allow the user is validated ok
		if ($query->num_rows() === 0) {
			return false;
		} else {
			// otherwise we return the user's coupon and purchased time
			return $query->row_array();
		}
		
	}
	

}
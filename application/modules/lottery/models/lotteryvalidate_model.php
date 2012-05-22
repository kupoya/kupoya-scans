<?php

class LotteryValidate_Model extends CI_Model {


	// user's friends count setting for verifying that the user has enough friends to be considered
	// as legitimate facebook account  
	const USER_FRIENDS_MIN_COUNT = 5;

	
	
	public function LotteryValidate_Model()
	{

		parent::__construct();
		
		$this->load->model('user/user_model');
		
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
	 * check if the user already recieved a lottery ticket
	 * @param integer $strategy_id the strategy id
	 * @param integer $user_id the user id
	 */
	public function check_lottery_used_by_user($strategy_id = 0, $user_id = 0)
	{

		if ( ($strategy_id === 0) || ($user_id === 0) )
			return false;

		$sql = "
			SELECT lottery.serial, lottery.user_id, lottery.purchased_time, lottery.winner
			FROM lottery
			JOIN lottery_settings ON lottery_settings.strategy_id = ?
			WHERE
			 lottery.strategy_id = ?
			AND
			 lottery.user_id = ?
			LIMIT 1
		";
		$query = $this->db->query($sql, array($strategy_id, $strategy_id, $user_id));
		if (!$query)
			return false;

		// if we don't find any record that which indicates the user recieved a lottery ticket
		// then we allow the user to get one
		if ($query->num_rows() === 0) {
			return false;
		} else {
			// otherwise we return the user's entry information
			return $query->row_array();
		}
		
	}
	

}
<?php

class Coupon_Model extends CI_Model {

	// the seconds after which a coupon entry in the database states that the campaign has ended 
	const COUPON_LAST_DELAY = 10;

	function Coupon_Model()
	{
		parent::__construct();
	}


	/**
	 * 
	 * delete the coupon from the database
	 * @param integer $coupon_id
	 */
	function del_coupon($coupon_id) {
		
		if (!$coupon_id || !is_numeric($coupon_id))
			return false;
			
		$this->db->delete('coupon', array('id' => $coupon_id));
		
	}
	

	
	/**
	 * 
	 * set coupon information
	 * @param integer $coupon_id
	 * @param array $data
	 */
	function set_coupon_used($coupon_id, $data)
	{

		$this->db->trans_begin();
		
		$this->db->where('id', $coupon_id);
		$query = $this->db->update('coupon', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}

		$this->db->trans_commit();
		
		return true;

	}


	/**
	 * 
	 * set coupon status
	 * @param integer $coupon_id
	 * @param string $status
	 */
	function set_coupon_status($coupon_id, $status = 'new')
	{
		if (!$coupon_id)
		return false;
			
		// if we were able to get a new coupon let's mark it as pending and return it
		$this->db->trans_begin();
		$sql = "
			UPDATE coupon
			SET
			 status = ?
			WHERE
			 id = ?
		";
		$query = $this->db->query($sql, array($status, $coupon_id));
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();

		$this->db->trans_commit();
		
		return true;

	}


	
	/**
	 * 
	 * determines whether there is an available coupon slot in the strategy based on plan type
	 * @param array $strategy the strategy array information
	 * @return array $coupon the coupon array information
	 */
	function get_coupon_slot(&$strategy) {
		
		// check strategy param
		if (!$strategy || !is_array($strategy) || !isset($strategy['id']) || !isset($strategy['plan_type']) || !isset($strategy['expiration_date']))
			return false;
			
		// expiration plan type
		if ($strategy['plan_type'] === 'expiration') {
			
			if (($strategy['expiration_date'] - time()) >= 0) {
				
				$this->db->select('custom_serial');
				$this->db->where('strategy_id', $strategy['id']);
				$this->db->limit(1);
				$query = $this->db->get('coupon_settings');
				
				$coupon_settings = $query->row_array();
				
				return $coupon_settings;
			} else {
				return false;
			}
			
		}
		
	
		// expiration plan type
		if ($strategy['plan_type'] === 'bank') {

			$continue_processing = false;
			
			$coupon_settings = array();
					
			// implementation of checking if a coupon slot exist is as follows:
			// 1. we check if a coupon slot exist
			// 2. if it doesn't:
			// 2.1. we check if the latest coupon slot purchased_time is older than X seconds,
			// 		meaning that this coupon strategy is definitely over and has ended a "long" time ago.
			//		therefore, no need to retry checking for coupon slots
			// 2.2. we retry for 2 times more with a delay of 1 second between attempts, if we were able
			// 		to get a coupon slot (due to another user having dropped it cause his facebook wall post
			// 		failed or something) then we exist the retry loop and continue with a valid slot
			// 2.3. if we retried for 3 seconds and no slots were available we finally abort the process
			$i = 1;
			while ($i <= 3) {
				$sql = "
					SELECT
					 COUNT(coupon.id) as coupon_used_count, coupon_settings.custom_serial,
					 (unix_timestamp() - MAX(UNIX_TIMESTAMP(coupon.purchased_time))) as elapsed_purchased_time
					FROM coupon coupon
					JOIN coupon_settings ON coupon_settings.strategy_id = ?
					WHERE
					 coupon.status = 'used'
					AND
					 coupon.strategy_id = ?
					LIMIT 1
				";
				$query = $this->db->query($sql, array($strategy['id'], $strategy['id']));
				
				$coupon_settings = $query->row_array();
				
				// check how many coupons are remaining for the business
				$coupons_left = (int) ($strategy['bank'] - $coupon_settings['coupon_used_count']);
				
				// if the latest purchased_time of a coupon is older than our delay we consider this campaign as 'over'
				// hence no need to run anymore checks, we return false
				if ($coupons_left <= 0 && $coupon_settings['elapsed_purchased_time'] >= self::COUPON_LAST_DELAY) {
					log_message('debug', ' === reached end of campaign flag');
					return false;
				}
				
	
				if ($coupons_left > 0) {
					// coupon slot(s) are available so we break out of the retry loop and continue to process it
					$continue_processing = true;
					log_message('debug', ' === found coupon slot!');
					break;
				}
				
				// increment retry counter
				$i++;
				
				// sleep for a second before we try again
				sleep(1);
				
			}
			
			if ($continue_processing === false)
				return false;
			else {
				return $coupon_settings;
			}
			
		}
		
		return false;
			
	}
	
	
	
	
	/**
	 *
	 * get a coupon by strategy id
	 * @param array $strategy the strategy array information
	 * @param array $user the user array information
	 * @return array $coupon the coupon array information
	 */
	function get_coupon_by_strategy(&$strategy, &$user)
	{

		// check strategy param
		if (!$strategy || !is_array($strategy))
			return false;
			
		// check user param
		if (!$user || !is_array($user) || !isset($user['id']) || !is_numeric($user['id']))
			return false;


		// we first check that there are free slots in the bank by validating
		// that the count of coupons in the db for this strategy is less or equal
		// to the bank size of the plan 
		$this->db->trans_begin();
		
		$coupon_settings = $this->get_coupon_slot($strategy);

		if ($coupon_settings === false) {
			$this->db->trans_rollback();
			return false;
		}
		
		// if coupon slots are available let's create a new one and add it to the db
		// as a coupon that we alotted

		// check if we should use a custom serial number as the coupon serial
		if (isset($coupon_settings['custom_serial']) && $coupon_settings['custom_serial']) {
			$coupon_serial = $coupon_settings['custom_serial'];
		} else {
			// otherwise, we create a random serial number 
			$coupon_serial = uniqid().'-'.rand(100, 999);
		}
		
		$coupon = array(
			'serial' => $coupon_serial,
			'status' => 'used',
			'user_id' => $user['id'],
			'purchased_time' => date('Y-m-d H:i:s'),
			'strategy_id' => $strategy['id'],
		);
		
		$this->db->insert('coupon', $coupon);
		$coupon_id = $this->db->insert_id();
		
		$coupon['id'] = $coupon_id;
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
			
		$this->db->trans_commit();

		return $coupon;

	}



	/**
	 * Get coupon by id
	 * @param integer $coupon_id the coupon id
	 * @return array $coupon the coupon result set
	 */
	public function get_coupon_by_id($coupon_id)
	{
		$this->db->where('c.id', $coupon_id);
		$this->db->limit(1);
		$results = $this->db->get('coupon c')->row_array();

		return $results;
	}


	/**
	 * Get coupons
	 * @param array $where AR-compatible $where clause
	 */
	public function get_coupons_by_user($user_id, $status = NULL)
	{
		/*

		SELECT *
		FROM coupon c
		JOIN strategy s ON s.id = c.strategy_id
		WHERE c.user_id = 1

		*/
		
		if (!$user_id)
			return false;

		//$this->db->select('c.id, c.serial, c.status, c.user_id, c.purchased_time, c.strategy_id, s.name, s.picture');
		$this->db->select('c.id, c.serial, c.status, c.user_id, c.purchased_time, c.strategy_id, s.name as strategy_name, s.picture as strategy_picture, b.name as brand_name');
		$this->db->join('strategy s', 's.id = c.strategy_id');
		$this->db->join('campaign_strategies cs', 'cs.strategy_id = s.id');
		$this->db->join('code code', 'code.campaign_id = cs.campaign_id');
		$this->db->join('brand b', 'b.id = code.brand_id');
		$this->db->where(array('c.user_id' => $user_id));

		if ($status)
			$this->db->where(array('c.status' => $status));
			
		$this->db->order_by('c.purchased_time', 'desc');
		$results = $this->db->get('coupon c')->result_array();

		return $results;
	}


	public function get_coupon_settings($strategy)
	{
		if (!$strategy || !isset($strategy['id']))
			return false;

		$this->db->where('strategy_id', $strategy['id']);
		$this->db->limit(1);
		$query = $this->db->get('coupon_settings');
		
		$coupon_settings = $query->row_array();
		
		return $coupon_settings;
	}
	
	

	/**
	 *
	 * get a coupon by strategy id using the stored procedure method
	 * @param array $strategy the strategy array information
	 * @param array $user the user array information
	 */
	function get_coupon_by_strategy_procedure(&$strategy, &$user)
	{
log_message('debug', '=== TEST 1');	
		// check strategy param
		if (!$strategy || !is_array($strategy) || !isset($strategy['plan_type']) || empty($strategy['plan_type']) || 
			!isset($strategy['id']) || empty($strategy['id']) || !is_numeric($strategy['id']))
			{
				log_message('debug', '=== TEST 2');	
				return false;
			}

		if (!isset($strategy['bank']) || empty($strategy['bank']))
			$strategy['bank'] = 0;

		if (!isset($strategy['expiration_date']) || empty($strategy['expiration_date']))
			$strategy['expiration_date'] = 0;


		// check user param
		if (!$user || !is_array($user) || !isset($user['id']) || !is_numeric($user['id']))
			return false;
			

		// create a random serial number 
		$coupon_serial = uniqid().'-'.rand(100, 999);
	

		// initialize variables to their default states and call the stored procedure 
		$this->db->query("SET @last_insert_id = 0");
		$this->db->query("SET @purchased_time = 0");
		$this->db->query("SET @coupon_custom_serial = ''");
		$this->db->query("SET @error = ''");
		// execute stored procedure which results in successfully creating a coupon or not
		$sql = "
				CALL GetCoupon(?, ?, ?, ?, ?, ?, ?, @last_insert_id, @error, @purchased_time, @coupon_custom_serial) ";
		$query = $this->db->query($sql, array($strategy['plan_type'], $coupon_serial, $user['id'], $strategy['id'], $strategy['bank'], $strategy['expiration_date'], self::COUPON_LAST_DELAY));

		// get the last_insert_id which is the inserted coupon row id.
		// if unsuccessful, it should return 0 (or null)
		$sql = "SELECT @last_insert_id as coupon_insert_id, @purchased_time as purchased_time, @coupon_custom_serial as coupon_serial, @error as error";
		//$sql = "SELECT * FROM coupon WHERE id = @last_insert_id";
		$query = $this->db->query($sql);
		
		if (!$query) {
			return false;
		}

		$row = $query->row_array();
log_message('debug', '===>>> ' . $row['coupon_insert_id']);
log_message('debug', '===>>> ' . $row['purchased_time']);
log_message('debug', '===>>> ' . $row['coupon_serial']);
log_message('debug', '===>>> ' . $row['error']);
		
		$coupon_id = $row['coupon_insert_id'];
		if ($coupon_id == 0 || !is_numeric($coupon_id))
			return false;
		
		$coupon = array(
			'id' => $coupon_id,
			'serial' => $row['coupon_serial'],
			'status' => 'used',
			'user_id' => $user['id'],
			'purchased_time' => $row['purchased_time'],
			'strategy_id' => $strategy['id'],
		);
		
		return $coupon;
	}	


}
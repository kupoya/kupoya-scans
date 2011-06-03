<?php

class Coupon_Model extends CI_Model {



	function Coupon_Model()
	{

		parent::__construct();
	}



	function set_coupon_used($coupon_id, $data)
	{

//		$status = 'used';

//		$this->db->query('LOCK TABLES coupon WRITE');

		$this->db->trans_begin();
		
		$this->db->where('id', $coupon_id);
		$query = $this->db->update('coupon', $data);
		/*
		$sql = "
			UPDATE coupon
			SET
			 status = ?
			 ,
			 user_id = ?
			 ,
			 purchased_time = CURRENT_TIMESTAMP()
			 
			WHERE
			
			 id = ?
		";
		$query = $this->db->query($sql, array($status, $user_id, $coupon_id));
		*/
//		$this->db->query('UNLOCK TABLES');
		
//		if (!$query) {
//			return false;
//		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}

		$this->db->trans_commit();
		
		return true;

	}


	function set_coupon_status($coupon_id, $status = 'new')
	{
		if (!$coupon_id)
		return false;
			
		// if we were able to get a new coupon let's mark it as pending and return it
//		$this->db->query('LOCK TABLES coupon WRITE');
		$this->db->trans_begin();
		$sql = "
			UPDATE coupon
			SET
			 status = ?
			WHERE
			 id = ?
		";
		$query = $this->db->query($sql, array($status, $coupon_id));
//		if (!$query)
//		return false;
//		$this->db->query('UNLOCK TABLES');
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();

		$this->db->trans_commit();
		
		return true;

	}


	/**
	 *
	 * get the currently (active) strategy id by campaign
	 * @param int $campaign_id the campaign id
	 * @return int $strategy_id the strategy id
	 */
	function get_coupon_by_strategy($strategy_id = 0)
	{

		if (!$strategy_id)
			return false;

		// check values are numeric
		if (!is_numeric($strategy_id))
			return false;

		// get a new coupon for our user
//		$this->db->query('LOCK TABLES coupon WRITE, coupon_settings WRITE');

		$this->db->trans_begin();
		$sql = "
			SELECT
			 coupon.id, coupon.serial, coupon.instance_id
			FROM coupon coupon
			JOIN coupon_settings ON coupon_settings.id = coupon.instance_id
			WHERE
			 coupon_settings.strategy_id = ?
			AND
			 coupon.status = 'new'
			LIMIT 1
		";
		$query = $this->db->query($sql, array($strategy_id));
//		if (!$query) {
//			$this->db->query('UNLOCK TABLES');
//			return false;
//		}
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();

		$coupon = $query->row_array();

		// if there are no available coupons unlock the table and return false
		if ($query->num_rows() === 0) {

			// unlock the table
//			$this->db->query('UNLOCK TABLES');
			if ($this->db->trans_status() === FALSE)
				$this->db->trans_rollback();
				
			return false;
		}

		// if we were able to get a new coupon let's mark it as pending and return it
		$sql = "
			UPDATE coupon
			SET
			 status = 'pending'
			WHERE
			 id = ?
		";
		$query = $this->db->query($sql, array($coupon['id']));
//		if (!$query) {
//			$this->db->query('UNLOCK TABLES');
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
			
//		$this->db->query('UNLOCK TABLES');
		$this->db->trans_commit();

		return $coupon;

	}


}
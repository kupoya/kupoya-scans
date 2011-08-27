<?php

class Lottery_Model extends CI_Model {

	
	
	// the seconds after which a coupon entry in the database states that the campaign has ended 
	const LOTTERY_LAST_DELAY = 10;

	function Lottery_Model()
	{
		parent::__construct();
	}

	

	/**
	 * 
	 * delete the ticket from the database
	 * @param integer $ticket_id
	 */
	function del_ticket($ticket_id) {
		
		if (!$ticket_id || !is_numeric($ticket_id))
			return false;
			
		$this->db->delete('lottery', array('id' => $ticket_id));
		
	}

	
	
	
	/**
	 * 
	 * return lottery usage statistics in array for 'tickets_count', 'min_count', 'remaining_count', and 'winners_count'
	 * @param array $strategy the strategy information array
	 */
	public function get_lottery_usage(&$strategy)
	{
		if (!$strategy)
			return false;
			
		if (!isset($strategy['bank']) || !isset($strategy['expiration_date']))
			return false;
			
		$this->db->select(array('min_count', 'winners_count', 'closed'));
		$this->db->from('lottery_settings');
		$this->db->where('strategy_id', $strategy['id']);
		$res = $this->db->get();
		$lottery_settings = $res->row_array();
		
		$this->db->select('id');
		$this->db->from('lottery');
		$this->db->where('strategy_id', $strategy['id']);
		$tickets_count = $this->db->count_all_results();
		
		return array(
			'tickets_count' => $tickets_count,
			'min_count' => $lottery_settings['min_count'],
			'remaining_count' => ($lottery_settings['min_count'] - $tickets_count),
			'winners_count' => $lottery_settings['winners_count'],
		);
		
		
	}

	
	
	
	

	/**
	 *
	 * get a ticket by strategy id using the stored procedure method
	 * @param array $strategy the strategy array information
	 * @param array $user the user array information
	 */
	public function get_ticket_by_strategy_procedure(&$strategy, &$user)
	{

		// check strategy param
		if (!$strategy || !is_array($strategy) || !isset($strategy['plan_type']) || empty($strategy['plan_type']) || 
			!isset($strategy['id']) || empty($strategy['id']) || !is_numeric($strategy['id']))
			return false;

		if (!isset($strategy['bank']) || empty($strategy['bank']))
			$strategy['bank'] = 0;

		if (!isset($strategy['expiration_date']) || empty($strategy['expiration_date']))
			$strategy['expiration_date'] = 0;
			
		// check user param
		if (!$user || !is_array($user) || !isset($user['id']) || !is_numeric($user['id']))
			return false;
			
		
		// create a random serial number 
		$ticket_serial = uniqid().'-'.rand(100, 999);
	

		// initialize variables to their default states and call the stored procedure 
		$this->db->query("SET @last_insert_id = 0");
		$this->db->query("SET @purchased_time = 0");
		$this->db->query("SET @error = ''");
		// execute stored procedure which results in successfully creating a coupon or not
		$sql = "
				CALL GetLotteryTicket(?, ?, ?, ?, ?, ?, ?, @last_insert_id, @error, @purchased_time) ";
		$query = $this->db->query($sql, array($strategy['plan_type'], $ticket_serial, $user['id'], $strategy['id'], $strategy['bank'], $strategy['expiration_date'], self::LOTTERY_LAST_DELAY));

		// get the last_insert_id which is the inserted coupon row id.
		// if unsuccessful, it should return 0 (or null)
		$sql = "SELECT @last_insert_id as ticket_insert_id, @purchased_time as purchased_time, @ticket_custom_serial as ticket_serial";
		//$sql = "SELECT * FROM coupon WHERE id = @last_insert_id";
		$query = $this->db->query($sql);
		
		if (!$query) {
			return false;
		}
		
		$row = $query->row_array();

		$ticket_id = $row['ticket_insert_id'];
		if ($ticket_id == 0 || !is_numeric($ticket_id))
			return false;
		
		$ticket = array(
			'id' => $ticket_id,
			'serial' => $row['ticket_serial'],
			'user_id' => $user['id'],
			'purchased_time' => $row['purchased_time'],
			'strategy_id' => $strategy['id'],
		);
		
		return $ticket;
	}	
	
	
	


}
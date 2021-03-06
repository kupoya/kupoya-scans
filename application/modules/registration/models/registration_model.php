<?php

Class Registration_Model extends CI_Model {
	
	
	public function Registration_Model()
	{
		
		parent::__construct();
		
	}


	
	/**
	 * 
	 * check that the strategy is valid
	 * @param array $strategy_info
	 */
	public function check_valid($strategy_info = null)
	{

		// check strategy param
		if (!$strategy_info || !is_array($strategy_info) || !isset($strategy_info['id']) 
			|| !isset($strategy_info['plan_type']) || !isset($strategy_info['expiration_date'])
			|| !isset($strategy_info['bank'])) {
				
			return false;
		}
			

		// expiration plan type
		if ($strategy_info['plan_type'] === 'expiration') {

			if (($strategy_info['expiration_date'] - time()) >= 0)
				return true;
			else
				return false;

		}
		
		
		
		// bank plan type
		if ($strategy_info['plan_type'] === 'bank') {
			
			if ($strategy_info['exposure_count'] > $strategy_info['bank'])
				return false;
			else
				return true;
				
		}

		
		return false;

	}
	
	
	
	/**
	 * 
	 * get information based on strategy id
	 * @param integer $strategy_id the strategy id
	 */
	public function get_by_strategy($strategy_id = 0)
	{
		
		if (!$strategy_id)
			return false;

		if (!is_numeric($strategy_id))
			return false;

		
		$this->db->where('strategy_id', $strategy_id);
		$query = $this->db->get('registration_settings');
		
		if (!$query)
			return false;
		
		return $query->row_array();
		
	}
	
	
	
	public function insert($strategy_id = 0, $registration_info) {
	
		if (!$strategy_id)
			return false;

		if (!is_numeric($strategy_id))
			return false;
		
		$data = array(
			'name' => $registration_info['name'],
			'contact' => $registration_info['contact'],
			'text' => $registration_info['message'],
			'created_time' => $registration_info['time'],
			'strategy_id' => $strategy_id,
		);
			
		$ret = $this->db->insert('registration', $data);
				
		return $ret;
		
	}
	
	
	
}
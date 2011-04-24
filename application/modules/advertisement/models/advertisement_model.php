<?php

Class Advertisement_Model extends CI_Model {
	
	
	public function Advertisement_Model()
	{
		
		parent::__construct();
		
	}
	
	
	
	
	public function check_valid($strategy_info = null)
	{
		if (!$strategy_info)
			return false;
			
		if ($strategy_info['exposure_count'] > $strategy_info['bank'])
			return false;
			
		return true;
			
	}
	
	
	public function get_by_strategy($strategy_id = 0)
	{
		
		if (!$strategy_id)
			return false;

		if (!is_numeric($strategy_id))
			return false;

		
		$this->db->where('strategy_id', $strategy_id);
		$query = $this->db->get('advertisement');
		
		if (!$query)
			return false;
		
		return $query->row_array();
		
		
	}
	
	
	
}
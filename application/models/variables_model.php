<?php

class Variables_Model extends CI_Model {
	

	public function Variables_Model()
	{
		parent::__construct();		
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
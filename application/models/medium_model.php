<?php

class Medium_Model extends CI_Model {
	

	public function Medium_Model()
	{
		parent::__construct();		
	}
	
	public function get_mediums_by_plan_id($plan_id = null) {
		
		if (!$plan_id)
			return false;
			
		$sql = "
			SELECT
			 m.name as medium, a.name as action
			FROM
			 medium_actions ma
			JOIN
			 plan_mediums pm ON pm.medium_actions_id = ma.id
			JOIN
			 medium m ON m.id = ma.medium_id
			JOIN
			 action a ON a.id = ma.action_id
			WHERE
			 pm.plan_id = ?
		";
		$query = $this->db->query($sql, array($plan_id));
		if (!$query)
			return false;
		
		// if no medium exists that's ok, return a dummy medium
		if ($query->num_rows() === 0) {
			return array('none' => 'none');
		}
		
		$my_mediums = array();
		// get all mediums and their actions
		foreach ($query->result_array() as $row) {
		   $my_mediums[$row['medium']][$row['action']] = $row['action'];
		}
		
		return $my_mediums;

	
	}
	
	
	
}
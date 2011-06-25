<?php

class Strategy_Model extends CI_Model {
	
	
	
	function Strategy_Model()
	{

		parent::__construct();		
	}
	
	
	/**
	 * 
	 * get the currently (active) strategy id by campaign 
	 * @param int $campaign_id the campaign id
	 * @return int $strategy_id the strategy id
	 */
	function get_strategy_by_campaign($campaign_id = 0)
	{
		
		if ($campaign_id === 0)
			return false;
		
		// check values are numeric
		if (!is_numeric($campaign_id))
			return false;
		
		$sql = "
			SELECT
				c.id, c.name, cm.name as mode, cs.strategy_id
			FROM
				`campaign` c
			JOIN
				campaign_mode cm ON cm.id = c.campaign_mode
			JOIN
				campaign_strategies cs ON cs.campaign_id = c.id
			WHERE
				c.id = ?
				AND
				cs.active = 1
			LIMIT 1
		";
		$query = $this->db->query($sql, array($campaign_id));
		
		// if no rows are found then possibly the campaign has no strategies defined
		// or none is marked as an active strategy
		// @TODO BUSINESS: what should we do in this case?  what about simply returning a landing page
		// with the brand information and that's all... like a temporary page until the strategies by
		// this brand are created.
		if ($query->num_rows() === 0) {
			return false;
			//$row = $query->row_array();
			//return $row['campaign_id'];
		}
		
		// figure out the mode defined for this campaign
		$row = $query->row_array();
		$campaign_mode = $row['mode'];
		
		// initialize variable
		$strategy_id = 0;
		
		// if campaign mode is 'static' we get the strategy which is active
		if ($campaign_mode === 'static') {
			$strategy_id = $row['strategy_id'];
			log_message('debug', ' === chosen static strategy: '.$strategy_id);
		} else {
			$strategy_id = $this->get_random_strategy($campaign_id);
			log_message('debug', ' === chosen random strategy: '.$strategy_id);
		}

		if ($strategy_id)
			return $this->get_strategy_info($strategy_id);
			
		return false;
		
	}
	
	
	
	function get_strategy_info($strategy_id)
	{
		
		if (!$strategy_id)
			return false;
		
		$sql = "	
			SELECT 
				s.id, s.name, s.description, s.picture, s.website, s.plan_id, UNIX_TIMESTAMP(s.expiration_date) as expiration_date,
				COALESCE(sum(p.bank),0) as bank, p.plan_type, st.name as type, exposure_count as exposure_count,
				smp.enabled AS alt_enabled, smp.name AS alt_name, smp.message AS alt_message, smp.picture as alt_picture, 
				smp.website as alt_website, s.language as language
			FROM strategy s
			JOIN `order` o ON o.strategy_id = s.id
			JOIN plan p ON s.plan_id = p.id
			JOIN strategy_type st ON p.strategy_type = st.id
			LEFT JOIN strategy_mediums_post smp ON smp.strategy_id = s.id
			WHERE
			 s.id = ?
			AND
			 o.status = 'paid'
			LIMIT 1
		";
		$query = $this->db->query($sql, array($strategy_id));
		
		return $query->row_array();
		
	}
	
	
	
	function get_random_strategy($campaign_id)
	{
		return 0;
	}
   
	
	
	public function increment_exposure_count($strategy_id = 0)
	{
		if (!$strategy_id)
			return false;

		// increment strategy exposure count
		$sql = 'UPDATE strategy SET exposure_count=(exposure_count+1) WHERE id = ?';
		$query = $this->db->query($sql, array($strategy_id));
		
		//$this->db->where('id', $strategy_id);
		//$this->db->update('strategy', array('exposure_count=exposure_count+1)'), null, false);
			
			
	}
	
	
	
}
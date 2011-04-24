<?php 

class Code_Model extends CI_Model {
	
	
	
	function Code_Model()
	{
		parent::__construct();		
	}
	
	
	/**
	 * 
	 * check if a pair of brand_id/code_id exist in the database
	 * also depends on whether the code_id is blocked or not
	 * @param int $brand_id the brand id
	 * @param int $code_id the code id
	 * @return int $campagin_id the campaign id
	 */
	function get_campaign_by_brand_code($brand_id = 0, $code_id = 0)
	{
		
		// check values are numeric
		if (!is_numeric($brand_id) || !is_numeric($code_id))
			return false;
		
		$sql = "
			SELECT
			 campaign_id
			FROM
			 code c
			JOIN brand b ON c.brand_id = b.id
			WHERE
			 c.id = ?
			AND
			 b.id = ?
			AND
			 b.blocked = 0
			LIMIT 1
		";
		$query = $this->db->query($sql, array($code_id, $brand_id));
		
		// if we found an existing entry, we return the campaign id
		if ($query->num_rows() === 1) {
			
			$row = $query->row_array();
			return $row['campaign_id'];
			
		} else {
			return false;
		}

	}
	
	
}
   
   
   
	
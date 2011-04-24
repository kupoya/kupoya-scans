<?php 

class Brand_Model extends CI_Model {
	
	
	
	function Brand_Model() {
      //Call the Model constructor
      parent::__construct();

	}
	
	/**
	 * 
	 * get brand information
	 * @param int $brandId the brand id
	 */
	function getBrandInfo($brandId = 0) {
		
		if (!is_numeric($brandId))
			return false;
		
		$sql = "

			SELECT
			 brand.name, brand.description, brand.picture
			FROM
			 brand
			WHERE
			 brand.id = ?
			AND
			 brand.blocked = 0
			LIMIT 1
		
		";
		$query = $this->db->query($sql, array($brandId));
		
		if ($query->num_rows() === 1)
			return $query->row_array();
		else
			return false;
		
		
	}
   
   
   
	
	
}
<?php 

class Product_Model extends CI_Model {
	
	
	
	function Product_Model() {
      //Call the Model constructor
      parent::__construct();
		
	}
	
	
	/**
	 * 
	 * check if a pair of brand_id/product_id exist in the database
	 * also depends on whether the brand_id is blocked or not
	 * @param int $brandId the brand id
	 * @param int $productId the product id
	 */
	function isExistProductByBrandId($brandId = 0, $productId = 0) {
		
		// check values are numeric
		if (!is_numeric((int)$brandId) || !is_numeric((int)$productId))
			return false;
		
		$sql = "

			SELECT
			 p.id
			FROM
			 product p
			JOIN brand b ON p.brand_id = b.id
			WHERE
			 p.id = ?
			AND
			 b.id = ?
			AND
			 b.blocked = 0
			LIMIT 1
		
		";
		$query = $this->db->query($sql, array($productId, $brandId));
		
		if ($query->num_rows() === 1)
			return true;
		else
			return false;
		
		
	}
   
   
   
	
	
	
}
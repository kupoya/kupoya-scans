<?php 

class Brand_Model extends CI_Model {
	
	
	
	function Brand_Model() {
      //Call the Model constructor
      parent::__construct();

	}
	
	/**
	 * 
	 * get brand information
	 * @param int $brand_id the brand id
	 */
	function get_brand_info($brand_id = 0) {
		
		if (!is_numeric($brand_id))
			return false;
		
		$sql = "

			SELECT
			 brand.id, brand.name, brand.description, brand.picture
			FROM
			 brand
			WHERE
			 brand.id = ?
			AND
			 brand.blocked = 0
			LIMIT 1
		
		";
		$query = $this->db->query($sql, array($brand_id));
		
		if ($query->num_rows() === 1)
			return $query->row_array();
		else
			return false;
		
		
	}
   
   
	function get_brand_contact_info($brand_id = 0) 
	{
		
		if (!is_numeric($brand_id))
			return false;
			
		/*
		$sql = "
			SELECT
				c.name, c.phone, c.address
			FROM brand b
			JOIN contact c ON b.contact_id = c.id
			WHERE b.id = ?
			LIMIT 1 
		";
		
		$query = $this->db->query($sql, array($brand_id));
		*/

		$this->db->select('c.*');
		$this->db->from('contact c');
		$this->db->join('brand b', 'b.contact_id = c.id');
		$this->db->where('b.id', $brand_id);
		$this->db->limit(1);		
		$query = $this->db->get();
			
		return $query->row_array();
		
	}
   
	
	
}
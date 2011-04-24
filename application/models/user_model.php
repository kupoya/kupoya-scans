<?php
	/**
	 * CodeIgniter Facebook Connect Graph API User Model 
	 * 
	 * Author: Graham McCarthy (graham@hitsend.ca) HitSend inc. (http://hitsend.ca)
	 * 
	 * VERSION: 1.0 (2010-09-30)
	 * LICENSE: GNU GENERAL PUBLIC LICENSE - Version 2, June 1991
	 * 
	 **/

 class User_model extends CI_Model {
   var $user_id = "";
   var $full_name = "";
   var $pwd = "";
   var $fb_uid = "";
   
   function __construct() {
      //Call the Model constructor
      parent::__construct();
   	
   }

   
   
   
   function update_user($id, $info = null, $use_auth_uid = false)
   {
   	
   		if ( ($info == null) || !$id )
   			return false;
   		
   		$where = 'id';
   		if ($use_auth_uid === true)
   			$where = 'auth_uid';
   				
   		$this->db->where($where, $id);
   		$query = $this->db->update('user', $info);
   		if (!$query)
   			return false;
   		
   
   }
   
   function create_user($info = null)
   {
   	
   		if ($info == null)
   			return false;
   		
   		if (!$info['auth_provider'] || !$info['auth_uid'])
   			return false;
   			
   		$user_info_id = $this->create_user_info($info);
   		if ($user_info_id === false)
   			return false;
   		
   		$date = date('Y-m-d H:i:s');
   		
   		$data['auth_provider'] = $info['auth_provider'];
   		$data['auth_uid'] = $info['auth_uid'];
   		$data['user_info_id'] = $user_info_id;
   		$data['lastlogin_time'] = $date;
   		$data['created_time'] = $date;
   	
		$insert = $this->db->insert('user', $data);
		
		// if there was an error creating the user return false
		if (!$insert)
			return false;
		
		return $this->db->insert_id();;
      
   }
   
   
   
   function create_user_info($info = null) {
	
		if ($info === null)
			return false;
			
		$data['name'] = isset($info['name']) ? $info['name'] : '';
		$data['email'] = isset($info['email']) ? $info['email'] : '';
		$data['first_name'] = isset($info['first_name']) ? $info['first_name'] : '';
		$data['last_name'] = isset($info['last_name']) ? $info['last_name'] : '';
		$data['birthday'] = isset($info['birthday']) ? $info['birthday'] : '';
		$data['gender'] = isset($info['gender']) ? $info['gender'] : '';
		$data['location'] = isset($info['location']) ? $info['location'] : '';
		$data['timezone'] = isset($info['timezone']) ? $info['timezone'] : 0;
		$data['locale'] = isset($info['locale']) ? $info['locale'] : '';
		$data['friends_count'] = isset($info['friends_count']) ? $info['friends_count'] : 0;
				
		$insert = $this->db->insert('user_info', $data);
		if ($insert)
			return $this->db->insert_id();
			
		return $insert;
   	
   }
   
   
   
   function get_user_by_authprovider_uid($uid = 0, $authProvider = 'facebook') {

   		// returns the facebook user as an array.
	   	$sql = "SELECT * FROM user WHERE auth_uid = ? AND auth_provider = ? LIMIT 1";
	   	$query = $this->db->query($sql, array($uid, $authProvider));
	   	
	   	if ($query->num_rows() === 1) {
	   		// return user
	   		return $query->row_array();
	   		
	   	} elseif ($query->num_rows() == 0) {
	   		// no user found
	   		return false;
	   		
	   	} else {
	   		// multiple users exist? that's bad...
	   		return -1;
	   	}
   }
   
   
   
   
   
	function get_user_friends_count($id = 0) {
   	
		if ($id === 0)
			return false;
   	
	   	$sql = "
	   		SELECT ui.friends_count as count
	   		FROM user u
	   		JOIN user_info ui ON u.user_info_id = ui.id
			WHERE u.id = ?
			LIMIT 1
		";
	   	$query = $this->db->query($sql, array($id));
	   	
	   	return $query->row_array();
   	
	}

	
 }
 
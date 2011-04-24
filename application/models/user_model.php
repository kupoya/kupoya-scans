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

   
   
   function create_user($info = null) {
   /*
      $this->user_id       = $db_values["user_id"];
      $this->full_name  = $db_values["full_name"];
      //$this->pwd           = md5($db_values["pwd"]);
      if(strlen($db_values['fb_uid']) > 0) {
      $this->fb_uid 	   = $db_values['fb_uid'];
      } else {
       $this->fb_uid = "";
      }
      */
   	
   		if ($info === null)
   			return false;
   			
   		$user_info_id = $this->create_user_info($info);
   		if ($user_info_id === false)
   			return false;
   	
   		$data['auth_provider'] = $info['auth_provider'];
   		$data['auth_uid'] = $info['id'];
   		$data['user_info_id'] = $user_info_id;
   	
		$insert = $this->db->insert('user', $data);
		return $insert;
      
   }
   
   
   
   function create_user_info($info = null) {
	
		if ($info === null)
			return false;
			
		$data['first_name'] = $info['first_name'];
		$data['last_name'] = $info['last_name'];
		$data['birthday'] = $info['birthday'];
		$data['gender'] = $info['gender'];
		$data['location'] = $info['location']['name'];
		$data['timezone'] = $info['timezone'];
		$data['locale'] = $info['locale'];
		
		$insert = $this->db->insert('user_info', $data);
		return $insert;
   	
   }
   
   
   
   function get_user_by_authprovider_uid($uid = 0, $authProvider = 'facebook') {

   		// returns the facebook user as an array.
	   	$sql = "SELECT * FROM user WHERE auth_uid = ? AND auth_provider = ?";
	   	$query = $this->db->query($sql, array($uid, $authProvider));
	   	
	   	if ($query->num_rows() == 1) {
	   		// return existing user
	   		// or just return true for the sake of simplicity
	   		return true;
	   	} elseif ($query->num_rows() == 0) {
	   		// no user found
	   		return false;
	   	} else {
	   		// multiple users exist? that's bad...
	   		return -1;
	   	}
   }	
   
   
   
 }
 
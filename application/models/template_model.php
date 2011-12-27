<?php

class Template_Model extends CI_Model {
	
	
	public $html_view_tags = '<p><h1><h2><h3><img><a><br>';
	
	
	/**
	 * Constructor
	 */
	public function Template_Model()
	{
		//Call the Model constructor
		parent::__construct();
		$this->load->library('mongo_db');
	}
	
	
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function get_blocks_by_strategy($strategy_id, $view = null)
	{

		if (!$strategy_id)
			return FALSE;
		
		// having to include the library in a static clause as well, to make sure db connection is provided
		$this->load->library('mongo_db');
		
		$where['strategy_id'] = (int) $strategy_id;
		
		if ($view != NULL)
			$where['view'] = $view;
		
		$blocks = $this->mongo_db->get_where('strategy_template', $where);
		if (isset($blocks[0]['blocks']))
			return $blocks[0]['blocks'];
		
		return FALSE;
	}
	
	
	
	/**
	 * 
	 * define allowed HTML tags to be used in HTML output string/view
	 */
	public static function html_view($text) {
		
		$text_allowed = strip_tags($text, '<div><span><p><h1><h2><h3><img><a><br><ul><li>'); //$this->html_view_tags);
		echo $text_allowed;
		
	}
	
	
}
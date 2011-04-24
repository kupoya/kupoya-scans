<?php

class Base_Model extends MY_Model {
	
	//protected $_table = 'user';
	
	
	function __construct()
	{
		parent::__construct();
		
        // load tables this model operates on
        // $this->load_table('[table_name'], '[alias'], '[fields]', '[primary key]');
		$this->load_table('menu_member');
		$this->load_table('menu_member_settings');
		$this->load_table('menu_group');
		
		$this->load_table('widget_places');
		$this->load_table('widget_item');
		
		
        // describe relationships
        // $this->table1->related('table2', array('table1_key', 'table2_key'));
		$this->menu_member->related('menu_group', array('group_id', 'id'));
		$this->menu_member_settings->related('menu_member', array('menu_member_id', 'id'));

		$this->widget_item->related('widget_places', array('widget_places_id','id'));
		
	}
	
	
	
	
	function getWidgets()
	{
		echo "test1";
		$widgets = array();
		
		$queryResult = $this->with("$this->widget_item")
							->select(
								array(
									'widget_item.title',
									'widget_item.name',
									'widget_item.url',
									'widget_places.name',
									),
									false
								)
							->from()
							->join()
							->get();
		echo "test2";					
		return $queryResult;
		
	}
	
	/*
	 * return the menu tree 
	 * 
	 * @return		array		a multi-dimentional array (of 2nd degree) of a tree-like menu description
	 */
	function getMenu()
	{
		// initialize menu array
		$menuEntries = array();
		
		$queryResult = $this->with("$this->menu_member")
							->select(
									array(
							
									'menu_member.name AS menu_name',
									'menu_member.id',
									'menu_member.group_id',
									'menu_member.url',
									'menu_group.member_head',
									'menu_member_settings.title',
								
									), false
								)
							->from()
							->join("$this->menu_group")
							->join("$this->menu_member_settings")
							->order_by('menu_member.group_id ASC')
							->order_by('menu_group.member_head ASC')
							->get();
		
		
		//var_dump($queryResult);
			
		foreach($queryResult as $menuEntry)
		{
			
			//$menuEntries[$menuEntry['group_id']]['head'] = 
			$menuEntries[$menuEntry['group_id']][] = $menuEntry;
			
		}
		
		return $menuEntries;
		
	}
	
	
	
	
	
	
	
}
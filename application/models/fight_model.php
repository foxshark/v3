<?php

class Fight_model extends Model {

	// create a sample object out patient info
	function Fight_model ()
	{
		parent::Model();
		
		// Tables being used:
//		$this->_tree	= 'tech_tree';
		$this->_tpts	= 'tech_points';
	}

	function makeAttackSet($usr, $tree)
	{
		//pre_print_r($usr);
		//pre_print_r($tree[1]);
		$atk_opt = array();
		foreach($tree[1] as $t)
		{
		//	if(isset($user['tree'][$t['id']])).... set slvl
		}
		$fight = array();
		for ($x=0; $x <10; $x++)
		{
			$r =  rand(1,10);
			//$fight[] =
		}
		// die;
		return $fight;	
	}
		
}
	
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php

class Tree_model extends Model {

	// create a sample object out patient info
	function Tree_model ()
	{
		parent::Model();
		
		// Tables being used:
		$this->_tree	= 'tech_tree';
		$this->_tpts	= 'tech_points';
	}

	function getTreeSet($class = 0)
	{
		$data = array();
		$this->db->where('class', $class);
		$this->db->order_by('parent', 'asc');
		$query = $this->db->get($this->_tree);
		
		foreach ($query->result() as $row)
		{
			$data[$row->id] = get_object_vars($row);
		}	
		return $data; 
	}
	
	function getFormatTreeSet($class = 0)
	{
		$tree = array();
		foreach($this->getTreeSet($class) as $t)
		{
			$tree[$t['t_branch']][] = $t;
		}
		return $tree;	
		//pre_print_r($tree); die;
	}
	
	function getUserArrayInfo($id_arr = array())
	{
		$data = array();
		if(!empty($id_arr)){
			$this->db->where_in('id', $id_arr); 
			$query = $this->db->get($this->_users);
			
			$user = array();
			foreach ($query->result() as $row)
			{
				$data[$row->id] = get_object_vars($row);
			}	
		
		}
		return $data;
	}
	
	function getUserInfo($id=0)
	{
		$data = array();

		$this->db->where('id', $id); 
		$query = $this->db->get($this->_users);
		
		$user = array();
		foreach ($query->result() as $row)
		{
			$user = get_object_vars($row);
		}	
		$user['tree'] = $this->getUserTree($id);
		//$user['account'] = $this->_cashIn($user);
		return $user;
	}
	
	function getUserTree($user_id)
	{
		$tree = array();
		$class = 0;
		$this->db->where('user_id', $user_id); 
		$query = $this->db->get($this->_tpts);
		foreach ($query->result() as $row)
		{
			$tree[$row->tree_id] = $row->lvl;
		}	
		return $tree;
	}
	
	function getMyStats()
	{
		$id = $this->session->userdata('id');
		$data = $this->getUserInfo($id);
		//$data = array("id"=> $id, "name"=>"kyle", "account"=>50, "tot_resource"=>25);
		//$data['places']			= $this->get_places($id);
		//$data['tot_resource']	= $this->get_total_resources($id);
		return $data;
	}	
		
	function get_places($id)
	{
		$p = array();
		
		$this->db->where('user_owner', $id); 
		$query = $this->db->get($this->_places);
				
		foreach ($query->result() as $row)
		{
			$p[] = get_object_vars($row);
		}	
		return $p;
	}

	function get_place($place_id)
	{
		$p = array();
		$this->db->where('id', $place_id); 
		$query = $this->db->get($this->_places);
				
		foreach ($query->result() as $row)
		{
			$p = get_object_vars($row);
		}	
		return $p;
	
	}

	function _cashIn($user)
	{
		$hours_since_cashed = floor((time() - strtotime($user['last_cash_in'])) / 3600);
		if($hours_since_cashed > 0)
		{
			$tot_resources = $this->get_total_resources($user['id']);	
			$user['account'] += ($tot_resources * $hours_since_cashed);
			
			$this->db->where('id', $user['id']);
			$this->db->update($this->_users, array("last_cash_in"=>date("Y-m-d H:i:s"), "account"=>$user['account'])); 
		}
		return $user['account'];
	}
	
	function get_total_resources($id)
	{
		$total = 0;
		$this->db->where('owner_id', $id); 
		$query = $this->db->get($this->_grid_square);
		
		foreach ($query->result() as $row)
		{
			$total += $row->resource_value;
		}
		return $total;
	}
	
	function spendMoney($user, $cost)
	{
		$new_cash = $user['account'] - $cost;
		$this->_update_account($user['id'], $new_cash);
	}
	
	function takeMoney($atk_user, $def_user, $loot)
	{
		$sum_win	= $atk_user['account'] + $loot;
		$sum_loose	= $def_user['account'] - $loot;
		$this->_update_account($atk_user['id'], $sum_win);
		$this->_update_account($def_user['id'], $sum_loose);
	}
	
	function findAllUsers()
	{
		$data = array();

		$this->db->where('id', $id); 
		$query = $this->db->get($this->_users);
		
		foreach ($query->result() as $row)
		{
			$data[$row->id] = get_object_vars($row);
		}	
		
		return $data;
	}
		
}
	
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
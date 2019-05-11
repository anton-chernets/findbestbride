<?php

Class Finance_model extends CI_Model
{
	function getManBuyList($man_id)
	{
		$query = $this->db->get_where('user_payments', array('id' => $man_id, 'order_status' => '1'));
		
		return $query->result_array();
	}
	
	function getManSellList($man_id)
	{
		$query = $this->db->get_where('credits_logs', array('user_id' => $man_id));
		
		return $query->result_array();
	}
}
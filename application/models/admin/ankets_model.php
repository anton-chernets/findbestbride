<?php

Class Ankets_model extends CI_Model
{
	function men_credits()
	{
		$query = $this->db->order_by('credits', 'desc')->get_where('user_profile', array('sex' => '1', 'user_status' => '0'));
		
		return $query->result_array();
	}
	
	function getPassport($user_id)
	{
		$query = $this->db->get_where('user_passport', array('user_id' => $user_id));
		
		return $query->result_array();
	}
}
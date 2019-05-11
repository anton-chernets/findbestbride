<?php

Class Messages_model extends CI_Model
{
	public function getInMessages($user_id)
	{
		$query = $this->db->order_by('msg_date', 'desc')->get_where('private_messages', array('to_user_id' => $user_id));
		
		return $query->result_array();
	}
	
	public function getOutMessages($user_id)
	{
		$query = $this->db->order_by('msg_date', 'desc')->get_where('private_messages', array('from_user_id' => $user_id));
		
		return $query->result_array();
	}
}
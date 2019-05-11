<?php

Class Activation_model extends CI_Model
{
	function getAnketsToActivate()
	{
		$this->db->order_by('register_date', 'desc');
		$query = $this->db->get_where('user_profile', array('user_status' => '3'));
	
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	
		return false;
	}
	
	function getVideoToActivate()
	{
		$query = $this->db->query("SELECT a.*, b.* FROM user_videos a LEFT JOIN user_profile b ON a.id = b.id WHERE a.approved = '0' ORDER BY a.add_date DESC");
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function approveVideo($name)
	{
		$this->db->update('user_videos', array('approved' => '1'), array('video_name' => $name));
	}
	
	function cancelVideo($name)
	{
		$this->db->delete('user_videos', array('video_name' => $name));
	}
	
	function getPassportPhotos($id)
	{
		$query = $this->db->get_where('user_passport', array('user_id' => $id));
		
		return $query->result_array();
	}
	
	function getAnketDetails($id)
	{
		$query = $this->db->get_where('women_details', array('id' => $id));
		
		return $query->row_array();
	}
	
	function getBroadcastToActivate()
	{
		$query = $this->db->get_where('user_broadcast', array('approved' => '0'));
		
		return $query->result_array();
	}
	
	function approveBroadcast($id)
	{
		$this->db->delete('user_broadcast', array('user_id' => $id));
	}
	
	public function getAvatarsToActivate()
	{
		$query = $this->db->get_where('user_profile', array('avatar_act !=' => ''))->result_array();
		
		return $query;
	}
}
<?php

Class Video_model extends CI_Model
{
	public function getUserVideos($user_id)
	{
		$query = $this->db->get_where('user_videos', array('id' => $user_id));
		
		return $query->result_array();
	}
	
	public function createNewVideo($data)
	{
		$this->db->insert('user_videos', $data);
	}
	
	public function isVideoExist($video, $user_id)
	{
		$query = $this->db->get_where('user_videos', array('video_name' => $video, 'id' => $user_id));
		
		if ($query->num_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function deleteVideo($user_id, $video)
	{
		$this->db->delete('user_videos', array('id' => $user_id, 'video_name' => $video));
	}
}
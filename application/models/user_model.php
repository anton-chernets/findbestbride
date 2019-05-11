<?php

Class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getWomenProfile($id)
	{
		$query = "
			SELECT
			user_profile.*,
			women_details.*
			FROM
			user_profile
			LEFT JOIN women_details ON user_profile.id = women_details.id
			WHERE
			user_profile.id = ?
		";
		
		return $this->db->query($query, array($id))->row_array();
	}
	
	/******* ÏĞÈÃËÀØÅÍÈß Â ĞÎÌÀÍÒÈ×ÅÑÊÈÉ ÒÓĞ ***/
	
	function isAgencyHaveRt($p_id)
	{
		$query = $this->db->get_where('romance_tours', array('p_id' => $p_id, 'status' => '1'));
		
		if ($query->num_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function allToursOfAgency($p_id)
	{
		return $this->db->get_where('romance_tours', array('p_id' => $p_id, 'status' => '1'))->num_rows();
	}
	
	function getTourList($p_id, $start, $end)
	{
		$query = "
			SELECT
			romance_tours.*
			FROM romance_tours
			WHERE
			romance_tours.p_id = ?
			AND romance_tours.status = '1'
			ORDER BY romance_tours.tour_id desc
			LIMIT {$start}, {$end}
		";
		
		return $this->db->query($query, array($p_id))->result_array();
	}
	
	function getTourPhoto($tour_id, $type)
	{
		$query = $this->db->get_where('user_partner_images', array('tour_id' => $tour_id, 'photo_type' => $type));
		
		return $query->result_array();
	}
	
	function getManProfile($id)
	{
		$query = "
			SELECT
			user_profile.*,
			man_details.*
			FROM
			user_profile
			LEFT JOIN man_details ON user_profile.id = man_details.id
			WHERE
			user_profile.id = ?
		";
		
		return $this->db->query($query, array($id))->row_array();
	}
	
	function womenVideo($id)
	{
		$query = $this->db->get_where('user_videos', array('id' => $id, 'approved' => '1'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function lastRegistered()
	{
		$query = "
			SELECT
			*
			FROM user_profile
			WHERE `sex` = '2'
			ORDER BY register_date desc
			LIMIT 3
		";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() == 3)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function getUserPhoto($id)
	{
		$query = $this->db->get_where('user_photos', array('id' => $id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return false;
	}
	
	function checkContactReq($myid, $id)
	{
		$query = $this->db->get_where('request_info', array('id' => $myid, 'req_id' => $id))->num_rows();
		
		if ($query > 0)
		{
			return false;
		}
		
		return true;
	}
	
	/* Ïğîñìîòğ âèäåî */
	function checkManCredits($id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $id))->row_array();
		
		return $query['credits'];
	}
	
	function openVideo($id)
	{
		$credits = $this->checkManCredits($id);
		if ($credits >= '20')
		{
			$newCred = $credits - 20;
			$this->db->update('user_profile', array('credits' => $newCred), array('id' => $id));
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/* Äîáàâëåíèå â çàêëàäêè */
	function checkUserFavorite($id, $myid)
	{
		$query = $this->db->get_where('user_favorites', array('id' => $myid, 'fav_id' => $id))->num_rows();
		
		if ($query > 0)
		{
			return false;
		}
		
		return true;
	}
	
	function addFavorite($id, $myid)
	{
		if ($this->checkUserFavorite($id, $myid) != false)
		{
			$list = array(
				'id' 		=> $myid,
				'fav_id'	=> $id,
				'add_date'	=> time()
			);
			$this->db->insert('user_favorites', $list);
			return true;
		}
		
		return false;
	}
	
	/* Çàïğîñ íà ïğèåçä */
	function checkRt($myid, $id)
	{
		$query = $this->db->get_where('rt_request', array('id' => $myid, 'status' => '0'))->num_rows();
		
		if ($query > 0)
		{
			return false;
		}
		
		return true;
	}
	
	function sendRt($myid, $id, $tour_id)
	{
		if ($this->checkRt($myid, $id) != false)
		{
			$list = array (
				'id'		=> $myid,
				'req_id'	=> $id,
				'date'		=> time(),
				'hash'		=> md5(time() . $myid . $id),
				'tour_id'	=> $tour_id
			);
			
			$this->db->insert('rt_request', $list);
			return true;
		}
		
		return false;
	}
	
	
	/* Çàïğîñ êîíòàêòîâ */
	function sendContactRequest($id, $myid)
	{
		$check = $this->db->get_where('request_info', array('id' => $myid, 'req_id' => $id))->num_rows();
		
		if ($check == 0)
		{
			$insert = array (
				'id' 		=> $myid,
				'req_id'	=> $id,
				'req_date'	=> time(),
				'hash'		=> md5(time() . $myid . $id)
			);
			$this->db->insert('request_info', $insert);
			
			return true;
		}
		
		return false;
	}
}
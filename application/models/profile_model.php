<?php

Class Profile_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/** главная страница профиля **/
	
	// нужно ли выводить окно с просьбой заполнить профиль и загрузить фото
	function isNeedAttention($id)
	{
		$isPhotos = $this->db->get_where('user_photos', array('id' => $id))->num_rows();
		$isBday	  = $this->db->get_where('user_profile', array('id' => $id))->row_array();
		
		if ($isPhotos < 1 || $isBday['b_day'] == '')
		{
			return true;
		}
		
		return false;
	}
	
	// изменение аватара
	
	function updateAvatarName($id, $fileName)
	{
		$this->db->update('user_profile', array('avatar_act' => $fileName), array('id' => $id));
	}
	
	// удаление аватара 
	
	function deleteAvatar($id)
	{
		$this->db->update('user_profile', array('photo_link' => ''), array('id' => $id));
	}
	
	/** фотографии **/
	
	function getMyPhotoCount($id)
	{
		$count = $this->db->get_where('user_photos', array('id' => $id))->num_rows();
		
		if ($count)
		{
			return $count;
		}
		
		return '0';
	}
	
	function saveNewPhoto($id, $img_name)
	{
		$insertData = array (
			'id'			=> $id,
			'upload_date'	=> time(),
			'photo_name'	=> $img_name
		);
		
		$this->db->insert('user_photos', $insertData);
	}
	
	function getUserPhotos($id)
	{
		$this->db->order_by('upload_date', 'desc');
		$query = $this->db->get_where('user_photos', array('id' => $id))->result_array();
		
		return $query;
	}
	
	function isUserPhoto($id, $img)
	{
		$query = $this->db->get_where('user_photos', array('id' => $id, 'photo_name' => $img))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function getPhotoInfo($id, $img)
	{
		return $this->db->get_where('user_photos', array('id' => $id, 'photo_name' => $img))->row_array();
	}
	
	function deletePhoto($id, $img)
	{
		$this->db->delete('user_photos', array('id' => $id, 'photo_name' => $img));
	}
	
	/** смена пароля **/
	
	function saveNewPassword($id, $pwd)
	{
		$this->db->update('user_profile', array('password' => $pwd), array('id' => $id));
	}
	
	/** профиль **/
	
	function getUserDetails($id, $sex)
	{
		if ($sex == 1)
		{
			$query = $this->db->get_where('man_details', array('id' => $id))->row_array();
		}
		else
		{
			$query = $this->db->get_where('women_details', array('id' => $id))->row_array();
		}
		
		return $query;
	}
	
	function updateProfile($profile, $details, $id, $sex)
	{
		$this->db->update('user_profile', $profile, array('id' => $id));
		if ($sex == 1)
		{
			$this->db->update('man_details', $details, array('id' => $id));
		}
		else 
		{
			$this->db->update('women_details', $details, array('id' => $id));
		}
	}
	
	// предложенные девушки
	
	function getLikeLadies($age_from, $age_to)
	{
		$query = "
			SELECT *
			FROM `user_profile`
			WHERE `age` >= '{$age_from}'
			AND `age` <= '{$age_to}'
			AND `sex` = '2'
			ORDER BY rand()
			LIMIT 3
		";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() == 3)
		{
			return $query->result_array();
		}
		else
		{
			return '0';
		}
	}
	
	// добавленные в закладки
	function getFavorites($id)
	{
		$query = "
			SELECT 
				user_favorites.fav_id,
				user_profile.*
			FROM
				user_favorites
				LEFT JOIN user_profile ON user_profile.id = user_favorites.fav_id
			WHERE
				user_favorites.id = ?
			ORDER BY user_favorites.add_date desc				
		";
		$query = $this->db->query($query, array($id));
		
		if ($query->num_rows() > 0)
		{
			return array('list' => $query->result_array(), 'count' => $query->num_rows());
		}
		else
		{
			return false;
		}
	}
	
	function checkFavorite($myid, $fav_id)
	{
		$list = $this->db->get_where('user_favorites', array('id' => $myid, 'fav_id' => $fav_id))->num_rows();
		
		if ($list > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function deleteFavorite($myid, $fav_id)
	{
		$this->db->delete('user_favorites', array('id' => $myid, 'fav_id' => $fav_id));
	}
	
	// video
	
	function createNewVideo($data)
	{
		$this->db->insert('user_videos', $data);
	}
	
	function getVideoInfo($id)
	{
		$query = $this->db->get_where('user_videos', array('id' => $id));
		
		if ($query->num_rows() > 0)
		{
			return array('data' => $query->row_array(), 'count' => $query->num_rows());
		}
		else
		{
			return array('data' => '', 'count' => 0);
		}
	}
	
	function checkVideo($id, $video)
	{
		$query = $this->db->get_where('user_videos', array('id' => $id, 'video_name' => $video))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		return false;	
	}
	
	function deleteVideo($id, $video)
	{
		$this->db->delete('user_videos', array('id' => $id, 'video_name' => $video));
	}
	
	/***** удаление и восстановление аккаунта ******/
	
	function deleteProfile($id)
	{
		$this->db->update('user_profile', array('user_status' => '2'), array('id' => $id));
	}
	
	function restoreProfile($id)
	{
		$this->db->update('user_profile', array('user_status' => '0'), array('id' => $id));
	}
	
	/*********** подарки *********/
	
	function getUserInfo($id)
	{
		$query = "
			SELECT
			user_profile.*,
			women_details.*
			FROM user_profile
			LEFT JOIN women_details ON women_details.id = user_profile.id
			WHERE user_profile.id = ?
			AND user_profile.sex = '2'
		";
		
		$query = $this->db->query($query, array($id));
		
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		
		return false;
	}
	
	function sendGift($data)
	{
		$credits = $this->db->get_where('user_profile', array('id' => $data['from_id']))->row_array();
		
		if ($credits['credits'] >= $data['price'])
		{
			$this->db->insert('women_gifts', $data);
			$newCredits = $credits['credits'] - $data['price'];
			$this->db->update('user_profile', array('credits' => $newCredits), array('id' => $data['from_id']));
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// обновление пароля
	
	function setNewPassword($pwd, $user_id)
	{
		$pwd = md5($pwd);
		
		$this->db->update('user_profile', array('password' => $pwd), array('id' => $user_id));
	}
	
	function getInfoByEmail($email)
	{
		return $this->db->get_where('user_profile', array('email' => $email))->row_array();
	}
	
	/************************* ПРИГЛАШЕНИЯ *****************************/
	
	function insertInvite($data)
	{
		$this->db->insert('user_invites', $data);
	}
	
	function checkThisInvite($email, $id)
	{
		$query = $this->db->get_where('user_invites', array('from_id' => $id, 'to_email' => $email))->num_rows();
		
		if ($query > 0)
		{
			return false;
		}
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////
	// ПОСЛЕДНИЕ ПРОФИЛИ ДЕВУШЕК (3 шт.)
	
	function showLastWomenProfiles()
	{
		$query = "
			SELECT * FROM user_profile WHERE sex = '2' AND user_status = '0'
			ORDER BY id desc LIMIT 3	
		";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
}
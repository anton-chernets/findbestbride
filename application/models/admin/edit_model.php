<?php


Class Edit_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Все фотографии аккаунта
	 * @param int $user_id - ID аккаунта
	 * @return array
	 */
	
	function getUserPhoto($user_id)
	{
		$query = $this->db->get_where('user_photos', array('id' => $user_id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	/**
	 * Подробная информация аккаунта
	 * @param int $id - ID аккаунта
	 * @param int $sex - пол пользователя (1 - мужчина, 2 - девушка)
	 * @return array
	 */
	function getUserDetails($id, $sex)
	{
		if ($sex == 1)
		{
			$details = $this->db->get_where('man_details', array('id' => $id))->row_array();
		}
		else
		{
			$details = $this->db->get_where('women_details', array('id' => $id))->row_array();
		}
		
		return $details;
	}
	
	/**
	 * Удаление аватара у аккаунта
	 * @param int $id - ID аккаунта
	 * @return bool
	 */
	function deleteAvatar($id)
	{
		$this->db->update('user_profile', array('photo_link' => ''), array('id' => $id));
		
		return true;
	}
	
	/**
	 * Удаление фотографии у аккаунта
	 * @param int $id - ID аккаунта
	 * @param string $photo_name - имя файла (фотографии)
	 * @return bool
	 */
	function deletePhoto($id, $photo_name)
	{
		$this->db->delete('user_photos', array('id' => $id, 'photo_name' => $photo_name));
		
		return true;
	}
	
	/**
	 * сохранение информации профиля
	 * @param array $main - массив с обновлением имя и фамилии
	 * @param array $details - массив с обновлением подробной информации профиля
	 * @param integer $id - ID аккаунта
	 * @param integer $sex - пол пользователя (мужская и женская информация по разным таблицам)
	 */
	function changeProfileInfo($main, $details, $id, $sex)
	{
		$this->db->update('user_profile', $main, array('id' => $id));
		
		if ($sex == 1)
		{
			$this->db->update('man_details', $details, array('id' => $id));
		}
		else
		{
			$this->db->update('women_details', $details, array('id' => $id));
		}
	}
	
	function getPassportList($user_id)
	{
		$query = $this->db->get_where('user_passport', array('user_id' => $user_id));
		
		return $query->result_array();
	}
}
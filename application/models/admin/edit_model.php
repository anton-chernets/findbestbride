<?php


Class Edit_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * ��� ���������� ��������
	 * @param int $user_id - ID ��������
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
	 * ��������� ���������� ��������
	 * @param int $id - ID ��������
	 * @param int $sex - ��� ������������ (1 - �������, 2 - �������)
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
	 * �������� ������� � ��������
	 * @param int $id - ID ��������
	 * @return bool
	 */
	function deleteAvatar($id)
	{
		$this->db->update('user_profile', array('photo_link' => ''), array('id' => $id));
		
		return true;
	}
	
	/**
	 * �������� ���������� � ��������
	 * @param int $id - ID ��������
	 * @param string $photo_name - ��� ����� (����������)
	 * @return bool
	 */
	function deletePhoto($id, $photo_name)
	{
		$this->db->delete('user_photos', array('id' => $id, 'photo_name' => $photo_name));
		
		return true;
	}
	
	/**
	 * ���������� ���������� �������
	 * @param array $main - ������ � ����������� ��� � �������
	 * @param array $details - ������ � ����������� ��������� ���������� �������
	 * @param integer $id - ID ��������
	 * @param integer $sex - ��� ������������ (������� � ������� ���������� �� ������ ��������)
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
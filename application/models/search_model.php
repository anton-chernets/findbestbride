<?php

Class Search_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	/************** ALL PROFILES *****************/
	function allProfilesCount()
	{
		$this->db->where('user_status', '0');
		return $this->db->where('sex', '2')->get('user_profile')->num_rows();
	}
	
	function allMenProfilesCount()
	{
		$this->db->where('user_status', '0');
		return $this->db->where('sex', '1')->get('user_profile')->num_rows();
	}
	
	function getAllMenProfiles($start, $end)
	{
		$query = "
			SELECT
			user_profile.*,
			man_details.*
			FROM user_profile
			LEFT JOIN man_details ON man_details.id = user_profile.id
			WHERE
			user_profile.sex = '1'
			AND user_profile.user_status = '0'
			ORDER BY user_profile.last_online desc, user_profile.register_date desc
			LIMIT {$start}, {$end}
		";
		
		return $this->db->query($query)->result_array();
	}
	
	
	function getAllProfiles($start, $end)
	{
		$query = "
			SELECT
			user_profile.*,
			women_details.*
			FROM user_profile
			LEFT JOIN women_details ON women_details.id = user_profile.id
			WHERE user_profile.sex = '2' AND user_profile.user_status = '0'
			ORDER BY user_profile.last_online desc, user_profile.is_camera desc
			LIMIT {$start}, {$end}
		";
		
		return $this->db->query($query)->result_array();
	}
	
	/***************** S E A R C H *****************/
	
	function checkGender($id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$query = $query->row_array();
			
			return  $query['sex'];
		}
		
		return false;
	}
	
	function searchByAge($from, $to)
	{
		$query = "
			SELECT
			user_profile.*,
			women_details.*
			FROM user_profile
			LEFT JOIN women_details ON women_details.id = user_profile.id
			WHERE user_profile.sex = '2' 
			AND user_profile.age >= {$from}
			AND user_profile.age <= {$to}
			AND user_profile.user_status = '0'
			ORDER by last_online desc, register_date desc
		";
		
		return $this->db->query($query)->result_array();
	}
	
	function searchById($id)
	{
		$gender = $this->checkGender($id);
		
		if ($gender != false)
		{
			if ($gender == 1)
			{
				$table = 'man_details';
			}
			else
			{
				$table = 'women_details';
			}
			
			$query = "
				SELECT
				user_profile.*,
				{$table}.*
				FROM user_profile LEFT JOIN {$table} ON {$table}.id = user_profile.id
				WHERE user_profile.id = ?
				AND user_profile.user_status = '0'
			";
				
			return $this->db->query($query, array($id))->result_array();
		}
		else
		{
			return false;
		}
	}
	
	
	function startSearch($options = array(), $search_sex = 2, $limit = 1000)
	{
		$age_from = '';
		$age_to = '';
		$marital = '';
		$english = '';
		$eyes = '';
		$hair = '';
		$religion = '';
		$child = '';
		$drink = '';
		$smoke = '';
		$height_from = '';
		$height_to = '';
		$weight_from = '';
		$weight_to = '';
		$time = time();
		$online = '';
		
		// установим таблицу, по которой будем искать
		$table = $this->_set_table($search_sex);
		////////////////////////////////////////
		if ($options['age_from'])
		{
			$age_from = "AND user_profile.age >= {$options['age_from']}";
		}
		if ($options['age_to'])
		{
			$age_to = "AND user_profile.age <= {$options['age_to']}";
		}
		if ($options['marital'])
		{
			$marital = "AND {$table}.marriage = {$options['marital']}";
		}
		if ($options['english'])
		{
			$english = "AND {$table}.english = {$options['english']}";
		}
		if ($options['eyes'])
		{
			$eyes = "AND {$table}.eyes = {$options['eyes']}";
		}
		if ($options['hair'])
		{
			$hair = "AND {$table}.hair = {$options['hair']}";
		}
		if ($options['religion'])
		{
			$religion = "AND {$table}.religion = {$options['religion']}";
		}
		if ($options['child'])
		{
			$child = "AND {$table}.children = {$options['child']}";
		}
		if ($options['country'])
		{
			$drink = "AND user_profile.country = {$options['country']}";
		}
		if ($options['city'])
		{
			$smoke = "AND {$table}.city LIKE '{$options['city']}%'";
		}
		if ($options['h_from'])
		{
			$height_from = "AND {$table}.height >= {$options['h_from']}";
		}
		if ($options['h_to'])
		{
			$height_to = "AND {$table}.height <= {$options['h_to']}";
		}
		if ($options['w_from'])
		{
			$weight_from = "AND {$table}.weight >= {$options['w_from']}";
		}
		if ($options['w_to'])
		{
			$weight_to = "AND {$table}.weight <= {$options['w_to']}";
		}
		if ($options['online'] == true)
		{
			$online = "AND user_profile.last_online > {$time}";
		}

		$query = "
			SELECT
			user_profile.*,
			{$table}.*
			FROM
			user_profile
			LEFT JOIN {$table} ON {$table}.id = user_profile.id
			WHERE
			user_profile.sex = {$search_sex}
			AND user_profile.user_status = '0'
			{$age_from}
			{$age_to}
			{$marital}
			{$english}
			{$eyes}
			{$hair}
			{$religion}
			{$child}
			{$drink}
			{$smoke}
			{$height_from}
			{$height_to}
			{$weight_from}
			{$weight_to}
			{$online}
			ORDER BY user_profile.last_online desc, user_profile.register_date desc
			LIMIT {$limit}
		";
			
		return $this->db->query($query)->result_array();
	}
	
	function sendBroadcastMessage($data)
	{
		$this->db->insert('private_messages', $data);
	}
	
	private function _set_table($sex)
	{
		return ($sex == 1) ? 'man_details' : 'women_details';
	}
}
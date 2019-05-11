<?php

Class Ads_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function checkTime($time)
	{
		$query = $this->db->get('engine_ads')->row_array();
		
		if ($time >= $query['next_ads'])
		{
			return true;
		}
		
		return false;
	}
	
	function updateTime($newTime, $oldTime)
	{
		$this->db->update('engine_ads', array('last_ads' => $oldTime, 'next_ads' => $newTime));
	}
	
	function getMenList()
	{
		$query = $this->db->get_where('user_profile', array('sex' => '1', 'user_status' => '0', 'email_ads' => '1'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	/**
	 * ¬ыборка рандомных анкет дл€ мужчин
	 * @param number $limit - кол-во девушек
	 * @param bool $is_reg_sort - сортировать ли по дате регистрации
	 * @return 
	 */
	function getAdsGirls($limit = 3, $is_reg_sort = false)
	{
		$reg = '';
		if ($is_reg_sort == true)
		{
			$time = time() - (3600 * 24 * 7);
			
			$reg = 'AND register_date >= {$time}';
		}
		
		$query = "
			SELECT * from user_profile
			WHERE sex = '2'
			AND user_status = '0'
			{$reg}
			ORDER BY rand()
			LIMIT {$limit}
		";
			
		return $this->db->query($query)->result_array();
	}
}
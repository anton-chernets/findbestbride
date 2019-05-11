<?php

Class Assistant
{
	function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->lang->load('english/profile');
		$this->CI->lang->load('english/common');
		
		log_message('debug', 'Profile assistant class initialized');
	}
	
	// возвращает значение семейного положения
	function userMaritalStatus($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('profile_edit_marr_single'); break;
			case 2: $return = $this->CI->lang->line('profile_edit_marr_widowed'); break;
			case 3: $return = $this->CI->lang->line('profile_edit_marr_div'); break;
			case 4: $return = $this->CI->lang->line('profile_edit_marr_never'); break;
		}
		
		return $return;
	}
	
	// дети
	
	function userChildren($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('none'); break;
			case 2: $return = '1'; break;
			case 3: $return = '2'; break;
			case 4: $return = '3'; break;
			case 5: $return = '4'; break;
			case 6: $return = '5'; break;
		}
		
		return $return;
	}
	
	// глаза
	function userEyes($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('profile_edit_eyes_g'); break;
			case 2: $return = $this->CI->lang->line('profile_edit_eyes_gr'); break;
			case 3: $return = $this->CI->lang->line('profile_edit_eyes_h'); break;
			case 4: $return = $this->CI->lang->line('profile_edit_eyes_br'); break;
			case 5: $return = $this->CI->lang->line('profile_edit_eyes_bl'); break;
			case 6: $return = $this->CI->lang->line('profile_edit_eyes_b'); break;
		}
		
		return $return;
	}
	
	// волосы
	function userHair($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('profile_edit_hair_aub'); break;
			case 2: $return = $this->CI->lang->line('profile_edit_hair_bl'); break;
			case 3: $return = $this->CI->lang->line('profile_edit_hair_blon'); break;
			case 4: $return = $this->CI->lang->line('profile_edit_hair_lb'); break;
			case 5: $return = $this->CI->lang->line('profile_edit_hair_db'); break;
			case 6: $return = $this->CI->lang->line('profile_edit_hair_red'); break;
			case 7: $return = $this->CI->lang->line('profile_edit_hair_wg'); break;
		}
		
		return $return;
	}
	
	// регилия
	
	function userReligion($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('profile_edit_rel_ch'); break;
			case 2: $return = $this->CI->lang->line('profile_edit_rel_bud'); break;
			case 3: $return = $this->CI->lang->line('profile_edit_rel_cat'); break;
			case 4: $return = $this->CI->lang->line('profile_edit_rel_jew'); break;
			case 5: $return = $this->CI->lang->line('profile_edit_rel_mus'); break;
			case 6: $return = $this->CI->lang->line('profile_edit_rel_hin'); break;
			case 7: $return = $this->CI->lang->line('profile_edit_rel_none'); break;
			case 8: $return = $this->CI->lang->line('profile_edit_rel_other'); break;
		}
		return $return;
	}
	
	// образование
	function userEdu($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('profile_edit_edu_ss'); break;
			case 2: $return = $this->CI->lang->line('profile_edit_edu_hs'); break;
			case 3: $return = $this->CI->lang->line('profile_edit_edu_col'); break;
			case 4: $return = $this->CI->lang->line('profile_edit_edu_uni'); break;
			case 5: $return = $this->CI->lang->line('profile_edit_edu_doc'); break;
			case 6: $return = $this->CI->lang->line('profile_edit_edu_still'); break;
		}
		return $return;
	}
	
	// smoke & drink
	
	function userSmokeDrink($status = 0)
	{
		switch ($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('yes'); break;
			case 2: $return = $this->CI->lang->line('no'); break;
		}
		
		return $return;
	}
	
	// english
	function userEnglish($status = 0)
	{
		switch($status)
		{
			case 0: $return = $this->CI->lang->line('profile_prev_no_info'); break;
			case 1: $return = $this->CI->lang->line('profile_edit_eng_ns'); break;
			case 2: $return = $this->CI->lang->line('profile_edit_eng_wd'); break;
			case 3: $return = $this->CI->lang->line('profile_edit_eng_bg'); break;
			case 4: $return = $this->CI->lang->line('profile_edit_eng_f'); break;
		}
		
		return $return;
	}
}
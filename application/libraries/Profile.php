<?php

Class Profile
{
	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->lang->load('english/profile');
	}
	
	function createHairColor($selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => $this->CI->lang->line('profile_edit_hair_aub'),
				'2'	=> $this->CI->lang->line('profile_edit_hair_bl'),
				'3'	=> $this->CI->lang->line('profile_edit_hair_blon'),
				'4'	=> $this->CI->lang->line('profile_edit_hair_lb'),
				'5'	=> $this->CI->lang->line('profile_edit_hair_db'),
				'6' => $this->CI->lang->line('profile_edit_hair_red'),
				'7' => $this->CI->lang->line('profile_edit_hair_wg')
		);
	
		return $list[$selected];
	}
	
	function createEyesColor($selected = 0)
	{
		$types = array (
				'0'	=> '',
				'1' => $this->CI->lang->line('profile_edit_eyes_g'),
				'2'	=> $this->CI->lang->line('profile_edit_eyes_gr'),
				'3' => $this->CI->lang->line('profile_edit_eyes_h'),
				'4' => $this->CI->lang->line('profile_edit_eyes_br'),
				'5' => $this->CI->lang->line('profile_edit_eyes_bl'),
				'6' => $this->CI->lang->line('profile_edit_eyes_b')
		);
	
		return $types[$selected];
	}
	
	function createReligion($selected = 0)
	{
		$list = array
		(
				'0' => '',
				'1' => $this->CI->lang->line('profile_edit_rel_ch'),
				'2' => $this->CI->lang->line('profile_edit_rel_bud'),
				'3' => $this->CI->lang->line('profile_edit_rel_cat'),
				'4'	=> $this->CI->lang->line('profile_edit_rel_jew'),
				'5' => $this->CI->lang->line('profile_edit_rel_mus'),
				'6' => $this->CI->lang->line('profile_edit_rel_hin'),
				'7' => $this->CI->lang->line('profile_edit_rel_none'),
				'8' => $this->CI->lang->line('profile_edit_rel_other')
		);
	
		return $list[$selected];
	}
	
	function createEducationLevel($selected = 0)
	{
		$types = array (
				'0'	=> '',
				'1' => $this->CI->lang->line('profile_edit_edu_ss'),
				'2'	=> $this->CI->lang->line('profile_edit_edu_hs'),
				'3'	=> $this->CI->lang->line('profile_edit_edu_col'),
				'4' => $this->CI->lang->line('profile_edit_edu_uni'),
				'5' => $this->CI->lang->line('profile_edit_edu_doc'),
				'6' => $this->CI->lang->line('profile_edit_edu_still')
		);
	
		return $types[$selected];
	}
	
	function createMarriage($selected = 0)
	{
		$types = array (
				'0' => '',
				'1' => $this->CI->lang->line('profile_edit_marr_single'),
				'2' => $this->CI->lang->line('profile_edit_marr_widowed'),
				'3' => $this->CI->lang->line('profile_edit_marr_div'),
				'4' => $this->CI->lang->line('profile_edit_marr_never')
		);
	
		return $types[$selected];
	}
	
	function createChildren($selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => $this->CI->lang->line('none'),
				'2'	=> '1',
				'3' => '2',
				'4' => '3',
				'5' => '4',
				'6' => '5'
		);
	
		return $list[$selected];
	}
	
	function createEnglish($selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => $this->CI->lang->line('profile_edit_eng_ns'),
				'2' => $this->CI->lang->line('profile_edit_eng_wd'),
				'3' => $this->CI->lang->line('profile_edit_eng_bg'),
				'4' => $this->CI->lang->line('profile_edit_eng_f')
		);
	
		return $list[$selected];
	}
	
	function createHeight($selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => "4'7'' - 4'9'' (140-145 cm)",
				'2' => "4'10'' - 4'11'' (146-150 cm)",
				'3' => "5'0'' - 5'1'' (151-155 cm)",
				'4' => "5'2'' - 5'3'' (156-160 cm)",
				'5' => "5'4'' - 5'5'' (161-165 cm)",
				'6' => "5'6'' - 5'7'' (166-170 cm)",
				'7' => "5'8'' - 5'9'' (171-175 cm)",
				'8' => "5'10'' - 5'11'' (176-180 cm)",
				'9' => "6'0'' - 6'1'' (181-185 cm)",
				'10'=> "6'2'' - 6'3'' (186-190 cm)",
				'11'=> "6'4'' (191 cm) or above"
		);
	
		return $list[$selected];
	}
	
	function createWeight($selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => '45 kg 99 lbs - 50 kg 110 lbs',
				'2' => '50 kg 110 lbs - 55 kg 121 lbs',
				'3' => '55 kg 121 lbs - 60 kg 132 lbs',
				'4' => '60 kg 132 lbs - 65 kg 143 lbs',
				'5' => '65 kg 143 lbs - 70 kg 154 lbs',
				'6' => '70 kg 154 lbs - 75 kg 165 lbs',
				'7' => '75 kg 165 lbs - 80 kg 176 lbs',
				'8' => '80 kg 176 lbs - 85 kg 187 lbs',
				'9' => '85 kg 187 lbs - 90 kg 198 lbs',
				'10'=> '90 kg 198 lbs - 95 kg 209lbs',
				'11'=> '95 kg 209 lbs - 100 kg 220 lbs',
				'12'=> '100 kg 220 lbs - 105 kg 231 lbs',
				'13'=> '105 kg 231 lbs - 110 kg 240 lbs',
				'14'=> '110 kg 240 lbs - 115 kg 254 lbs',
				'15'=> '115 kg 254 lbs - 120 kg 256 lbs',
				'16'=> '120 kg 256 lbs - 125 kg 276 lbs',
				'17'=> '125 kg 276 lbs - 130 kg 287 lbs',
				'18'=> '130 kg 287 lbs - 135 kg 298 lbs',
				'19'=> '135 kg 298 lbs - 140 kg 309 lbs',
				'20'=> '140 kg 309 lbs - 145 kg 320 lbs',
				'21'=> '145 kg 320 lbs - 150 kg 331 lbs'
		);
	
		return $list[$selected];
	}
	
	function createSmokingDrinking($selected = 0)
	{
		$list = array (
				'0' => '',
				'1' => $this->CI->lang->line('yes'),
				'2' => $this->CI->lang->line('no')
		);
	
		return $list[$selected];
	}
}
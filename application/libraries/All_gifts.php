<?php

Class All_gifts
{
	function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->lang->load('english/profile');
		
		log_message('debug', 'Help Gifts class initialized');
	}
	
	function returnGiftName($gift_id)
	{
		switch ($gift_id)
		{
			case 1:
				return $this->CI->lang->line('gift_rose');
				break;
			case 2:
				return $this->CI->lang->line('gift_rose2');
				break;
			case 3:
				return $this->CI->lang->line('gift_rose3');
				break;
			case 4:
				return $this->CI->lang->line('gift_rose4');
				break;
			case 5:
				return $this->CI->lang->line('gift_chry');
				break;
			case 6:
				return $this->CI->lang->line('gift_gerbera');
				break;
			case 7:
				return $this->CI->lang->line('gift_orchi');
				break;
			case 8:
				return $this->CI->lang->line('gift_fruit');
				break;
			case 9:
				return $this->CI->lang->line('gift_cake');
				break;
			case 10:
				return $this->CI->lang->line('gift_coffee');
				break;
			case 11:
				return $this->CI->lang->line('gift_candy');
				break;
			case 12:
				return $this->CI->lang->line('gift_cup');
				break;
			case 13:
				return $this->CI->lang->line('gift_toy1');
				break;
			case 14:
				return $this->CI->lang->line('gift_toy2');
				break;
			case 15:
				return $this->CI->lang->line('gift_perf');
				break;
			case 16:
				return $this->CI->lang->line('gift_spa');
				break;
			case 17:
				return $this->CI->lang->line('gift_cosm');
				break;
			case 18:
				return $this->CI->lang->line('gift_wear');
				break;
			case 19:
				return $this->CI->lang->line('gift_photo');
				break;
			case 20:
				return $this->CI->lang->line('gift_phone');
				break;
			case 21:
				return $this->CI->lang->line('gift_note');
				break;
			case 22:
				return $this->CI->lang->line('gift_gold');
				break;
			case 23:
				return $this->CI->lang->line('gift_eng');
				break;
			case 24:
				return $this->CI->lang->line('gift_spec');
				break;
		}
	}
	
	
	function returnGiftCount($type, $count = 0)
	{
		$return = '';
		
		if ($type == 15)
		{
			if ($count == 50)
			{
				$return = '<br/>50 ml';
			}
			elseif ($count == 100)
			{
				$return = '<br/>100 ml';
			}
		}
		
		if ($type == 22)
		{
			if ($count == 1)
			{
				$return = '<br/>Heart shaped pendant';
			}
			elseif ($count == 2)
			{
				$return = '<br/>Bracelet';
			}
			elseif ($count == 3)
			{
				$return = '<br/>Chain';
			}
			elseif ($count == 4)
			{
				$return = '<br/>Bracelet, chain and heart shaped pendant';
			}
		}
		
		elseif ($type != 15 && $type != 22) 
		{
			if ($count > 0)
			{
				$return = '<br/>' .$count . ' flowers';
			}
		}
		
		return $return;
	}
}
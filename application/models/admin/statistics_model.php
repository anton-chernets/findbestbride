<?php

Class Statistics_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/************************************************************************
	 * СТАТИСТИКА НА ГЛАВНОЙ СТРАНИЦЕ
	 */
	
	/**
	 * общее количество пользователей
	 * @return integer количество
	 */
	function getAllUsersCount()
	{
		return $this->db->get('user_profile')->num_rows();
	}
	
	/**
	 * общее количество записанных логов
	 * @return integer
	 */
	function getAllLogs()
	{
		return $this->db->get('user_logs')->num_rows();
	}
	
	/**
	 * общее количество покупок
	 * @return integer
	 */
	
	function getAllPays()
	{
		return $this->db->get('user_payments')->num_rows();
	}
	
	/**
	 * общее количество начислений партнерам за все время
	 * @return integer
	 */
	
	function getAllFinance()
	{
		$query = $this->db->get('partner_money');
	
		if ($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result_array() as $row)
			{
				$i += $row['m_price'];
			}
				
			return $i;
		}
	
		return 0;
	}
	
	/**
	 * последние 5 начислений партнерам
	 * @return array начисления
	 * @return bool false если начислений нет
	 */
	function getLastFinance()
	{
		$this->db->order_by('m_date', 'desc');
		$this->db->limit(5);
		$query = $this->db->get('partner_money');
	
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	
		return false;
	}
	
	/**
	 * последние 5 пользователей
	 * @return array
	 * @return boolean false если пользователей нет
	 */ 
	function getLastUsers()
	{
		$query = "
			SELECT user_profile.*
			FROM user_profile ORDER BY register_date desc LIMIT 5
		";
	
		$query = $this->db->query($query);
	
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	
		return false;
	}
	
	/**
	 * последние 5 записей в журнале событий
	 * @return array
	 * @return boolean false если журнал пуст
	 */
	function getLastLogs()
	{
		$this->db->order_by('log_date', 'desc');
		$this->db->limit(5);
		$query = $this->db->get('user_logs');
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	/**
	 * последние 5 покупок
	 * @return array
	 */
	function getLastPays()
	{
		$this->db->order_by('order_id', 'desc');
		$this->db->limit(5);
		$query = $this->db->get('user_payments');

		return $query->result_array();
	}
	
	////////////////////////////////////////////////////////////////////////
	// СТАТИСТИКА
	
	function setDate($type)
	{
		$time = time();
		
		if ($type == 2)
		{
			$return = $time - (3600 * 24 * 30);
		}
		elseif ($type == 3)
		{
			$return = $time - (3600 * 24 * 7);
		}
		elseif ($type == 4)
		{
			$return = $time - (3600 * 24);
		}
		
		return array('now' => $time, 'date' => $return);
	}
	
	function getRegister($type)
	{
		if($type > 1) $date = $this->setDate($type);
		
		if ($type == 1)
		{
			$total = $this->db->get('user_profile')->num_rows();
			$men = $this->db->get_where('user_profile', array('sex' => '1'))->num_rows();
			$women = $total - $men;
		}
		else
		{
			$total = $this->db->get_where('user_profile', array('register_date >=' => $date['date']))->num_rows();
			$men = $this->db->get_where('user_profile', array('register_date >=' => $date['date']))->num_rows();
			$women = $this->db->get_where('user_profile', array('register_date >=' => $date['date']))->num_rows();
		}
		
		return array('total' => $total, 'men' => $men, 'women' => $women);
	}
	
	function getMessages($type)
	{
		if ($type > 1) $date = $this->setDate($type);
		
		if ($type == 1)
		{
			$msg = $this->db->get('private_messages')->num_rows();
			$attach = $this->db->get_where('private_messages', array('attachment !=' => ''))->num_rows();
		}
		else
		{
			$msg = $this->db->get_where('private_messages', array('msg_date >=' => $date['date']))->num_rows();
			$attach = $this->db->get_where('private_messages', array('msg_date >=' => $date['date'], 'attachment !=' => ''))->num_rows();
		}
		
		return array('total' => $msg, 'attach' => $attach);
	}
	
	function getChat($type)
	{
		if ($type > 1) $date = $this->setDate($type);
		
		if ($type == 1)
		{
			$chat = $this->db->get('user_chat')->num_rows();
			$msg = $this->db->get('user_chat_messages')->num_rows();
		}
		else
		{
			$chat = $this->db->get_where('user_chat', array('end_time >=' => $date['date']))->num_rows();
			$msg = $this->db->get_where('user_chat_messages', array('message_date >=' => $date['date']))->num_rows();
		}
		
		return array('total' => $chat, 'msg' => $msg);
	}
	
	function getPhotoVideo($type)
	{
		if ($type > 1) $date = $this->setDate($type);
		
		if ($type == 1)
		{
			$photo = $this->db->get('user_photos')->num_rows();
			$video = $this->db->get('user_videos')->num_rows();
		}
		else
		{
			$photo = $this->db->get_where('user_photos', array('upload_date >=' => $date['date']))->num_rows();
			$video = $this->db->get_where('user_videos', array('add_date >=' => $date['date']))->num_rows();
		}
		
		return array('ph' => $photo, 'vid' => $video);
	}
	
	function getGifts($type)
	{
		if ($type > 1) $date = $this->setDate($type);
		
		if ($type == 1)
		{
			$gift = $this->db->get('women_gifts')->num_rows();
			$rt = $this->db->get('rt_request')->num_rows();
		}
		else
		{
			$gift = $this->db->get_where('women_gifts', array('add_date >=' => $date['date']))->num_rows();
			$rt = $this->db->get_where('rt_request', array('date >=' => $date['date']))->num_rows();
		}
		
		return array('rt' => $rt, 'g' => $gift);
	}
	
	function getCredits($type)
	{
		if ($type > 1) $date = $this->setDate($type);
		
		if ($type == 1)
		{
			$cred = $this->db->get('user_payments')->num_rows();
			$luck = $this->db->get_where('user_payments', array('order_status' => '1'))->num_rows();
		}
		else
		{
			$cred = $this->db->get_where('user_payments', array('order_date >=' => $date['date']))->num_rows();
			$luck = $this->db->get_where('user_payments', array('order_date >=' => $date['date'], 'order_status' => '1'))->num_rows();
		}
		
		return array('total' => $cred, 'luck' => $luck);
	}
	
	function getLogs($type)
	{
		return $this->db->get('user_logs')->num_rows();
	}
	
	function getPartner($type)
	{
		if ($type > 1) $date = $this->setDate($type);
		
		$total = $this->db->get('user_partner')->num_rows();
		
		if ($type == 1)
		{
			$add = $this->db->get('partner_money')->num_rows();
			$minus = $this->db->get('partner_penalty')->num_rows();
			$anket = $this->db->get_where('user_profile', array('is_agency !=' => '0'))->num_rows();
			$tp = $this->db->get('support_tickets')->num_rows();
			$tour = $this->db->get('romance_tours')->num_rows();
		}
		else
		{
			$add = $this->db->get_where('partner_money', array('m_date >=' => $date['date']))->num_rows();
			$minus = $this->db->get_where('partner_penalty', array('add_date >=' => $date['date']))->num_rows();
			$anket = $this->db->get_where('user_profile', array('is_agency !=' => '0', 'register_date >=' => $date['date']))->num_rows();
			$tp = $this->db->get_where('support_tickets', array('date >=' => $date['date']))->num_rows();
			$tour = $this->db->get_where('romance_tours', array('add_date >=' => $date['date']))->num_rows();
		}
		
		return array('total' => $total, 'add' => $add, 'penalty' => $minus, 'ankets' => $anket, 'tp' => $tp, 'tour' => $tour);
	}
}
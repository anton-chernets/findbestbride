<?php

Class Partner_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	

	///////////////////////////////////////////
	// �������
	
	function getNewsForPartners()
	{
		$query = "
			SELECT
			*
			FROM user_partner_news
			WHERE 
			is_show = '1'
			ORDER BY news_id desc
			LIMIT 30
		";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	/////////////////////////////////////////////////
	// ���������� ������� 
	
	function updateInformation($data, $id)
	{
		$this->db->update('user_partner', $data, array('id' => $id));
	}
	
	
	///////////////////////////////////////////////////////////
	// СООБЩЕНИЯ
	
	// главная страница сообщений
	
	function allPartnerMessages($p_id)
	{
		$query = "
			SELECT * from user_partner_messages WHERE to_id = ? AND is_deleted != '1' ORDER by msg_date desc
		";
		
		$query = $this->db->query($query, array($p_id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// проверка этого ли пользователя сообщение
	
	function checkMessage($p_id, $hash)
	{
		$query = $this->db->get_where('user_partner_messages', array('hash' => $hash, 'to_id' => $p_id))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	// удаление сообщения
	
	function deleteMessage($hash, $p_id)
	{
		if ($this->checkMessage($p_id, $hash) != false)
		{
			$this->db->update('user_partner_messages', array('is_deleted' => '1'), array('hash' => $hash));
			return true;
		}
	}
	
	// отметка как прочитанное
	
	function markMessage($hash, $p_id)
	{
		if ($this->checkMessage($p_id, $hash) != false)
		{
			$this->db->update('user_partner_messages', array('is_read' => '1'), array('hash' => $hash));
			return true;
		}
	}
	
	// чтение
	
	function readMessage($hash, $p_id)
	{
		$msg = $this->db->get_where('user_partner_messages', array('hash' => $hash))->row_array();
		
		if ($msg['is_read'] == '0')
		{
			$this->markMessage($hash, $p_id);
		}
		
		return $msg;
	}
	
	////////////////////////////////////////////////////////////
	// ПОДАРКИ
	
	function agencyGifts($p_id)
	{
		$query = "
			SELECT 
			partner_gifts.*,
			women_gifts.*
			FROM
			partner_gifts
			LEFT JOIN women_gifts ON women_gifts.gift_hash = partner_gifts.gift_hash
			WHERE
			partner_gifts.p_id = ?
			ORDER BY women_gifts.add_date desc
		";
		
		$query = $this->db->query($query, array($p_id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function checkGiftByHash($hash, $p_id)
	{
		$query = $this->db->get_where('partner_gifts', array('p_id' => $p_id, 'gift_hash' => $hash))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function getGiftInfo($hash)
	{
		return $this->db->get_where('women_gifts', array('gift_hash' => $hash))->row_array();
	}
	
	function approveGift($data)
	{
		$this->db->insert('gifts_wait_approve', $data);
		$this->db->update('women_gifts', array('status' => '2'), array('gift_hash' => $data['gift_hash']));
	}
	
	/////////////////////////////////////////////////////
	// ФИНАНСЫ
	
	// штрафы
	
	function agencyPenalty($p_id)
	{
		$time = time();
		$day = date('d');
		$byLastMonth = $time - (3600 * 24 * $day);
		
		$this->db->order_by('add_date', 'desc');
		$query = $this->db->get_where('partner_penalty', array('p_id' => $p_id, 'add_date >=' => $byLastMonth));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// архив штрафов
	
	function agencyPenaltyArchive($p_id)
	{
		$time = time();
		$nowDay = date('d');
		$search = $time - (3600 * 24 * $nowDay);
		
		$this->db->order_by('add_date', 'desc');
		$query = $this->db->get_where('partner_penalty', array('p_id' => $p_id, 'add_date <' => $search));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// начисления
	
	function agencyMoney($p_id, $startTime)
	{
		$this->db->order_by('m_date', 'desc');
		
		$query = $this->db->get_where('partner_money', array('partner_id' => $p_id, 'm_date >=' => $startTime));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// архив начислений
	
	function agencyMoneyArchive($p_id, $endTime)
	{
		$this->db->order_by('m_date', 'desc');
		
		$query = $this->db->get_where('partner_money', array('partner_id' => $p_id, 'm_date <' => $endTime));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	///////////////////////////////////////////////////////
	// АНКЕТЫ
	
	// анкеты в ожидании
	function waitAnkets($p_id)
	{
		$this->db->order_by('register_date', 'desc');
		$query = $this->db->get_where('user_profile', array('is_agency' => $p_id, 'user_status' => '3'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function cancelApprove($id, $p_id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $id))->row_array();
		
		if ($query['is_agency'] == $p_id && $query['user_status'] == 3)
		{
			$this->db->update('user_profile', array('user_status' => '1'), array('id' => $id));
			return true;
		}
	}
	
	
	// отключенные анкеты
	function inactiveAnkets($p_id)
	{
		$this->db->order_by('register_date', 'desc');
		$query = $this->db->get_where('user_profile', array('is_agency' => $p_id, 'user_status' => '1'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function addToApprove($w_id, $p_id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $w_id))->row_array();
		
		if ($query['is_agency'] == $p_id && $query['user_status'] == 1)
		{
			$this->db->update('user_profile', array('user_status' => '3'), array('id' => $w_id));
			return true;
		}
		
		return false;
	}
	
	// активные анкеты
	function activeAnkets($p_id)
	{
		$this->db->order_by('register_date', 'desc');
		
		$query = $this->db->get_where('user_profile', array('is_agency' => $p_id, 'user_status' => '0'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// анкеты онлайн
	function onlineAnkets($p_id)
	{
		$time = time();
		$this->db->order_by('register_date', 'desc');
		
		$query = $this->db->get_where('user_profile', array('is_agency' => $p_id, 'user_status' => '0', 'last_online >=' => $time));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function disableAnket($w_id, $p_id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $w_id))->row_array();
		
		if ($query['is_agency'] == $p_id && $query['user_status'] == 0)
		{
			$this->db->update('user_profile', array('user_status' => '1'), array('id' => $w_id));
			return true;
		}
	}
	
	// все анкеты
	function allAnkets($p_id)
	{
		$this->db->order_by('register_date', 'desc');
		
		$query = $this->db->get_where('user_profile', array('is_agency' => $p_id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// новая анкета
	
	function insertNewUser($data, $passports = array())
	{
		$this->db->insert('user_profile', $data);
		$id = $this->db->insert_id();
		
		$this->db->insert('women_details', array('id' => $id));
		
		$this->db->insert('user_passport', array('user_id' => $id, 'passport' => $passports[0] . '.jpg'));
		//$this->db->insert('user_passport', array('user_id' => $id, 'passport' => $passports[1] . '.jpg'));
		//$this->db->insert('user_passport', array('user_id' => $id, 'passport' => $passports[2] . '.jpg'));
	}
	
	
	///////////////////////////////////////////
	// романтические туры
	
	// новый тур
	// загрузка фото
	
	function addTourImage($data)
	{
		$this->db->insert('user_partner_images', $data);
	}
	
	// добавление нового тура
	
	function addNewTour($data)
	{
		$this->db->insert('romance_tours', $data);
	}
	
	// все туры данного агенства
	
	function getAgencyTours($p_id)
	{
		$query = $this->db->get_where('romance_tours', array('p_id' => $p_id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// только активные либо не активные туры
	// $type = 1 -- активные туры; $type = 2 -- не активные
	
	function getAgencyActiveTours($p_id, $type = 1)
	{
		if ($type == 1)
		{	
			$query = $this->db->get_where('romance_tours', array('p_id' => $p_id, 'status' => $type));
		}
		elseif ($type == 2)
		{
			$this->db->where('p_id', $p_id);
			$this->db->where('status', '2');
			$this->db->or_where('status', '0');
			
			$query = $this->db->get('romance_tours');
		}
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// кол-во фотографий на данном туре
	
	function tourPhotoCount($tour_id)
	{
		return $this->db->get_where('user_partner_images', array('tour_id' => $tour_id))->num_rows();
	}
	
	function checkAgencyTour($tour_id, $p_id)
	{
		$query = $this->db->get_where('romance_tours', array('tour_id' => $tour_id, 'p_id' => $p_id))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function setActiveTour($tour_id, $p_id)
	{
		if ($this->checkAgencyTour($tour_id, $p_id) != false)
		{
			$this->db->update('romance_tours', array('status' => '0'), array('tour_id' => $tour_id));
			
			return true;
		}
	}
	
	function setDeactiveTour($tour_id, $p_id)
	{
		if ($this->checkAgencyTour($tour_id, $p_id) != false)
		{
			$this->db->update('romance_tours', array('status' => '2'), array('tour_id' => $tour_id));
			
			return true;
		}
	}
	
	function agencyTourInfo($tour_id)
	{
		return $this->db->get_where('romance_tours', array('tour_id' => $tour_id))->row_array();
	}
	
	function tourPhoto($id, $type)
	{
		$query = $this->db->get_where('user_partner_images', array('tour_id' => $id, 'photo_type' => $type));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return array();
	}
	
	function changeTour($data, $tour_id, $p_id)
	{
		$this->db->update('romance_tours', $data, array('tour_id' => $tour_id, 'p_id' => $p_id));
	}
}
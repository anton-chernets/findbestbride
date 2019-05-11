<?php

Class Messages_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/****** И С Х О Д Я Щ И Е *******/
	function outboxCount($user_id)
	{
		return $this->db->get_where('private_messages', array('from_user_id' => $user_id, 'hide_for_sender !=' => '0'))->num_rows();
	}
	
	function getOutboxMessages($user_id, $start, $end)
	{
		$query = "
			SELECT
			private_messages.*,
			user_profile.name,
			user_profile.photo_link as photo
			FROM
			private_messages
			LEFT JOIN user_profile ON user_profile.id = private_messages.to_user_id
			WHERE
			private_messages.from_user_id = ?
			AND private_messages.hide_for_sender != '1'
			ORDER by private_messages.msg_date desc
			LIMIT {$start}, {$end}
		";
		
		return $this->db->query($query, array($user_id))->result_array();
	}
	
	/***** В Х О Д Я Щ И Е *******/
	function getInboxMessages($user_id, $start, $end)
	{
		$query = "
			SELECT 
			private_messages.*,
			user_profile.name,
			user_profile.photo_link as photo
			FROM 
			private_messages
			LEFT JOIN user_profile ON user_profile.id = private_messages.from_user_id
			WHERE 
			private_messages.to_user_id = ?
			AND private_messages.hide_for_user != '1'
			ORDER BY private_messages.msg_date desc
			LIMIT {$start}, {$end}
		";
		
		return $this->db->query($query, array($user_id))->result_array();
	}
	
	function inboxCount($user_id)
	{
		return $this->db->get_where('private_messages', array('to_user_id' => $user_id, 'hide_for_user !=' => '1'))->num_rows();
	}
	
	/****************** ОТ АДМИНИСТРАЦИИ ******************/
	function adminMsgCount($user_id)
	{
		return $this->db->get_where('private_messages', array('to_user_id' => $user_id, 'msg_type' => '1', 'hide_for_user !=' => '1'))->num_rows();
	}
	
	function getAdminMessages($user_id, $start, $end)
	{
		$query = "
			SELECT
			*
			FROM
			private_messages
			WHERE
			to_user_id = ?
			AND msg_type = '1'
			AND hide_for_user != '1'
			ORDER BY msg_date desc
			LIMIT {$start}, {$end}
		";

		return $this->db->query($query, array($user_id))->result_array();
	}
	
	// проверка этого ли юзера сообщение
	function isUserMsg($msg_id, $user_id)
	{
		$query = $this->db->get_where('private_messages', array('to_user_id' => $user_id, 'msg_id' => $msg_id))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	// проверка этот ли юзер отправил это сообщение
	function isUserOutbox($msg_id, $user_id)
	{
		$query = $this->db->get_where('private_messages', array('from_user_id' => $user_id, 'msg_id' => $msg_id))->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	// отметка как прочитанное
	function markMessageRead($msg_id, $user_id)
	{
		if ($this->isUserMsg($msg_id, $user_id) === true)
		{
			$this->db->update('private_messages', array('is_read' => '1'), array('msg_id' => $msg_id, 'to_user_id' => $user_id));
			
			return true;
		}
		
		return false;
	}
	
	// удаление сообщения
	function deleteMessage($msg_id, $user_id)
	{
		if ($this->isUserMsg($msg_id, $user_id) === true)
		{
			$this->db->update('private_messages', array('hide_for_user' => '1'), array('msg_id' => $msg_id, 'to_user_id' => $user_id));
		}
	}
	
	// удаление из исходящих
	
	function deleteMyMessage($msg_id, $user_id)
	{
		if ($this->isUserOutbox($msg_id, $user_id) === true)
		{
			$this->db->update('private_messages', array('hide_for_sender' => '1'), array('msg_id' => $msg_id, 'from_user_id' => $user_id));
			return true;
		}
		
		return false;
	}
	
	// прочитка сообщения. если еще не отмечено как прочитанное - отмечаем
	
	function getMessage($msg_id, $user_id)
	{
		if ($this->isUserMsg($msg_id, $user_id) === true)
		{
			$query = "
				SELECT
				private_messages.*,
				user_profile.name,
				user_profile.photo_link as photo
				FROM
				private_messages
				LEFT JOIN user_profile ON user_profile.id = private_messages.from_user_id
				WHERE
				private_messages.to_user_id = ?
				AND private_messages.msg_id = ?
			";
			
			$result = $this->db->query($query, array($user_id, $msg_id))->row_array();
			
			if ($result['is_read'] == '0')
			{
				$this->db->update('private_messages', array('is_read' => '1'), array('msg_id' => $msg_id));
			}
			
			return $result;
		}
		
		return false;
	}
	
	// чтение своего исходящего сообщения
	function getMyMessage($msg_id, $user_id)
	{
		if ($this->isUserOutbox($msg_id, $user_id) != false)
		{
			$query = "
				SELECT
				private_messages.*,
				user_profile.name,
				user_profile.photo_link as photo
				FROM
				private_messages
				LEFT JOIN user_profile ON user_profile.id = private_messages.to_user_id
				WHERE
				private_messages.from_user_id = ?
				AND private_messages.msg_id = ?
			";
			
			return $this->db->query($query, array($user_id, $msg_id))->row_array();
		}
		
		return false;
	}
	
	// отправка нового сообщения или ответа
	
	function sendNewMessage($data)
	{
		$this->db->insert('private_messages', $data);
	}
	
	// начислялись ли деньги партнеру за ответ на это сообщение
	function is_replayed($msg_id)
	{
		$query = $this->db->query("SELECT is_replayed FROM private_messages WHERE msg_id = '{$msg_id}'")->row_array();
		
		if ($query['is_replayed'] == 1)
		{
			return true;
		}
		
		return false;
	}
	
	function makeReplayed($msg_id)
	{
		$this->db->update('private_messages', array('is_replayed' => '1'), array('msg_id' => $msg_id));
	}
}
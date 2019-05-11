<?php

Class Chat_model extends CI_Model
{	
	// ����� ����������� � ���
	function createNewAction($data)
	{
		$this->db->insert('user_chat_invite', $data);
	}
	
	function addChatIfMultichat($id, $c_name)
	{
		$query = $this->db->query("SELECT is_multichat FROM user_profile WHERE id = '{$id}'");
		$row = $query->row_array();
		
		if ($row['is_multichat'] == 1)
		{
			$this->createChatRoom($c_name);
			$this->acceptChatInvite($c_name);
		}
	}
	
	// �������� ��� �������� ������
	function checkAnswer($c_name)
	{
		$query = $this->db->get_where('chat_invites', array('chat_name' => $c_name))->row_array();
		$time = time();
		
		if ($query['end_chat_time'] > $time)
		{
			if ($query['ready_to'] == '1')
			{
				return 'success';
			}
			elseif ($query['ready_to'] == '2')
			{
				return 'decline';
			}
			else
			{
				return 'loading';
			}
		}
		else
		{
			return 'timeout';
		}
	}
	
	function getProfile($user_id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $user_id));
		
		return $query->row_array();
	}
	
	function getChatHistory($user_id)
	{
		$return = array();
		$time = time();
		
		$query = $this->db->query("SELECT DISTINCT a.*, b.id, b.name, b.photo_link, b.last_online FROM user_chat a LEFT JOIN user_profile b ON a.user_1 = b.id OR a.user_2 = b.id
					
                        WHERE (a.user_1 = '{$user_id}' OR a.user_2 = '{$user_id}') AND b.id != '{$user_id}' GROUP BY b.id ORDER BY b.last_online DESC")->result_array();
				
		return $query;
	}
	
	public function getOldMessages($room)
	{
		$info = $this->getChatInfo($room);
		
		$tm = time() - (3600 * 24 * 7);
		
		$query = $this->db->query('SELECT a.*, b.name FROM user_chat_messages a INNER JOIN user_profile b ON a.from_id = b.id WHERE ((a.from_id = '.$info['user_1'].' AND a.to_id = '.$info['user_2'].') OR (a.from_id = '.$info['user_2'].' AND a.to_id = '.$info['user_1'].')) AND message_date >= "'.$tm.'" ORDER BY message_date ASC')->result_array();
		
		return $query;
	}
	
	public function getOldMessages2($user, $my)
	{
		
		$tm = time() - (3600 * 24 * 7);
		
		$query = $this->db->query('SELECT a.*, b.name FROM user_chat_messages a INNER JOIN user_profile b ON a.from_id = b.id WHERE ((a.from_id = '.$user.' AND a.to_id = '.$my.') OR (a.from_id = '.$my.' AND a.to_id = '.$user.')) AND message_date >= "'.$tm.'" ORDER BY message_date ASC')->result_array();
		
		return $query;
	}
	
	// �������� �� ���
	
	function checkInviteToChat($id, $showed = false)
	{
		$s = ($showed == true) ? ' AND showed = 0' : '';
		
		$time = time();
		$query = "
			SELECT
			a.*,
			user_profile.name, user_profile.photo_link, user_profile.id, user_profile.age
			FROM user_chat_invite a
			LEFT JOIN user_profile ON user_profile.id = a.from_user_id
			WHERE a.to_user_id = {$id}
			AND loaded = 1
			AND invite_msg is NOT NULL
			AND time > '".date('Y-m-d H:i:s')."'
			AND showed = 0
			GROUP BY a.from_user_id
			ORDER BY a.time desc
			LIMIT 5
		";                   
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// ���������� �����������
	
	function declineChatInvite($c_name)
	{
		$this->db->delete('user_chat_invite', array('chat_name' => $c_name));
	}
	
	// �������� �����������
	
	function acceptChatInvite($c_name)
	{
		$this->db->update('user_chat_invite', array('answer' => '1'), array('chat_name' => $c_name));
		$this->db->update('user_chat', array('accepted' => 1), array('chat_name' => $c_name));
		$this->setChatLife($c_name);
	}
	
	// �������� �������
	
	
	function createChatRoom($c_name)
	{
		$cInfo = $this->db->get_where('user_chat_invite', array('chat_name' => $c_name))->row_array();
		$time = time();
           
        $chat = $this->db->get_where('user_chat', array('chat_name' => $c_name, 'end_time >' => $time))->row_array();
                if(count($chat) < 1 ){
                    $data = array(
			'chat_name'	=> $c_name,
			'user_1'	=> $cInfo['from_user_id'],
			'user_2'	=> $cInfo['to_user_id'],
			'end_time'	=> (time() + 300),
			'start'		=> date('Y-m-d H:i:s')
                    );
		
                    $this->db->insert('user_chat', $data);
                }
	}
	
	// ���������� �������
	
	function getChatInfo($c_name)
	{
		$info = $this->db->get_where('user_chat', array('chat_name' => $c_name));
		
		if ($info->num_rows() > 0)
		{
			return $info->row_array();
		}
		
		return false;
	}
	
	// ���������� �� ����� ��� ���
	
	function isThisChatExist($my_id, $user_id)
	{
		$time = time();
		$info = $this->db->get_where('user_chat', array('user_1' => $my_id, 'user_2' => $user_id, 'end_time >' => $time))->num_rows();
		$oInfo = $this->db->get_where('user_chat', array('user_1' => $user_id, 'user_2' => $my_id, 'end_time >' => $time))->num_rows();
		
		if ($info > 0 || $oInfo > 0)
		{
			return true;
		}
		
		return false;
	}
	
	////////////////////////////
	// ����������� � ��� ������ ����� ����� ������� �������� ����
	
	function inviteNewUser($user_id)
	{
		$info = $this->db->get_where('user_profile', array('id' => $user_id));
		
		if ($info->num_rows() > 0)
		{
			return $info->row_array();
		}
		
		return false;
	}
	
	///////////////////////////////
	// ��������� ��������� �� �������, ���� ��� ����
	
	function getDialogMessages($c_name)
	{
		$query = "
			SELECT
			user_chat_messages.*,
			user_profile.name
			FROM user_chat_messages
			LEFT JOIN user_profile ON user_profile.id = user_chat_messages.from_id
			WHERE chat_name = ?
			ORDER BY message_date
		";
		
		return $this->db->query($query, array($c_name))->result_array();
	}
	
	function getVDialogMessages($c_name)
	{
           $usr = explode( "_", $c_name );
           $time = time();

            $query = "
                        SELECT
			m.*,
			u.name
			FROM user_chat_messages as m
			LEFT JOIN user_profile as u ON u.id = m.from_id
                        LEFT JOIN user_chat as a ON a.chat_name = m.chat_name
			WHERE 
                              ( ( a.user_1 = ".$usr[0]." and a.user_2 = ".$usr[1]." and end_time > {$time}) 
                                 OR ( a.user_1 = ".$usr[1]." and a.user_2 = ".$usr[0]." and end_time > {$time})
                               )
                        UNION ALL
			SELECT
			user_vchat_messages.*,
			user_profile.name
			FROM user_vchat_messages
			LEFT JOIN user_profile ON user_profile.id = user_vchat_messages.from_id
			WHERE chat_name = ?
			ORDER BY message_date
		";
                                    
		return $this->db->query($query, array($c_name))->result_array();
	}
	//////////////////////////
	// ����� ���������
	
	function insertNewMessage($data)
	{
		$this->db->insert('user_chat_messages', $data);
	}
	
	function insertVNewMessage($data)
	{
		$this->db->insert('user_vchat_messages', $data);
	}
	//////////////////////////////
	// ���������� ������� ���������
	
	function updateMsgStatus($hash)
	{
		$this->db->update('user_chat_messages', array('status' => '1'), array('message_id' => $hash));
	}

        function updateVMsgStatus($hash)
	{
		$this->db->update('user_vchat_messages', array('status' => '1'), array('msg_hash' => $hash));
	}
	
	/////////////////////////////////
	// ��������� ����� ���������
	
	function getNewMessages($c_name, $my_id)
	{
		$query = "
			SELECT
			user_chat_messages.*,
			user_profile.name
			FROM user_chat_messages
			LEFT JOIN user_profile ON user_profile.id = user_chat_messages.from_id
			WHERE
			user_chat_messages.status = '0'
			AND user_chat_messages.chat_name = ?
			AND user_chat_messages.from_id != ?
			ORDER BY message_date
		";
		
		$query = $this->db->query($query, array($c_name, $my_id));
		
		
		return $query->result_array();
	
	}
	
	function getVNewMessages($c_name, $my_id)
	{
		$query = "
			SELECT
			m.*, u.name
			FROM user_vchat_messages as m
			LEFT JOIN user_profile as u ON u.id = m.from_id
			WHERE
			m.status = '0'
			AND m.chat_name = ?
			AND m.from_id != ?
			ORDER BY message_date
		";
		$query = $this->db->query($query, array($c_name, $my_id));
		
		return $query->result_array();
	
	}
	////////////////////////////////
	// ��������� ����� ����
	
	function setChatLife($c_name)
	{
		$time = time();
		$newTime = $time + (60 * 5);
		
		$this->db->update('user_chat', array('end_time' => $newTime), array('chat_name' => $c_name));
	}
	
	///////////////////////////////////
	// �������� ���� �������������
	
	function closeChatByUser($chat_name)
	{
		$this->db->update('user_chat', array('end_time' => '1'), array('chat_name' => $chat_name));
	}
	
	/******************************* � � � � � � � � **********************************/
	
	function createVideoRoom($data)
	{
		$this->db->insert('user_videochat', $data);
	}
	
	function checkInviteToVideo($id)
	{
		$time = time();
		$query = "
			SELECT
			user_videochat.*,
			user_profile.name, user_profile.photo_link, user_profile.id
			FROM user_videochat
			LEFT JOIN user_profile ON user_profile.id = user_videochat.user_1
			WHERE user_videochat.user_2 = {$id}
			AND end_call_date > {$time}
			AND is_answer = '0'
			ORDER BY user_videochat.start_date desc
			LIMIT 1
		";
		$query = $this->db->query($query);
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		
		return false;
	}
	
	function acceptVideoInvite($name)
	{
		$this->db->update('user_videochat', array('is_answer' => '1'), array('chat_name' => $name));
		
		return true;
	}
	
	function declineVideoInvite($name)
	{
		$this->db->update('user_videochat', array('is_answer' => '2'), array('chat_name' => $name));
		
		return true;
	}
	
	// �������� ��� �������� ������
	function checkVideoAnswer($c_name)
	{
		$query = $this->db->get_where('user_videochat', array('chat_name' => $c_name))->row_array();
		$time = time();
		
		if ($query['end_call_date'] > $time)
		{
			if ($query['is_answer'] == '1')
			{
				return 'success';
			}
			elseif ($query['is_answer'] == '2')
			{
				return 'error';
			}
		}
		else
		{
			return 'timeout';
		}
	}
	
	function getVideoInfo($name)
	{
		return $this->db->get_where('user_videochat', array('chat_name' => $name))->row_array();
	}
	
	public function listSort($sort = 0)
	{
		switch($sort)
		{
			case 0:
				return 'ORDER BY u.last_online DESC';
				break;
				
			case 1:
				return 'ORDER BY u.age ASC';
				break;
				
			case 2:
				return 'ORDER BY u.age DESC';
				break;
		}
	}
	
	public function listSortLady($sort = 0)
	{
		switch($sort)
		{
			case 0:
				return 'ORDER BY u.is_multichat ASC, u.last_online DESC';
				break;
				
			case 1:
			case 2:
				return $this->listSort($sort);
				break;				
		}
	}

    function getDTLikeManProfiles($my_id, $start, $limit, $sort = '', $sortBy = 0)
	{
		$time = time();
		$add = '';
		
		//$sorting = $this->listSort($sort);
		
		if ($sortBy > 0 && !empty($sort))
		{
			if ($sortBy == 1)
			{
				$add = ' AND u.id = ' . $sort;
			}
			else
			{
				$add = ' AND u.name LIKE "%'.$sort.'%"';
			}
		}

		$query = "
			SELECT DISTINCT
                u.sex, u.user_status, u.last_online, u.id, u.name, u.photo_link, u.age, u.country
			FROM 
				user_profile as u
            WHERE
			u.sex = 1
			AND u.user_status = 0
            AND u.last_online > {$time}
			{$add}
           
			ORDER BY u.last_online
			LIMIT {$start}, {$limit}
		";
		
		return $this->db->query($query)->result_array();
	}
	
	function getDTLikeWomenProfiles($my_id, $start, $limit, $sort = '', $sortBy = 0)
	{
		$time = time();
		$add = '';
		
		//$sorting = $this->listSort($sort);
		
		if ($sortBy > 0 && !empty($sort))
		{
			if ($sortBy == 1)
			{
				$add = ' AND u.id = ' . $sort;
			}
			else
			{
				$add = ' AND u.name LIKE "%'.$sort.'%"';
			}
		}
              
		$query = "
			SELECT SQL_NO_CACHE DISTINCT
			u.sex, u.user_status, u.last_online, u.photo_link, u.id, u.name, u.age, u.is_multichat, u.country
			FROM user_profile as u
            
            WHERE
			u.sex = 2
			AND u.user_status = 0
            AND u.last_online > {$time}
			{$add}
			ORDER BY u.is_multichat asc, u.last_online desc
			LIMIT {$start}, {$limit}
		";               
		//$this->db->cache_off();
		$query = $this->db->query($query);
		
		return $query->result_array();
	}
	
	function deleteOlderRoom($name)
	{
		$this->db->query("DELETE FROM user_videochat WHERE chat_name = '{$name}'");
		$this->db->query("DELETE FROM user_vchat_messages WHERE chat_name = '{$name}'");
	}
	
	public function checkAlreadyInvite($userId, $myId)
	{
		$time = time();
		$query = $this->db->query("SELECT * FROM user_chat WHERE ((user_1 = '{$userId}' AND user_2 = '{$myId}') OR (user_1 = '{$myId}' AND user_2 = '{$userId}')) AND end_time > '{$time}'")->num_rows();
		
		if ($query > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function checkForOnline($selfId, $userId)
	{
		$query2 = $this->db->query("SELECT COUNT(*) as cnt FROM user_chat WHERE (user_1 = {$selfId} AND user_2 = {$userId} OR user_1 = {$userId} AND user_2 = {$selfId}) AND end_time > ".time())->row_array();
		
		$query = $this->db->query('SELECT COUNT(*) as cnt FROM user_chat_invite WHERE from_user_id = ? AND to_user_id = ? AND time > ?', array($selfId, $userId, date('Y-m-d H:i:s')))->row_array();
	
	if ($query['cnt'] > 0 || $query2['cnt'] > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function getTotalOnline($userSex, $id = 0, $sort = '', $sortBy = 0)
	{
		$add = '';
		
		if ($sortBy > 0 && !empty($sort))
		{
			if ($sortBy == 1)
			{
				$add = ' AND id = ' . $sort;
			}
			else
			{
				$add = ' AND name LIKE "%'.$sort.'%"';
			}
		}
		
		switch($userSex)
		{
			case 1:
				$total = $this->db->query('SELECT count(id) as cnt FROM user_profile WHERE user_status = 0 AND sex = 2 AND last_online > '.time() . $add)->row_array();
			break;
			
			case 2:
				$total = $this->db->query('SELECT count(id) as cnt FROM user_profile WHERE user_status = 0 AND sex = 1 AND last_online > ' . time() . $add)->row_array();
			break;
			
			default:
				$total['cnt'] = 0;
			break;
		}
		
		return $total['cnt'];
	}
	
	public function checkForActiveChat($selfId, $userId)
	{
		$query2 = $this->db->query("SELECT * FROM user_chat WHERE ((user_1 = {$selfId} AND user_2 = {$userId}) OR (user_1 = {$userId} AND user_2 = {$selfId})) AND end_time > UNIX_TIMESTAMP()");
		if ($query2->num_rows() > 0)
		{
			$row = $query2->row_array();

			
			return $row;
		}
		
		return false;
	}
	
	public function isNewMessages($chat_name, $selfId)
	{
		$query = $this->db->query('SELECT COUNT(*) as cnt FROM user_chat_messages WHERE from_id != ? AND status = 0 AND chat_name = ?', array($selfId, $chat_name))->row_array();
		
		return $query['cnt'];
	}
	
	public function removeContact($user_id, $self_id)
	{
		$this->db->query("DELETE FROM user_chat WHERE (user_1 = {$user_id} AND user_2 = {$self_id}) OR (user_1 = {$self_id} AND user_2 = {$user_id})");
	}
	
	public function deleteHistory($user_id)
	{
		$this->db->query("DELETE FROM user_chat WHERE user_1 = '{$user_id}' OR user_2 = '{$user_id}'");
	}
	
	public function sendInviteForChat($chat_name, $message)
	{
		$check = $this->db->get_where('user_chat_messages', array('chat_name' => $chat_name))->num_rows();
		
		if ($check == 0)
		{
			$update = array(
				'loaded' => 1,
				'invite_msg' => $message
			);
			$this->db->update('user_chat_invite', $update, array('chat_name' => $chat_name));
		}
	}
	
	public function clearContacts($user_id) 
	{
		$list = $this->db->query('SELECT * FROM user_chat WHERE ((user_1 = '.$user_id.') OR (user_2 = '.$user_id.')) AND (SELECT COUNT(*) FROM user_chat_messages WHERE chat_name = user_chat.chat_name) < 2 GROUP BY chat_name')->result_array();
		
		foreach ($list as $row)
		{
			$user = ($user_id == $row['user_1']) ? $row['user_2'] : $row['user_1'];
			$rows = $this->db->query('SELECT * FROM user_chat WHERE ((user_1 = '.$user_id.' AND user_2 = '.$user.') OR (user_1 = '.$user.' AND user_2 = '.$user_id.')) AND (SELECT COUNT(*) FROM user_chat_messages WHERE chat_name = user_chat.chat_name) >= 2')->num_rows();
			
			if ($rows == 0) 
			{
				$this->removeContact($user, $user_id);
				$this->db->query('DELETE FROM user_chat_invite WHERE chat_name = "' . $row['chat_name'] . '"');
			}
		}
	}
	
	public function newFavorite($my_id, $user_id)
	{
		$exist = $this->db->get_where('user_favorites', array('id' => $my_id, 'fav_id' => $user_id))->num_rows();
				
		if ($exist == 0) 
		{
			$this->db->insert('user_favorites', array('id' => $my_id, 'fav_id' => $user_id, 'add_date' => time()));
					
			return true;
		}
				
		return false;
	}
	
	public function isOnlyVideo($room)
	{
		$msg = $this->db->get_where('user_chat_messages', array('chat_name' => $room))->num_rows();
		
		return ($msg > 0) ? false : true;
	}
	
	public function chatChating($myId, $room)
	{
		$my = $this->db->get_where('user_chat_messages', array('chat_name' => $room, 'from_id' => $myId))->num_rows();
		$other = $this->db->get_where('user_chat_messages', array('chat_name' => $room, 'from_id !=' => $myId))->num_rows();
		
		if ($my > 0 && $other > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function getDTLikeManProfiles2($my_id)
	{
		$time = time();
                $time_exp = $time - ( 5 * 60 );
/*		$query = "
			SELECT
			user_profile.*
			FROM user_profile
			WHERE
			sex = '1'
			AND user_status = '0'
			AND last_online > {$time}
			ORDER BY rand()
			LIMIT 9
		";
		
		$query = "
			SELECT
			user_profile.*
			FROM user_profile
			WHERE
			sex = '1'
			AND user_status = '0'
			ORDER BY rand()
			LIMIT 9
		";
*/			
		$query = "
			SELECT DISTINCT
                        u.*, a.chat_name as room, a.end_time,( SELECT c.loaded                                                                    
                                                                FROM user_chat_invite as c 
                                                                WHERE
                                                                    c.from_user_id = {$my_id}
                                                                    AND c.to_user_id = u.id
                                                                    AND c.time > '".date('Y-m-d H:i:s')."'
																	AND c.loaded = 1
                                                                    ORDER BY c.time desc
                                                                LIMIT 1) as invite,
                                                                ( 
                                                                    SELECT count(*)
                                                                    FROM user_chat_messages as m
                                                                    WHERE
                                                                        m.status = '0'
                                                                        AND m.chat_name = a.chat_name
                                                                        AND m.from_id != u.id
                                                                )as newmsg,
																( SELECT count(*) from user_chat_messages mm WHERE mm.status = 0 AND mm.is_offline = 1 AND mm.from_id = u.id ) as offline
			FROM user_profile as u
                        LEFT JOIN user_chat as a ON (
                                       (u.id = a.user_1 and a.user_2 = {$my_id} and end_time > {$time}) 
                                    OR ({$my_id} = a.user_1 and a.user_2 = u.id and end_time > {$time})
                                            )
                        WHERE
			sex = '1'
			AND user_status = '0'
			GROUP BY u.id
			ORDER BY offline desc, a.end_time desc, u.last_online desc
			LIMIT 99
		";
                $query = $this->db->query($query);
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	public function isOfflineMessages($myId, $userId)
	{
		$count = $this->db->get_where('user_chat_messages', array('from_id' => $userId, 'to_id' => $myId, 'status' => 0, 'is_offline' => 1))->num_rows();
		
		return ($count > 0) ? true : false;
	}
}
<?PHP

class Chat extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth != true)
		{
			return redirect(base_url());
		}
		
		if ($this->userInfo['sex'] == 1 && $this->userInfo['credits'] <= 1)
		{
			return redirect('/my/credits');
		}
		
		$this->load->model('chat_model');
		$this->load->library('editor');
		$this->load->helper('chat');
	}
	
	public function index($room = '')
	{
		$actuser = '';
		
		if ($room == '') 
		{
			$this->chat_model->clearContacts($this->selfId);
		}
		
		$this->db->update('user_camera', array('camera' => 0, 'voice' => 0, 'nearId' => ''), array('userId' => $this->selfId));
		
		if (!empty($room))
		{
			$chat = $this->chat_model->getChatInfo($room);
			
			if (time() >= $chat['end_time'])
			{
				return redirect('/my/chat');
			}
			
			$actuser = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
		}
		
		if ($this->userInfo['sex'] == 1)
		{
			$lng['main'] = 'Ladies online';
			$lng['total'] = 'ladies total';
			
			$this->layout('null', 'profile/chat/men_view', array('actuser' => $actuser, 'lng' => $lng, 'room' => $room));
		}
		else
		{
			$lng['main'] = 'Men online';
			$lng['total'] = 'men total';
			
			$this->layout('null', 'profile/chat/women_view', array('actuser' => $actuser, 'lng' => $lng, 'room' => $room));
		}
	}
	
	public function online_list()
	{
		if (IS_AJAX)
		{
			$page = ($this->input->post('page')) ? (int)$this->input->post('page') : 1;
			$start = ($page - 1) * 10;		

			// sorting
			$sort = $this->input->post('sort');
			$sortBy = 0;
			
			if (intval($sort))
			{
				$sortBy = 1;
			}
			else
			{
				$sortBy = 2;
			}
			
			if($this->userInfo['sex'] == 2)
				$users = $this->chat_model->getDTLikeManProfiles($this->selfId, $start, 10, $sort, $sortBy);
			else
				$users = $this->chat_model->getDTLikeWomenProfiles($this->selfId, $start, 10, $sort, $sortBy);
			
			if (empty($users)) { $users = array(); }
			
			$html = '';
			$i = 0;
			
			foreach ($users as $u)
			{
				$photo = ($u['photo_link'] == '') ? '/content/img/no-foto-100.png' : '/profiles/photo/user_' . $u['id'] . '/' . $u['photo_link'] . '_100.jpg';
				
				if ($this->chat_model->checkForOnline($this->selfId, $u['id']) == false)
				{
					$i++;
					
					$name = (strlen($u['name']) > 12) ? substr($u['name'], 0, 12) . '...' : $u['name'];
					
					$html .= '
						<li id="'.$u['id'].'" class="profilecard item">
							<span class="photo" onClick="users.invite('.$u['id'].');"><img src="'.base_url() . $photo.'" width="95px" height="120"></span>
							<span class="name" onClick="users.invite('.$u['id'].');"><p style="padding-top: 6px;">'.$name.'</p></span>
							<span class="age">Age: '.$u['age'].'</span>
							<span class="age">Country: '.userCountry($u['country']).'</span>
							<span class="age">ID: '.$u['id'].'</span>
							<span class="age"><a href="'.base_url().'user'.$u['id'].'" target="_blank"><img src="'.base_url().'content/chat/css/chat/icon_man.png" style="width:20px;" title="View profile"></a><a href="javascript:;" onClick="users.addFavorite('.$u['id'].');"><img title="Add to favorites" src="'.base_url().'content/chat/css/chat/heart.png" style="width:20px;padding-left:5px;"></a><a href="'.base_url().'my/letters/write/new/'.$u['id'].'" target="_blank"><img title="Write a letter" src="'.base_url().'content/chat/css/chat/message.png" style="width:30px;padding-left:1px;"></a></span>
							<div style="clear: both;"></div>
						</li>
					';
				}
			}
			
			$totalOnline = $this->chat_model->getTotalOnline($this->userInfo['sex'], $this->selfId, $sort, $sortBy);
			$pages = createSimplePagination($totalOnline, $page, 'users.page', 10);
			$history = $this->_history();
			
			echo json_encode(array('list' => $html, 'count' => $totalOnline, 'pages' => $pages, 'history' => $history), JSON_HEX_TAG);
		}
	}
	
	private function _history()
	{
		$users = $this->chat_model->getChatHistory($this->selfId);
		$html = '';
			
		foreach ($users as $user)
		{
			// сначала активные чаты
			if ($isActive = $this->chat_model->checkForActiveChat($this->selfId, $user['id']))
			{
				$remove = 'onClick="endChat(\''.$isActive['chat_name'].'\');"';
				//$script = '';
				$view1 = '';
				$view2 = '';
				$online = 'chat-chating';
				
				if ($this->chat_model->chatChating($this->selfId, $isActive['chat_name']) == false && $isActive['user_2'] != $this->selfId)
				{
					$online = 'chat';
				}
				//elseif ($this->chat_model->chatChating($this->selfId, $isActive['chat_name']) != false && $isActive['user_2'] == $this->selfId)
				//{
				//	$online = 'online';
				//}
				
				if ($this->chat_model->isNewMessages($isActive['chat_name'], $this->selfId) > 0)
				{
					$online = 'chat-watching';
				}
						
				if ($isActive['video_s_man'] == 1 && $this->userInfo['sex'] == 2)
				{
					if ($this->chat_model->isOnlyVideo($isActive['chat_name']) == true)
					{
						$online = 'invited';
					}
					
					$view1 = '<a href="javascript:;" onClick="videochat.cancelTo(\''.$isActive['chat_name'].'\');" title="Disconnect this user"><img src="'.base_url().'content/chat/css/chat/cams.png"></a>';
				}
				
				if ($isActive['video_accepted'] == 0 && $this->userInfo['sex'] == 2) 
				{
					$view1 = '<a href="javascript:;" onClick="videochat.approveTo(\''.$isActive['chat_name'].'\');" title="Restore this user"><img src="'.base_url().'content/chat/css/chat/cams_off.png"></a>';
				}
						
				if ($isActive['video_s_woman'] == 1 && $this->userInfo['sex'] == 1)
				{
					$view2 = '<img src="'.base_url().'content/chat/css/chat/cams.png">';
				}
					
				$html .= '
						<li class="item" id="id_contact_'.$user['id'].'" contact-id="'.$user['id'].'" onClick="users.selectToDelete('.$user['id'].');">
							<span class="b-status b-status__type_'.$online.'"></span>
							<div class="info">
								<div class="text">
									<span class="name" onClick="textchat.loadRoom(\''.$isActive['chat_name'].'\');">'.$view1.$view2.' <strong>'.$user['name'].'</strong>,</span>
									<span class="id">&nbsp;ID: '.$user['id'].'</span>
									<div style="clear: both;"></div>
								</div>
							</div>
						</li> 
				';
			}
		}
		foreach($users as $user)
		{
			if (!$isActive = $this->chat_model->checkForActiveChat($this->selfId, $user['id']))
			{
				// теперь пользователи онлайн
				if (isOnlineUser($user['last_online']) == true)
				{
					$type = 'online';
					
					if ($this->chat_model->isOfflineMessages($this->selfId, $user['id']) == true)
					{
						$type = 'chat-watching';
					}
					
					$html .= '
						<li class="item" id="id_contact_'.$user['id'].'" contact-id="'.$user['id'].'" onClick="users.selectToDelete('.$user['id'].');">
							<span class="b-status b-status__type_'.$type.'"></span>
							<div class="info">
								<div class="text">
									<span class="name" onClick="users.invite('.$user['id'].');"><strong>'.$user['name'].'</strong>,</span>
									<span class="id">&nbsp;ID: '.$user['id'].'</span>
									<div style="clear: both;"></div>
								</div>
							</div>
						</li> 
					';
				}
				else
				{
					$type = 'offline';
					
					if ($this->chat_model->isOfflineMessages($this->selfId, $user['id']) == true)
					{
						$type = 'chat-watching';
					}
					
					$html .= '
						<li class="item" id="id_contact_'.$user['id'].'" contact-id="'.$user['id'].'" onClick="users.selectToDelete('.$user['id'].');">
							<span class="b-status b-status__type_'.$type.'"></span>
							<div class="info">
								<div class="text">
									<span class="name" onClick="users.invite('.$user['id'].');"><strong>'.$user['name'].'</strong>,</span>
									<span class="id">&nbsp;ID: '.$user['id'].'</span>
									<div style="clear: both;"></div>
								</div>
							</div>
						</li> 
					';
				}
			}
		}
			
		return $html;
	}
	
	public function remove_contact()
	{
		if (IS_AJAX)
		{
			// удаление только 1 контакта по ID
			if ($this->input->post('user'))
			{
				$this->chat_model->removeContact((int)$this->input->post('user'), $this->selfId);
			}
			// удаление всего контакт-листа
			else
			{
				$this->chat_model->deleteHistory($this->selfId);
			}
			
			echo json_encode(array('result' => 'success'));
		}
	}
	
	public function start($user_id)
	{
		//if ($this->mainModel->isInBlacklist($this->selfId, $user_id))
		//{
		//	return show_error('You are added to the blacklist of this user and can\'t invite him to chat.');
		//}
		
		$userInfo = $this->mainModel->getUserProfile($user_id);
		
		if ($userInfo != false && $userInfo['sex'] != $this->userInfo['sex'] && $userInfo['user_status'] == 0 && isOnlineUser($userInfo['last_online']) == true)
		{
			if ($this->userInfo['sex'] == 1 && $this->userInfo['credits'] <= 1)
			{
				redirect(base_url() . 'my/credits');
				return false;
			}
			
			$chatName = md5(time() . $this->selfId . $user_id);
			
			$newAction = array(
				'from_user_id'	=> $this->selfId,
				'to_user_id'	=> $user_id,
				'chat_name'		=> $chatName,
				'time'			=> date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s') + 120, date('m'), date('d'), date('Y')))
			);
			
			if($this->userInfo['sex'] == 2)
            {
                //$this->db->insert('user_chat_session', array('user_1' => $this->selfId, 'user_2' => $user_id));
            }
				
			$this->chat_model->createNewAction($newAction);
			$this->chat_model->createChatRoom($chatName);
			
			redirect(base_url() . 'my/chat/index/' . $chatName);
		}
		else
		{
			redirect(base_url() . 'my/chat');
		}
	}
	
	public function invite()
	{
        $result = false;
        $msg = "You are added to the blacklist of this user and can't invite him to chat.";
                
        if (IS_AJAX && $this->input->post('userId'))
        {
			$id = (int)$this->input->post('userId');
				
			$invitedUser = $this->mainModel->getUserProfile($id);
			
			if ($invitedUser != false)
			{
                if ($this->userInfo['sex'] == 1 && $this->userInfo['credits'] < 1)
                {
					$msg = $this->lang->line('chat_no_credits');
                }
                else
                    if ($invitedUser['sex'] == $this->userInfo['sex'] || $id == $this->selfId)
                    {
						$msg = $this->lang->line('chat_user_error');
                    }			
                    else
                    {
						$chatName = md5(time() . $this->selfId . $id);
						$newAction = array(
							'from_user_id'	=> $this->selfId,
							'to_user_id'	=> $id,
							'chat_name'		=> $chatName,
							'time'			=> date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s') + 120, date('m'), date('d'), date('Y')))
						);
				
						$this->chat_model->createNewAction($newAction);
						$this->chat_model->createChatRoom($chatName);
						$result = true;
                    }
			}

            if($result == true) 
			{
                echo json_encode(array('result' => 'success', 'room' => $chatName));
			}
			else
			{
				echo json_encode(array('result' => 'error', 'message' => $msg));
			}                                           
		}
	}
	
	public function load_user()
	{
		if (IS_AJAX)
		{
			$room = $this->input->post('room');
			$chat = $this->chat_model->getChatInfo($room);
			$user_id = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
			$info = $this->mainModel->getUserProfile($user_id);
			
			$photo = ($info['photo_link']) ? base_url() . 'profiles/photo/user_' . $user_id . '/' . $info['photo_link'] . '_100.jpg' : base_url() . 'content/img/nophoto-mini.png';
			
			$main = $info['name'] . '<br>ID: ' . $info['id'];
			$info2 = 'Age: ' .$info['age'] . '<br>Country: ' . userCountry($info['country']) . '<br><a class="b-button-green" id="connect" style="display:none;" onClick="videochat.connect();">Start video</a>';
			
			echo json_encode(array('photo' => $photo, 'main' => $main, 'info' => $info2, 'id' => $user_id, 'name' => $info['name']));
		}
	}
	
	private function _addMoney($room)
	{
		$chat = $this->db->query("SELECT * FROM user_chat WHERE (user_1 = '{$this->selfId}' OR user_2 = '{$this->selfId}') AND chat_name = '{$room}'")->row_array();
		if ($chat['user_1'] == $this->selfId)
		{
			$manId = $chat['user_2'];
		}
		else
		{
			$manId = $chat['user_1'];
		}
			
		$woman = $this->mainModel->getUserProfile($manId);
		$check_chat = $this->db->get_where('partner_money', array('c_name' => $room, 'type' => 1))->num_rows();
			
		if ($check_chat < 1)
		{
			$insert = array(
				'partner_id'	=> $woman['is_agency'],
				'm_date'		=> time(),
				'm_name'		=> 'Text chat',
				'm_message'		=> 'Text chat '.$manId.' with '.$this->selfId,
				'm_price'		=> $this->prices->get('CHAT_PARTNER'),
				'from_girl'		=> $manId,
				'from_man'		=> $this->selfId,
				'c_name'		=> $room
			);	
				
			$this->db->insert('partner_money', $insert);
		}
		else
		{
			$this->db->query('UPDATE partner_money SET m_price = m_price + '.$this->prices->get('CHAT_PARTNER').' WHERE c_name = ? AND type = ?', array($room, 1));
		}
	}
	
	public function invite_all()
	{
		if (IS_AJAX && $this->input->post('message'))
		{
			if($this->userInfo['sex'] == 2)
				$users = $this->chat_model->getDTLikeManProfiles($this->selfId, 0, 100, 0);
			else
				$users = $this->chat_model->getDTLikeWomenProfiles($this->selfId, 0, 100, 0);
			
			if (empty($users)) { $users = array(); }
			
			foreach ($users as $u)
			{				
				if ($this->chat_model->checkForOnline($this->selfId, $u['id']) == false)
				{
					$chatName = md5(time() . $this->selfId . $u['id']);
					$newAction = array(
						'from_user_id'	=> $this->selfId,
						'to_user_id'	=> $u['id'],
						'chat_name'		=> $chatName,
						'time'			=> date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s') + 120, date('m'), date('d'), date('Y')))
					);
				
					$this->chat_model->createNewAction($newAction);
					$this->chat_model->createChatRoom($chatName);
					
					$message = $this->editor->smiles($this->editor->parse_message($this->input->post('message')));
					$insertData = array(
						'from_id'		=> $this->selfId,
						'message'		=> $message,
						'message_date'	=> time(),
						'chat_name'		=> $chatName,
						'msg_hash'		=> md5($this->selfId . time())
					);
					
					// если это первое сообщение - добавляем его в приглос
					$this->chat_model->sendInviteForChat($chatName, $message);
					$this->chat_model->insertNewMessage($insertData, $chatName);
				}
			}
		}
	}
	
	public function ajax($action)
	{
		switch($action)
		{
			case 'load_messages':
				if (IS_AJAX && $this->input->post('room'))
				{	
					$chat_name = $this->input->post('room');
					
					$oldMsg = $this->chat_model->getDialogMessages($chat_name);
					
					$this->db->update('user_chat_messages', array('status' => 1), array('chat_name' => $chat_name));
					
					$this->load->view('profile/chat/chat_messages_view', array('msg' => $oldMsg, 'my_id' => $this->selfId));
				}
			break;
			
			case 'load_history':
				if (IS_AJAX && $this->input->post('room'))
				{
					$old = $this->chat_model->getOldMessages($this->input->post('room'));
					
					$this->load->view('profile/chat/chat_messages_view', array('msg' => $old, 'my_id' => $this->selfId));
				}
			break;
			
			case 'close':
				if (IS_AJAX && $this->input->post('room'))
				{
					$room = $this->input->post('room');
					
					$this->chat_model->closeChatByUser($room);
					$this->chat_model->declineChatInvite($room);
					$this->db->update('user_camera', array('only_id' => 0), array('userId' => $this->selfId));
				}
			break;
			
			case 'credits':
				if (IS_AJAX && $this->input->post('room')) {
					$prof = $this->mainModel->getUserProfile($this->selfId);
					$makeMinus = $prof['credits'] - 1;
						
					$msg = $this->db->get_where('user_chat_messages', array('chat_name' => $this->input->post('room'), 'from_id !=' => $this->selfId))->num_rows();
							
					if($msg >= 2)
					{
						if ($makeMinus < 1)
						{
							echo json_encode(array('result' => 'error'));
							return false;
						}
							
						$chat = $this->chat_model->getChatInfo($this->input->post('room'));
						
						$lady = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];

						$this->mainModel->updateCredits($this->selfId, $makeMinus);
						$this->mainModel->creditsLog($this->selfId, $this->prices->get('CHAT'), 'Text Chat', $lady);
							
						$this->_addMoney($this->input->post('room'));
						
						echo json_encode(array('result' => 'success'));
					}
				}
			break;
			
			case 'send':
				if (IS_AJAX && $this->input->post())
				{
					$message = $this->editor->smiles($this->editor->parse_message($this->input->post('message')));
					$chat_name = $this->input->post('room');
					
					$chatInfo = $this->chat_model->getChatInfo($chat_name);
					
					if ($chatInfo['end_time'] == '1' || $chatInfo['end_time'] < time())
					{
						echo json_encode(array('status' => 'failed'));
						return false;
					}
					
					if ($this->userInfo['sex'] == 1 && $this->userInfo['credits'] <= 1)
					{
						echo json_encode(array('status' => 'failed'));
						return false;
					}
					
					if ($chatInfo['user_2'] == $this->selfId && $chatInfo['accepted'] == 0)
					{
						$this->db->update('user_chat', array('accepted' => 1), array('chat_name' => $chat_name));
					}
					
					unset($chatInfo);
					
					$chatInfo = $this->chat_model->getChatInfo($chat_name);
					$other = ($chatInfo['user_1'] == $this->selfId) ? $chatInfo['user_2'] : $chatInfo['user_1'];
					$oInfo = $this->mainModel->getUserProfile($other);
					
					$insertData = array(
						'from_id'		=> $this->selfId,
						'message'		=> $message,
						'message_date'	=> time(),
						'chat_name'		=> $chat_name,
						'msg_hash'		=> md5($this->selfId . time()),
						'to_id'			=> $other
					);
					
					if (isOnlineUser($oInfo['last_online']) == false)
					{
						if ($this->userInfo['sex'] == 1)
						{
							$price = $this->prices->get('OFFLINE_MESSAGE') / 2;
							$makeMinus = round($this->userInfo['credits'] - $price, 2);
							
							$this->mainModel->updateCredits($this->selfId, $makeMinus);
							$this->mainModel->creditsLog($this->selfId, $price, 'Offline Chat Message', $other);
						}
						
						$insertData['is_offline'] = 1;
					}
					
					// если это первое сообщение - добавляем его в приглос
					$this->chat_model->sendInviteForChat($chat_name, $message);
					$this->chat_model->insertNewMessage($insertData, $chat_name);
					//$this->cModel->resetInvite($message, $this->selfId, $chat_name);
					$this->chat_model->setChatLife($chat_name);
					
					// если деньги еще снимались за начало чата - снимаем
					/*if ($this->userInfo['sex'] == 1 && $chatInfo['firstMoney'] == 0 && $chatInfo['accepted'] == 1)
					{
						$prof = $this->mainModel->getUserProfile($this->selfId);
						$makeMinus = $prof['credits'] - 1;
						
						$lady = ($this->selfId == $chatInfo['user_1']) ? $chatInfo['user_2'] : $chatInfo['user_1'];
						
						if ($makeMinus < 1)
						{
							echo json_encode(array('result' => 'error', 'message' => $this->lang->line('chat_no_creds')));
							return false;
						}

						$this->mainModel->updateCredits($this->selfId, $makeMinus);
						$this->mainModel->creditsLog($this->selfId, 1, 'Text Chat', $lady);
					
						$this->_addMoney($chat_name);
						
						$this->db->update('user_chat', array('firstMoney' => 1, 'firstMoneyDate' => date('Y-m-d H:i:s')), array('chat_name' => $chat_name));
					}*/

					$message = '<div class="msgbox">
									<div class="headmsg"><span class="dtime">['.date('H:i:s',time()).']</span><span class="username-0">'.$this->userInfo['name'].'<span></div>           
									<div class="textmsg">'.$message.'</div>
								</div>';
					
					echo json_encode(array('status' => 'success', 'html' => $message));
				}
			break;
			
			case 'preload':
				if (IS_AJAX && $this->input->post('room'))
				{
					$message = '';
					$playSound = 0;
					$newMsgCount = 0;
					$chat_name = $this->input->post('room');
					
					// check
					$info = $this->chat_model->getChatInfo($chat_name);
					
					if ($info['end_time'] == 1 || $info['end_time'] < time())
					{
						echo json_encode(array('result' => 'errror', 'message' => 'Chat closed by another user.'));
						
						return false;
					}
					
					$isNew = $this->chat_model->getNewMessages($chat_name, $this->selfId);
						
					foreach ($isNew as $row)
					{
						$newMsgCount++;
						$message .= '<div class="msgbox">
									<div class="headmsg"><span class="dtime">['.date('H:i:s', $row['message_date']).']</span><span class="username-'.(($row['from_id']==$this->selfId)?0:1).'">'.$row['name'].'<span></div>           
									<div class="textmsg">'.$row['message'].'</div>
									 </div>
						';    

						$this->chat_model->updateMsgStatus($row['message_id']);
					}
								
					echo json_encode(array('result' => 'success', 'html' => $message, 'count' => $newMsgCount));
				}
			break;
			
			case 'check_chat':
				if (IS_AJAX && $this->input->post('id'))
				{
					$is_invite = $this->chat_model->checkInviteToChat($this->selfId);

					if ($is_invite != false)
					{
						$return = '';
						$count = 0;
						
						foreach ($is_invite as $invite)
						{
							$count++;
							
							$photo = ($invite['photo_link']) ? base_url() . 'profiles/photo/user_' . $invite['from_user_id'] . '/' . $invite['photo_link'] . '_100.jpg' : base_url() . 'content/img/nophoto-mini.png';
							$start = 'acceptInvite(\''.$invite['chat_name'].'\');';
							$decline = 'declineInvite(\''.$invite['chat_name'].'\');';
							$user = base_url() . 'user' . $invite['from_user_id'];
							
							$return .= '<div class="GPFN54SCLW" id="invite_'.$invite['chat_name'].'">
								<div class="GPFN54SCBGD" tabindex="0" style="opacity: 1;">
									<input type="text" tabindex="-1" role="presentation" style="opacity: 0; height: 1px; width: 1px; z-index: -1; overflow: hidden; position: absolute;">
									<div>
										<div class="GPFN54SCIFD">
											<div class="GPFN54SCJFD">Chat invitation</div>
										</div>
										<div class="GPFN54SCGFD">
											<table class="GPFN54SCFFD">
												<tbody>
													<tr>
														<td class="GPFN54SCPFD">
															<img class="GPFN54SCOFD" src="'.$photo.'"><br>
														</td>
														<td class="GPFN54SCAGD">
															<a class="gwt-Anchor GPFN54SCNFD" target="_blank" href="'.$user.'">'.$invite['name'].'</a>
															<div class="gwt-Label">ID: '.$invite['from_user_id'].'</div>
															<div class="gwt-Label">Age: '.$invite['age'].'</div>
															<div class="GPFN54SCLFD">'.$invite['invite_msg'].'</div>
														</td>
													</tr>
												</tbody>
											</table>
											<button class="btn" onClick="' . $start . '">Accept</button>
											<button class="btn" onClick="' . $decline . '">Decline</button>
										</div>
									</div>
								</div>
							</div>
							<script>setTimeout(\'declineInvite("' . $invite['chat_name'] . '")\', 15000);</script>
							';
						
							$this->db->update('user_chat_invite', array('showed' => 1), array('chat_name' => $invite['chat_name']));
					
						}
						
						echo json_encode(array('count' => $count, 'text' => $return), JSON_HEX_TAG);
					}
					else
						echo json_encode(array('count' => 0)); 
				}
			break;
			
			case 'decline':
				if (IS_AJAX)
				{
					$current_chat = $this->input->post('room');
					
					$this->chat_model->declineChatInvite($current_chat);
					$this->db->delete('user_chat', array('chat_name' => $current_chat));
				}
			break;
			
			case 'accept':
				if (IS_AJAX)
				{
					$current_chat = $this->input->post('chat');
					
					$this->chat_model->acceptChatInvite($current_chat);
					
					echo json_encode(array('result' => 'success'));
				}
			break;
			
			case 'favorite':
				if (IS_AJAX && $this->input->post('user_id'))
				{
					$user_id = (int)$this->input->post('user_id');
					
					if ($this->chat_model->newFavorite($this->selfId, $user_id) == true)
					{
						echo json_encode(array('message' => 'User successfully added to your favorites list.'));
						return false;
					}
					
					echo json_encode(array('message' => 'User already exists in yout favorites list'));
				}
			break;
		}
	}
	
	public function sendfile()
	{
		//print_r($_POST);
		if (isset($_FILES['userfile']) && $this->input->post('chat_name'))
		{
			$upload['upload_path']	= './profiles/chat/';
			$upload['allowed_types']= 'jpg|jpeg';
			$upload['max_size']		= 1024 * $this->engine['engine_max_image'];
			$upload['encrypt_name']	= true;
			
			$this->load->library('upload', $upload);
			$this->load->helper('create_avatars');
			
			if ($this->upload->do_upload())
			{
				ignore_user_abort(1);
				set_time_limit(0);
				
				$uploadData = $this->upload->data();
				
				$photoSettings = array (
					'thumbs' => array (
						array('w' => '100', 'h' => '100', 'name' => $uploadData['raw_name'] . '_prev', 'ext' => '.jpg', 'crop' => true),
					),
					'crop' => true,
					'newimg' => array (
						array ('max_w' => '900', 'max_h' => '999999', 'name' => $uploadData['raw_name'] . '_full')
					),
					'newimg_folder' => $uploadData['file_path'],
					'thumb_folder'	=> $uploadData['file_path'],
					'saveNewimg'	=> '1',
					'saveThumb'		=> '1'
				);
				
				$createPhotos = createAvatar($uploadData['full_path'], $photoSettings);
				
				if ($createPhotos[0] == true)
				{					
					unlink($uploadData['full_path']);
					
					$chat_name = $this->input->post('chat_name');
					$chat = $this->chat_model->getChatInfo($this->input->post('chat_name'));
					
					$other = ($this->input->post('selfId') == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
					
					$insertData = array(
						'from_id'		=> $this->selfId,
						'message'		=> '<a onClick="makePhoto(\''.base_url().'profiles/chat/' . $uploadData['raw_name'] . '_full.jpg\');" href="javascript:;"><img src="'.base_url().'profiles/chat/' . $uploadData['raw_name'] . '_prev.jpg"></a>',
						'message_date'	=> time(),
						'chat_name'		=> $this->input->post('chat_name'),
						'msg_hash'		=> md5($this->selfId . time()),
						'to_id'			=> $other
					);
					
					
				// если это первое сообщение - добавляем его в приглос
					//$this->chat_model->sendInviteForChat($chat_name, $message);
					$this->chat_model->insertNewMessage($insertData, $chat_name);
					$this->chat_model->setChatLife($chat_name);
					$my = $this->mainModel->getUserProfile($selfId);
					$message = '<div class="msgbox">
							<div class="headmsg"><span class="dtime">['.date('H:i:s',time()).']</span><span class="username-0">'.$this->userInfo['name'].'<span></div>           
							<div class="textmsg">'.$insertData['message'].'</div>
						</div>
					';
					
					echo json_encode(array('status' => 'success', 'html' => $message));					
				}
			}
		}
		else
			echo json_encode(array('status' => 'failed'));
	}
}
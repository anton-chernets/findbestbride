<?PHP

class Videochat extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth != true)
		{
			return redirect(base_url());
		}
		
		$this->load->model('chat_model');
	}
	
	public function audio()
	{
		if (IS_AJAX)
		{
			$this->db->update('user_camera', array('voice' => $this->input->post('audio')), array('userId' => $this->selfId));
		}
	}
	
	public function camera()
	{
		if (IS_AJAX)
		{
			$exist = $this->db->get_where('user_camera', array('userId' => $this->selfId))->num_rows();
			
			if ($exist == 0)
			{
				$this->db->insert('user_camera', array('userId' => $this->selfId, 'camera' => 1, 'voice' => $this->input->post('voice'), 'nearId' => $this->input->post('nearId')));
			}
			else
			{
				$this->db->update('user_camera', array('camera' => 1, 'voice' => $this->input->post('voice'), 'nearId' => $this->input->post('nearId')), array('userId' => $this->selfId));
			}
		}
	}
	
	public function camera_off()
	{
		if (IS_AJAX)
		{
			$this->db->update('user_camera', array('camera' => 0, 'nearId' => ''), array('userId' => $this->selfId));
		}
	}
	
	public function credits()
	{
		if (IS_AJAX && $this->input->post('room')) 
		{
			$prof = $this->mainModel->getUserProfile($this->selfId);
			$makeMinus = $prof['credits'] - $this->prices->get('VIDEOCHAT');
						
			if ($makeMinus < 1)
			{
				echo json_encode(array('result' => 'error'));
				return false;
			}
							
			$chat = $this->chat_model->getChatInfo($this->input->post('room'));
						
			$lady = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];

			$this->mainModel->updateCredits($this->selfId, $makeMinus);
			$this->mainModel->creditsLog($this->selfId, $this->prices->get('VIDEOCHAT'), 'Video Chat', $lady);
			$this->chat_model->setChatLife($this->input->post('room'));
							
			$this->_addMoney($this->input->post('room'));
						
			echo json_encode(array('result' => 'success'));
		}
	}

    public function credits_new()
    {
        if (IS_AJAX)
        {
            $prof = $this->mainModel->getUserProfile($this->input->post('selfId'));
            $makeMinus = $prof['credits'] - $this->prices->get('VIDEOCHAT');

            if ($makeMinus < 1)
            {
                echo json_encode(array('result' => 'error', 'type' => 'no credits'));
                return false;
            }

            $this->mainModel->updateCredits($this->input->post('selfId'), $makeMinus);
            $this->mainModel->creditsLog($this->input->post('selfId'), $this->prices->get('VIDEOCHAT'), 'Video Chat', $this->input->post('lady'));

            //$this->_addMoney($this->input->post('room'));

            echo json_encode(array('result' => 'success'));
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
		$check_chat = $this->db->get_where('partner_money', array('c_name' => $room, 'type' => 2))->num_rows();
			
		if ($check_chat < 1)
		{
			$insert = array(
				'partner_id'	=> $woman['is_agency'],
				'm_date'		=> time(),
				'm_name'		=> 'Video chat',
				'm_message'		=> 'Video chat '.$manId.' with '.$this->selfId,
				'm_price'		=> $this->prices->get('VIDEOCHAT_PARTNER'),
				'from_girl'		=> $manId,
				'from_man'		=> $this->selfId,
				'c_name'		=> $room,
				'type'			=> 2
			);	
				
			$this->db->insert('partner_money', $insert);
		}
		else
		{
			$this->db->query('UPDATE partner_money SET m_price = m_price + '.$this->prices->get('VIDEOCHAT_PARTNER').' WHERE c_name = ? AND type = ?', array($room, 2));
		}
	}
	
	public function is_camera()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$chat = $this->chat_model->getChatInfo($this->input->post('room'));
			$lady = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
			$check = $this->db->get_where('user_camera', array('userId' => $lady))->row_array();
			
			if ($check['camera'] == 1 && !empty($check['nearId']) && $chat['video_accepted'] == 1)
			{
				echo json_encode(array('result' => 'success'));
				return false;
			}
			else
			{
				echo json_encode(array('result' => 'fail'));
			}
		}
	}
	
	public function is_man_camera()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$chat = $this->chat_model->getChatInfo($this->input->post('room'));
			$lady = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
			$check = $this->db->get_where('user_camera', array('userId' => $lady))->row_array();
			
			if ($check['camera'] == 1 && !empty($check['nearId']))
			{
				if ($check['only_id'] == 0 || $check['only_id'] == $this->selfId)
				{
					echo json_encode(array('result' => 'success'));
					return false;
				}
				else
					echo json_encode(array('result' => 'fail'));
			}
			else
			{
				echo json_encode(array('result' => 'fail'));
			}
		}
	}
	
	public function load_near()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$chat = $this->chat_model->getChatInfo($this->input->post('room'));
			$user = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
			$near = $this->db->get_where('user_camera', array('userId' => $user))->row_array();
			
			if ($near['camera'] == 1 && !empty($near['nearId']))
			{
				$table = ($this->userInfo['sex'] == 1) ? 'video_s_man' : 'video_s_woman';
				$this->db->update('user_chat', array($table => 1), array('chat_name' => $this->input->post('room')));
				
				echo json_encode(array('result' => 'success', 'nearId' => $near['nearId'], 'sound' => $near['voice'], 'user' => $user));
			}
		}
	}
	
	public function disconnect()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$table = ($this->userInfo['sex'] == 1) ? 'video_s_man' : 'video_s_woman';
			
			$this->db->update('user_chat', array($table => 0), array('chat_name' => $this->input->post('room')));
		}
	}
	
	public function check_voice()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$chat = $this->chat_model->getChatInfo($this->input->post('room'));
			$lady = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
			$check = $this->db->get_where('user_camera', array('userId' => $lady))->row_array();
			
			if ($check['camera'] == 1 && $check['voice'] == 1)
			{
				echo json_encode(array('result' => 'success'));
				return false;
			}
			else
			{
				echo json_encode(array('result' => 'fail'));
			}
		}
	}
	
	public function cancel_man()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$this->db->update('user_chat', array('video_s_man' => 0, 'video_accepted' => 0), array('chat_name' => $this->input->post('room')));
		}
	}
	
	public function approve_man()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			$this->db->update('user_chat', array('video_accepted' => 1), array('chat_name' => $this->input->post('room')));
		}
	}
	
	public function only()
	{
		if (IS_AJAX && $this->input->post('room'))
		{
			switch($this->input->post('type'))
			{
				case 1:
					$this->db->update('user_camera', array('only_id' => 0), array('userId' => $this->selfId));
				break;
				
				case 2:
					$chat = $this->chat_model->getChatInfo($this->input->post('room'));
					$woman = ($this->selfId == $chat['user_1']) ? $chat['user_2'] : $chat['user_1'];
					
					$this->db->update('user_camera', array('only_id' => $woman), array('userId' => $this->selfId));
				break;
			}
		}
	}
}
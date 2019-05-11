<?php

Class Activation extends MY_controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAdmin != true)
		{
			show_404();
			return false;
		}
		
		$this->load->model('admin/admin_model', 'aModel');
		$this->load->model('admin/activation_model');
		$this->lang->load('english/admin');
		$this->load->library(array('all_gifts', 'profile'));
	}
	
	public function avatars()
	{
		$avatars = $this->activation_model->getAvatarsToActivate();
		
		$this->layout('admin', 'admin/activation/avatars_view', array('list' => $avatars));
	}
	
	function gifts()
	{
		
		$gifts = $this->aModel->getGiftsToActivate();
		
		$this->layout('admin', 'admin/activation/gifts_view', array('gifts' => $gifts), $this->lang->line('activate_gifts_title'));
	}
	
	function ankets()
	{
		$ankets = $this->activation_model->getAnketsToActivate();
		
		$this->layout('admin', 'admin/activation/ankets_view', array('ankets' => $ankets), $this->lang->line('activate_ankets_title'));
	}
	
	function partner()
	{
		$partners = $this->aModel->getPartnersToActivate();
		
		$this->layout('admin', 'admin/activation/partners_view', array('partners' => $partners), $this->lang->line('activate_partners_title'));
	}
	
	function video()
	{
		$video = $this->activation_model->getVideoToActivate();
		
		$this->layout('admin', 'admin/activation/video_view', array('videos' => $video), $this->lang->line('activate_video_title'));
	}
	
	function rt($more = null, $id = null)
	{
		if ($more == null && $id == null)
		{
			$rt = $this->aModel->getRtToActivate();
		
			$this->layout('admin', 'admin/activation/rt_view', array('rt' => $rt), $this->lang->line('active_rt_title'));
		}
	}
	
	function broadcast()
	{
		$broadcast = $this->activation_model->getBroadcastToActivate();
		
		$this->layout('admin', 'admin/activation/broadcast_view', array('broadcast' => $broadcast), 'Модерация массовых рассылок');
	}
	
	
	function ajax($action)
	{
		if ($action == 'gift_approve')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$hash = $this->input->post('id');
				
				if ($this->aModel->approveGift($hash) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'avatar_approve')
		{
			if (IS_AJAX)
			{
				$info = $this->mainModel->getUserProfile($this->input->post('id'));
				$this->db->update('user_profile', array('photo_link' => $info['avatar_act'], 'avatar_act' => ''), array('id' => $info['id']));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'avatar_cancel')
		{
			if (IS_AJAX)
			{
				$this->db->update('user_profile', array('avatar_act' => ''), array('id' => $this->input->post('id')));
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'video_approve')
		{
			if (IS_AJAX && $this->input->post('name'))
			{
				$this->activation_model->approveVideo($this->input->post('name'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'broadcast_approve')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$this->_broadcast($this->input->post('id'));
				$this->activation_model->approveBroadcast($this->input->post('id'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'broadcast_cancel')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$this->activation_model->approveBroadcast($this->input->post('id'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'video_cancel')
		{
			if (IS_AJAX && $this->input->post('name'))
			{
				$this->activation_model->cancelVideo($this->input->post('name'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'gift_cancel')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$hash = $this->input->post('id');
				$gift = $this->aModel->getGiftInfo($hash);
				
				$message = array(
						'to_id'		=> $gift['p_id'],
						'message'	=> sprintf($this->lang->line('gift_message'), $this->all_gifts->returnGiftName($gift['gift']), date('d.m.Y', $gift['add_date'])),
						'msg_date'	=> time(),
						'subject'	=> $this->lang->line('gift_msg_title'),
						'hash'		=> md5(time() . $gift['p_id'])
				);
				$this->aModel->sendPartnerMessage($message);
				
				if ($this->aModel->cancelGift($hash) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'anket_approve')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				if ($this->aModel->approveAnket($this->input->post('id')) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'anket_cancel')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$id = $this->input->post('id');
				
				$info = $this->mainModel->getUserProfile($id);
				
				$message = array (
					'to_id'		=> $info['is_agency'],
					'message'	=> sprintf($this->lang->line('anket_message'), $info['name'], $info['lastname']),
					'msg_date'	=> time(),
					'subject'	=> $this->lang->line('anket_msg_title'),
					'hash'		=> md5(time() . $info['is_agency'])
				);
				$this->aModel->sendPartnerMessage($message);
				
				if ($this->aModel->cancelAnket($id) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'partner_approve')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$this->aModel->approvePartner($this->input->post('id'));
				
				echo json_encode(array('result' => 'success'));
				
			}
		}
		
		elseif ($action == 'partner_cancel')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$p_id = $this->input->post('id');
				
				$message = array(
					'to_id'		=> $p_id,
					'message'	=> $this->lang->line('partner_message'),
					'msg_date'	=> time(),
					'subject'	=> $this->lang->line('partner_msg_title'),
					'hash'		=> md5(time() . $p_id)
				);
				$this->aModel->sendPartnerMessage($message);
				
				if ($this->aModel->cancelPartner($p_id) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
			}
		}
		
		elseif ($action == 'rt_approve')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$this->aModel->approveRt($this->input->post('id'));
				
				echo json_encode(array('result' => 'success'));
			}
		}
		
		elseif ($action == 'rt_cancel')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$tour_id = $this->input->post('id');
				
				$p_id = $this->aModel->getPartnerByTour($tour_id);
				
				$message = array (
					'to_id'		=> $p_id,
					'message'	=> sprintf($this->lang->line('tour_message'), $tour_id),
					'msg_date'	=> time(),
					'subject'	=> $this->lang->line('tour_msg_title'),
					'hash'		=> md5(time() . $p_id)
				);
				$this->aModel->sendPartnerMessage($message);
				
				$this->aModel->cancelRt($tour_id);
				echo json_encode(array('result' => 'success'));
			}
		}
	}
	
	protected function _broadcast($user_id)
	{
		$this->load->model('search_model', 'sModel');
		$this->lang->load('english/search');
		
		$info = $this->db->get_where('user_broadcast', array('user_id' => $user_id))->row_array();
		$user = $this->mainModel->getUserProfile($user_id);
		
		$options = json_decode(base64_decode($info['search']), true);
		
		if ($info['to_id'] < 1)
		{
			$ankets = $this->sModel->startSearch($options, 1, 400);
			
			foreach ($ankets as $anket)
			{
				$message = array(
					'from_user_id' => $info['user_id'],
					'to_user_id' => $anket['id'],
					'subject' => sprintf($this->lang->line('broadcast_subject'), $user['name']),
					'message' => $info['message'],
					'msg_date' => time(),
				);
				
				if ($info['attach'] != '')
				{
					$message['attachment'] = $info['attach'];
					$message['attach_server'] = 1;
				}
					
				$this->sModel->sendBroadcastMessage($message);
			}
		}
		else
		{
			$message = array(
				'from_user_id' => $info['user_id'],
				'to_user_id' => $info['to_id'],
				'subject' => sprintf($this->lang->line('broadcast_subject'), $this->userInfo['name']),
				'message' => $info['message'],
				'msg_date' => time(),
			);
					
			$this->sModel->sendBroadcastMessage($message);
		}
	}
}
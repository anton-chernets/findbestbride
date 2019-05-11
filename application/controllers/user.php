<?php

/***** Страницы пользователей 
 * роутинг в config/route.php
 */

Class User extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->lang->load($this->language . '/profile');
		$this->load->model('user_model', 'user');
		
		if ($this->isAuth != true)
		{
			show_error($this->lang->line('user_need_login'));
			die;
		}
		
		$this->load->library('assistant');
	}
	
	function index($action, $id)
	{
		if ($action == 'id' && intval($id))
		{
			$isExist = $this->mainModel->isExistUser($id);
			
			if ($isExist['is_exist'] == true)
			{
				// мужчина
				if ($isExist['sex'] == 1)
				{
					$info = $this->user->getManProfile($id);
					$photo = $this->user->getUserPhoto($id);
					
					if ($info['user_status'] != '0')
					{
						show_error('This profile is deleted');
						return false;
					}
					
					$this->layout('profile', 'user/man_profile_view', array('info' => $info, 'photo' => $photo), $info['name']);
				}
				
				// девушка
				elseif ($isExist['sex'] == 2)
				{
					$info = $this->user->getWomenProfile($id);
					$photo = $this->user->getUserPhoto($id);
					$video = $this->user->womenVideo($id);
					//////// favorite check
					if ($this->user->checkUserFavorite($id, $this->selfId) != false && $this->userInfo['sex'] == 1)
					{
						$showFavorite = true;
					}
					else
					{
						$showFavorite = false;
					}
					/// contacts check
					if ($this->user->checkContactReq($this->selfId, $id) != false && $this->userInfo['sex'] == 1)
					{
						$showReq = true;
					}
					else 
					{
						$showReq = false;
					}
					/// romance tour check
					if ($this->user->checkRt($this->selfId, $id) != false && $this->userInfo['sex'] == 1)
					{
						$showRt = true;
					}
					else
					{
						$showRt = false;
					}
					
					if ($info['user_status'] != '0')
					{
						show_error('This profile is deleted');
						return false;
					}
					
					$this->layout('profile', 'user/women_profile_view', array('video' => $video, 'rt' => $showRt, 'favorite' => $showFavorite, 'req' => $showReq, 'photo' => $photo, 'info' => $info), $info['name']);
				}
			}
			else
			{
				show_error($this->lang->line('user_not_exist'));
			}
		}
		else
		{
			show_404();
		}
	}
	
	
	
	function ajax($action)
	{
		if ($action == 'contact')
		{
			/* Запрос контактов девушки */

			if (IS_AJAX && $this->input->post('id'))
			{
				$id = (int)$this->input->post('id');

				if ($this->userInfo['credits'] >= 55)
				{
					$this->user->sendContactRequest($id, $this->selfId);
					
					$newCred = $this->userInfo['credits'] - $this->prices->get('CONTACTS');
					$this->mainModel->updateCredits($this->selfId, $newCred);
					
					// зачисление вознаграждения партнеру если девушка пришла от него
					$girl = $this->mainModel->getUserProfile($id);
					
					if ($girl['is_agency'] != '0')
					{
						$insert = array(
							'partner_id'	=> $girl['is_agency'],
							'm_date'		=> time(),
							'm_name'		=> 'contacts request',
							'm_message'		=> 'approved request from ' . $this->selfId . ' to ' . $girl['id'],
							'm_price'		=> $this->prices->get('CONTACTS_PARTNER'),
							'from_girl'		=> $girl['id'],
							'from_man'		=> $this->selfId
						);
						
						$this->mainModel->addPartnerMoney($insert);
					}
					
					echo json_encode(array('result' => 'success', 'message' => $this->lang->line('user_contact_sent')));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('user_contact_error')));
				}
			}
		}
		
		elseif ($action == 'favorite')
		{
			/* Добавление в закладки */
			if (IS_AJAX && $this->input->post('id'))
			{
				$id = (int)$this->input->post('id');
				
				if ($this->user->addFavorite($id, $this->selfId) != false)
				{
					echo json_encode(array('result' => 'success', 'message' => $this->lang->line('user_favorite_added')));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('user_favorite_error')));
				}
			}
		}
		
		elseif ($action == 'rt')
		{
			/* Запрос на приезд к девушке */
			if (IS_AJAX && $this->input->post('id'))
			{
				$id = (int)$this->input->post('id');
				
				if ($this->user->sendRt($this->selfId, $id) != false)
				{
					echo json_encode(array('result' => 'success', 'message' => $this->lang->line('user_rt_send')));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('user_rt_error')));
				}
			}
		}
		
		elseif ($action == 'video')
		{
			/* Запрос на просмотр видео */
			if (IS_AJAX && $this->input->post('pay'))
			{
				if ($this->user->openVideo($this->selfId) != false)
				{
					$this->mainModel->creditsLog($this->selfId, $this->prices->get('VIDEO'), 'view videopresentation');
					$id = (int)$this->input->post('id');
					$girl = $this->mainModel->getUserProfile($id);
					
					if ($girl['is_agency'] != '0')
					{
						$insert = array(
							'partner_id'	=> $girl['is_agency'],
							'm_date'		=> time(),
							'm_name'		=> 'presentation view',
							'm_message'		=> 'viewed video presentation by ' . $this->selfId . ' of ' . $girl['id'],
							'm_price'		=> $this->prices->get('VIDEO_PARTNER'),
							'from_girl'		=> $girl['id'],
							'from_man'		=> $this->selfId
						);
						
						$this->mainModel->addPartnerMoney($insert);	
					}
					
					echo json_encode(array('result' => 'success'));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('user_not_credits')));
				}
			}
		}
	}
}
<?php

Class Letters extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth != true)
		{
			redirect(base_url());
			exit;
		}
		
		$this->lang->load($this->language . '/profile');
		$this->load->model('messages_model', 'msgModel');
		$this->load->library(array('pagination', 'editor', 'notification'));
		$this->load->helper('create_avatars');
		
		$this->price = $this->prices->get('LETTER');
		$this->priceAgency = $this->prices->get('LETTER_PARTNER');
	}
	
	/********************* В Х О Д Я Щ И Е ********************************/
	function index()
	{
		// PAGINATION
		$pag['base_url'] = base_url() . 'my/letters/index/';
		$pag['total_rows'] = $this->msgModel->inboxCount($this->selfId);
		$pag['per_page'] = 10;
		$pag['num_links'] = 1;
		$pag['uri_segment'] = 4;
		$pag['full_tag_open'] = '<div id="page">';
		$pag['full_tag_close']= '</div>';
		$pag['next_link']	= 'Next';
		$pag['prev_link']	= 'Prev';
		$pag['cur_tag_open'] = '<a href="#." class="numb"><p><b>';
		$pag['cur_tag_close']= '</b></p></a>';
		
		$this->pagination->initialize($pag);
		
		$links = $this->pagination->create_links();
		
		$nowPage = ($this->uri->segment(4) && $this->uri->segment(4) > 0) ? (int)$this->uri->segment(4) : '0';
		
		// получим список входящих
		$inbox = $this->msgModel->getInboxMessages($this->selfId, $nowPage, $pag['per_page']);
		////////////////////////////
		
		$this->layout('profile', 'profile/messages/index_view', array('links' => $links, 'result' => $inbox), $this->lang->line('letters_title'));
	}
	/*********************************************************************/
	
	/************************ И С Х О Д Я Щ И Е **************************/
	function outbox($action = false, $id = false)
	{
		if ($action == false)
		{
			// pagination
			$pag['base_url'] = base_url() . 'my/letters/outbox/';
			$pag['total_rows'] = $this->msgModel->outboxCount($this->selfId);
			$pag['per_page'] = 10;
			$pag['num_links'] = 1;
			$pag['uri_segment'] = 4;
			$pag['full_tag_open'] = '<div id="page">';
			$pag['full_tag_close']= '</div>';
			$pag['next_link']	= 'Next';
			$pag['prev_link']	= 'Prev';
			$pag['cur_tag_open'] = '<a href="#." class="numb"><p><b>';
			$pag['cur_tag_close']= '</b></p></a>';

			$this->pagination->initialize($pag);
		
			$links = $this->pagination->create_links();
		
			$nowPage = ($this->uri->segment(4) && $this->uri->segment(4) > 0) ? (int)$this->uri->segment(4) : '0';
		
			// список исходящих (даже те, которые получатель удалил).
			// прочитанные и непрочитанные отмечаем разными стилями
			$outbox = $this->msgModel->getOutboxMessages($this->selfId, $nowPage, $pag['per_page']);
		
			//////////////
			$this->layout('profile', 'profile/messages/outbox_view', array('links' => $links, 'result' => $outbox), $this->lang->line('letters_title'));
		}
		// чтение исходящего сообщения
		elseif ($action != false && $id != false && $action == 'read' && $id > 0)
		{
			$info = $this->msgModel->getMyMessage($id, $this->selfId);
			
			if ($info === false)
			{
				show_404();
				return false;
			}
			else
			{
				$this->layout('profile', 'profile/messages/outbox_read_view', array('info' => $info), $this->lang->line('letters_title'));
			}
		}
	}
	/*********************************************************************************/
	
	/**************************** ОТ АДМИНИСТРАЦИИ ******************************/
	
	function admin_messages($action = false, $id = false)
	{
		// PAGINATION
		$pag['base_url'] = base_url() . 'my/letters/index/';
		$pag['total_rows'] = $this->msgModel->adminMsgCount($this->selfId);
		$pag['per_page'] = 10;
		$pag['num_links'] = 1;
		$pag['uri_segment'] = 4;
		$pag['full_tag_open'] = '<div id="page">';
		$pag['full_tag_close']= '</div>';
		$pag['next_link']	= 'Next';
		$pag['prev_link']	= 'Prev';
		$pag['cur_tag_open'] = '<a href="#." class="numb"><p><b>';
		$pag['cur_tag_close']= '</b></p></a>';
		
		$this->pagination->initialize($pag);
		
		$links = $this->pagination->create_links();
			
		$nowPage = ($this->uri->segment(4) && $this->uri->segment(4) > 0) ? (int)$this->uri->segment(4) : '0';
		
		$list = $this->msgModel->getAdminMessages($this->selfId, $nowPage, $pag['per_page']);
		
		$this->layout('profile', 'profile/messages/admin_letters_view', array('result' => $list, 'links' => $links), $this->lang->line('letters_title'));
	}
	/*********************************************************************************/
	
	/******************************* НОВОЕ СООБЩЕНИЕ *********************************/
	function write($action, $to_id)
	{
		$resInfo = '';
		$msg = '';
		$subj = '';
		
		if ($action == 'new' && $to_id && $to_id > 0)
		{
			// отправка сообщения 
			if ($this->input->post('writeLetter'))
			{
				$send = 1;
				$attachImage = '';
				
				$rules = array(
					array (
						'field'	=> 'to_user_id',
						'label' => 'Recipient',
						'rules' => 'required|integer'
					),
					array (
						'field' => 'subject',
						'label' => 'Subject',
						'rules' => 'required|xss_clean'
					),
					array (
						'field' => 'new_msg',
						'label' => 'Message',
						'rules' => 'required'
					)
				);
				
				$this->form_validation->set_rules($rules);
				// если юзер все правильно заполнил
				if ($this->form_validation->run() != false)
				{
					$to_user_id = $this->input->post('to_user_id');
					$subject = $this->editor->parse_message($this->input->post('subject'));
					$message = $this->editor->parse_message($this->input->post('new_msg'));
					
					// если прикрепили изображение к письму
					if ($_FILES['userfile'])
					{
						$upload['upload_path'] = './profiles/attachments/';
						$upload['allowed_types'] = 'jpg|jpeg';
						$upload['max_size']	= 1024 * 5;
						$upload['encrypt_name'] = true;
					
						$this->load->library('upload', $upload);
					
						if ($this->upload->do_upload())
						{
							set_time_limit(0);
							ignore_user_abort(1);
						
							$data = $this->upload->data();
						
							// создадим миниатюру изображения
							$settings = array (
								'thumbs' => array (
									array ('w' => '100', 'h' => '100', 'name' => $data['raw_name'] . '_prev', 'ext' => '.jpg', 'crop' => true)
								),
								'newimg' => array (
									array('max_w' => '640', 'max_h' => '99999', 'name' => $data['raw_name'] . '_orig')
								),
								'crop' => true,
								'newimg_folder' => $data['file_path'],
								'thumb_folder' => $data['file_path'],
								'saveThumb'	=> '1',
								'saveNewImg' => '1'
							);
						
							$create = createAvatar($data['full_path'], $settings);	
							
							// сохраняем миниатюру и обрезаный оригинал
							// оригинал который грузил юзер удаляем
							if ($create[0] === true)
							{
								unlink($data['full_path']);
								$attachImage = $data['raw_name'];
							}					
						}
					}
					
					// формируем новое сообщение
					$newMessage = array(
						'from_user_id'	=> $this->selfId,
						'to_user_id'	=> $to_user_id,
						'subject'		=> $subject,
						'message'		=> $message,
						'msg_date'		=> time()
					);
					// если прикреплено изображение - прилепим его к сообщению
					if ($attachImage != '')
					{
						$newMessage['attachment'] = $attachImage;
					}
					
					// если отправитель мужчина - проверяем кол-во кредитов на счету
					// если недостаточно - не даем отправить письмо, если достаточно
					// при отправке снимаем нужную сумму
					if ($this->userInfo['sex'] == 1 && $this->userInfo['credits'] < $this->price)
					{
						$send = 0;
						// если запрещаем отправлять сообщение, то и вложения удаляем (если они есть)
						if ($attachImage != '')
						{
							unlink('./profiles/attachments/' . $data['raw_name'] . '_prev.jpg');
							unlink('./profiles/attachments/' . $data['raw_name'] . '_orig.jpg');
						}
					}
					
					// отправляем...
					if ($send == 1)
					{
						// снимаем кредиты у мужчины...
						if ($this->userInfo['sex'] == 1)
						{
							$newCred = $this->userInfo['credits'] - $this->price;
							$this->mainModel->updateCredits($this->selfId, $newCred);
							$this->mainModel->creditsLog($this->selfId, $this->price, 'send letter');
							$this->userInfo['credits'] = $newCred;
						}
						
						// проверяем кому отправляем. Если мужчине и у него
						// включены уведомления в настройках - отправляем ему
						// письмо о новом сообщении на мыло
						$toProfile = $this->mainModel->getUserProfile($to_user_id);
						
						if ($toProfile['sex'] == 1 && $toProfile['email_notification'] == 1)
						{
							$this->notification->send('letter', $toProfile['email'], array('name' => $this->userInfo['name'], 'lastname' => $this->userInfo['lastname'], 'subject' => $subject));
						}
						
						$this->msgModel->sendNewMessage($newMessage);
						
						$this->mainModel->insertLog($this->selfId, '1', 'Send message to user ['.$to_user_id.'], message: ' . $message);
						
						$resInfo = array ('type' => 'success', 'message' => $this->lang->line('letters_sent'));
					}
					else
					{
						$resInfo = array ('type' => 'error', 'message' => $this->lang->line('letters_no_creds'));
						$msg = $message;
						$subj = $subject;
					}
				}
				else
				{
					$resInfo = array ('type' => 'error', 'message' => $this->lang->line('letters_no_info'));
					$msg = $this->input->post('new_msg');
					$subj = $this->input->post('subject');
				}
			}
			// проверим существует ли пользователь, которому пытаются отправить месседж
			$toUser = $this->mainModel->getUserProfile($to_id);
			if ($toUser != false)
			{
	
				$this->layout('profile', 'profile/messages/write_new_view', array('subj' => $subj, 'msg' => $msg, 'user' => $toUser, 'resInfo' => $resInfo), $this->lang->line('letters_title'));
			}
			// если не сущесвует - отдадим 404 ошибку
			else 
			{
				show_404();
			}
		}
		
	}
	/*********************************************************************************/
	
	
	/******************************** Ч Т Е Н И Е *************************************/
	// также ответ
	function read($msg_id)
	{
		$resInfo = '';
		// отправка ответа
		if ($this->input->post('reMessage'))
		{
			$send = 1;
			$subject = $this->input->post('subject');
			$id = $this->input->post('msg_id');
			$attachImage = '';
			if ($this->msgModel->isUserMsg($id, $this->selfId) === true)
			{
				$info = $this->msgModel->getMessage($id, $this->selfId);
				// если прикрепили изображение
				if ($_FILES['userfile'])
				{
					$upload['upload_path'] = './profiles/attachments/';
					$upload['allowed_types'] = 'jpg|jpeg';
					$upload['max_size']	= 1024 * 5;
					$upload['encrypt_name'] = true;
					
					$this->load->library('upload', $upload);
					
					if ($this->upload->do_upload())
					{
						set_time_limit(0);
						ignore_user_abort(1);
						
						$data = $this->upload->data();
						//print_r($uData);
						
						// создадим миниатюру изображения
						$settings = array (
							'thumbs' => array (
								array ('w' => '100', 'h' => '100', 'name' => $data['raw_name'] . '_prev', 'ext' => '.jpg', 'crop' => true)
							),
							'newimg' => array (
								array('max_w' => '640', 'max_h' => '99999', 'name' => $data['raw_name'] . '_orig')
							),
							'crop' => true,
							'newimg_folder' => $data['file_path'],
							'thumb_folder' => $data['file_path'],
							'saveThumb'	=> '1',
							'saveNewImg' => '1'
						);
						
						$create = createAvatar($data['full_path'], $settings);	
						
						if ($create[0] === true)
						{
							unlink($data['full_path']);
							$attachImage = $data['raw_name'];
						}
					}
				}
				
				// формируем и отправляем новое сообщение (ответ)
				
				$newMessage = array (
					'from_user_id'	=> $this->selfId,
					'to_user_id'	=> $info['from_user_id'],
					'subject'		=> $subject,
					'message'		=> $this->editor->parse_message($this->input->post('new_msg', true)),
					'msg_date'		=> time()
				);
				
				if ($attachImage != '')
				{
					$newMessage['attachment'] = $attachImage;
				}
				
				// если у мужчины недостаточно кредитов - не даем отправить сообщение и удаляем вложение
				if ($this->userInfo['sex'] == 1 && $this->userInfo['credits'] < $this->price)
				{
					$send = 0;
					if ($attachImage != '')
					{
						unlink('./profile/attachments/' . $data['raw_name'] . '_orig.jpg');
						unlink('./profile/attachments/' . $data['raw_name'] . '_prev.jpg');
					}
				}
				
				if ($send != 0)
				{
					$this->msgModel->sendNewMessage($newMessage);
				
					// Если пользователь мужчина, и отправляет письмо - снимаем оплату за сообщение
					if ($this->userInfo['sex'] == 1)
					{
						$newCred = $this->userInfo['credits'] - $this->price;
						$this->mainModel->updateCredits($this->selfId, $newCred);
						$this->mainModel->creditsLog($this->selfId, $this->price, 'send letter');
						$this->userInfo['credits'] = $newCred;
					}
					
					// проверяем кому отправляем. Если мужчине и у него
					// включены уведомления в настройках - отправляем ему
					// письмо о новом сообщении на мыло
					$toProfile = $this->mainModel->getUserProfile($newMessage['to_user_id']);
					
					if ($toProfile['sex'] == 1 && $toProfile['email_notification'] == 1)
					{
						$this->notification->send('letter', $toProfile['email'], array('name' => $this->userInfo['name'], 'lastname' => $this->userInfo['lastname'], 'subject' => $subject));
					}
					
					$this->mainModel->insertLog($this->selfId, '1', 'Send message to user ['.$info['from_user_id'].'], message: '.$this->input->post('new_msg', true));
					
					$resInfo = array('type' => 'success', 'message' => $this->lang->line('letters_sent'));

				}
				else
				{
					$resInfo = array('type' => 'error', 'message' => $this->lang->line('letters_no_creds'));
				}	
			}
		}
		///////////////////////////////////////////////
		if ($msg_id && intval($msg_id) && $msg_id > 0)
		{
			$info = $this->msgModel->getMessage($msg_id, $this->selfId);
			// если пытаются прочитать чужое сообщение - выгоним
			if ($info === false)
			{
				show_404();
				return false;
			}
			// если свое - отдаем
			else 
			{
				$this->layout('profile', 'profile/messages/read_view', array('resInfo' => $resInfo, 'info' => $info), $this->lang->line('letters_title'));
			}
		}
		else
		{
			show_404();
		}
	}
	/*********************************************************************************/
	
	/***************************** A J A X ********************************/
	function ajax($action)
	{
		if ($action == 'mark_read')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$msg_id = $this->input->post('id');
				
				if ($this->msgModel->markMessageRead($msg_id, $this->selfId) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('letters_error')));
				}
			}
		}
		elseif ($action == 'delete')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$msg_id = $this->input->post('id');
				
				$this->msgModel->deleteMessage($msg_id, $this->selfId);
				
				echo json_encode(array('result' => 'success'));
			}
		}
		elseif ($action == 'my_delete')
		{
			if (IS_AJAX && $this->input->post('id'))
			{
				$msg_id = $this->input->post('id');
				
				if ($this->msgModel->deleteMyMessage($msg_id, $this->selfId) != false)
				{
					echo json_encode(array('result' => 'success'));
				}
				else
				{
					echo json_encode(array('result' => 'error', 'message' => $this->lang->line('letters_error')));
				}
			}
		}
	}
}
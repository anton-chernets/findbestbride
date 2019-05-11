<?php

/*********************** П О И С К ***************************/

Class Search extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('search_model', 'sModel');
		$this->lang->load($this->language . '/search');
		$this->load->library('assistant');
		$this->load->helper('form');
	}
	
	function index()
	{
		$result = '';
		$height = $this->_createHeight();
		$weight = $this->_createWeight();
		
		/*************** ПОИСК ИЗ ГЛАВНОЙ СТРАНИЦЫ **********************/
		if ($this->input->post('main_search'))
		{
			if (!$this->input->post('by_id'))
			{	
				$age_from = ($this->input->post('age_from')) ? $this->input->post('age_from') : '18';
				$age_to	 = ($this->input->post('age_to')) ? $this->input->post('age_to') : '80';
				
				$search = $this->sModel->searchByAge($age_from, $age_to);
			}
			else
			{
				$id = (int)$this->input->post('by_id');
				$search = $this->sModel->searchById($id);
			}
			
			$count = count($search);
			
			if ($count < 1)
			{
				$result = array('type' => 'error', 'message' => $this->lang->line('search_no_result'));
				$this->layout('content', 'content/search_view', array('height_f' => $height['from'], 'height_t' => $height['to'], 'weight_f' => $weight['from'], 'weight_t' => $weight['to'], 'result' => $result), $this->lang->line('search'));
				return false;
			}
			else
			{				
				$this->layout('content', 'content/search_result_view', array('list' => $search), $this->lang->line('search'));
				return false;
			}
		}
		/*********************************************************************/
		/**************************** П О И С К ******************************/
		if ($this->input->post('new_search') && $this->input->post('broadcast') == 0)
		{
			// поиск только по айди
			if ($this->input->post('id'))
			{
				$result = $this->sModel->searchById($this->input->post('id'));
				$count = count($result);
				
				if ($result != false)
				{
					$fRow = $result;
				}
				else
				{
					$result = array('type' => 'error', 'message' => $this->lang->line('search_no_result'));
					$this->layout('content', 'content/search_view', array('height_f' => $height['from'], 'height_t' => $height['to'], 'weight_f' => $weight['from'], 'weight_t' => $weight['to'], 'result' => $result), $this->lang->line('search'));
					return false;		
				}
			}
			// поиск по остальным параметрам
			// если по айди ищет и мужчин и женщин, то здесь ТОЛЬКО женщины
			else
			{
				$options = array(
					'age_from' 	=> '',
					'age_to'	=> '',
					'marital'	=> '',
					'english' 	=> '',
					'eyes'		=> '',
					'hair'		=> '',
					'religion'	=> '',
					'child'		=> '',
					'country'	=> '',
					'city'		=> '',
					'h_from'	=> '',
					'h_to'		=> '',
					'w_from'	=> '',
					'w_to'		=> '',
					'online'	=> false
				);
				//////////////////////////////////////////////////////
				// возраст от-до
				if ($this->input->post('age_from'))
				{
					$options['age_from'] = $this->input->post('age_from');
				}
				if ($this->input->post('age_to'))
				{
					$options['age_to'] = $this->input->post('age_to');
				}
				// marital status
				if ($this->input->post('marital_status'))
				{
					$options['marital'] = $this->input->post('marital_status');
				}
				// english level
				if ($this->input->post('english'))
				{
					$options['english'] = $this->input->post('english');
				}
				// eyes
				if ($this->input->post('eyes_color'))
				{
					$options['eyes'] = $this->input->post('eyes_color');
				}
				// hair
				if ($this->input->post('hair_color'))
				{
					$options['hair'] = $this->input->post('hair_color');
				}
				// religion
				if ($this->input->post('religion'))
				{
					$options['religion'] = $this->input->post('religion');
				}
				// children
				if ($this->input->post('children'))
				{
					$options['child'] = $this->input->post('children');
				}
				// strana
				if ($this->input->post('country') > '0')
				{
					$options['country'] = $this->input->post('country');
				}
				// gorod
				if ($this->input->post('city'))
				{
					$options['city'] = $this->input->post('city');
				}
				// height from-to
				if ($this->input->post('height_from'))
				{
					$options['h_from'] = $this->input->post('height_from');
				}
				if ($this->input->post('height_to'))
				{
					$options['h_to'] = $this->input->post('height_to');
				}
				// weight from-to
				if ($this->input->post('weight_from'))
				{
					$options['w_from'] = $this->input->post('weight_from');
				}
				if ($this->input->post('weight_to'))
				{
					$options['w_to'] = $this->input->post('weight_to');
				}
				if ($this->input->post('user_online'))
				{
					$options['online'] = true;
				}
				
				$search_sex = '2';
				// установка по кому будем искать (мужчина-девушка)
				if ($this->isAuth != false)
				{
					if ($this->userInfo['sex'] == 1)
					{
						$search_sex = '2';
					}
					elseif ($this->userInfo['sex'] == 2)
					{
						$search_sex = '1';
					}
				}
				
				$result = $this->sModel->startSearch($options, $search_sex);
				$count = count($result);
				
				// если результатов нет
				if ($count == 0)
				{
					$result = array('type' => 'error', 'message' => $this->lang->line('search_no_result'));
					$this->layout('content', 'content/search_view', array('height_f' => $height['from'], 'height_t' => $height['to'], 'weight_f' => $weight['from'], 'weight_t' => $weight['to'], 'result' => $result), $this->lang->line('search'));
					return false;
				}
			}
			
			$this->layout('content', 'content/search_result_view', array('list' => $result), $this->lang->line('search'));
			return false;
			
		}
		elseif ($this->input->post('new_search') && $this->input->post('broadcast') == 1)
		{
			// поиск только по айди
			if ($this->input->post('id'))
			{
				$result = $this->sModel->searchById($this->input->post('id'));
				
				if ($result != false)
				{
					$count = 1;
					$this->session->set_userdata('broadcast_to_id', '1');
					$this->session->set_userdata('broadcast_id', $this->input->post('id'));
				}
				else
				{
					$result = array('type' => 'error', 'message' => $this->lang->line('search_no_result'));
					$this->layout('content', 'content/search_view', array('height_f' => $height['from'], 'height_t' => $height['to'], 'weight_f' => $weight['from'], 'weight_t' => $weight['to'], 'result' => $result), $this->lang->line('search'));
					return false;		
				}
			}
			// поиск по остальным параметрам
			// если по айди ищет и мужчин и женщин, то здесь ТОЛЬКО женщины
			else
			{
				$options = array(
					'age_from' 	=> '',
					'age_to'	=> '',
					'marital'	=> '',
					'english' 	=> '',
					'eyes'		=> '',
					'hair'		=> '',
					'religion'	=> '',
					'child'		=> '',
					'country'	=> '',
					'city'		=> '',
					'h_from'	=> '',
					'h_to'		=> '',
					'w_from'	=> '',
					'w_to'		=> '',
					'online'	=> false
				);
				//////////////////////////////////////////////////////
				// возраст от-до
				if ($this->input->post('age_from'))
				{
					$options['age_from'] = $this->input->post('age_from');
				}
				if ($this->input->post('age_to'))
				{
					$options['age_to'] = $this->input->post('age_to');
				}
				// marital status
				if ($this->input->post('marital_status'))
				{
					$options['marital'] = $this->input->post('marital_status');
				}
				// english level
				if ($this->input->post('english'))
				{
					$options['english'] = $this->input->post('english');
				}
				// eyes
				if ($this->input->post('eyes_color'))
				{
					$options['eyes'] = $this->input->post('eyes_color');
				}
				// hair
				if ($this->input->post('hair_color'))
				{
					$options['hair'] = $this->input->post('hair_color');
				}
				// religion
				if ($this->input->post('religion'))
				{
					$options['religion'] = $this->input->post('religion');
				}
				// children
				if ($this->input->post('children'))
				{
					$options['child'] = $this->input->post('children');
				}
				// strana
				if ($this->input->post('country') > '0')
				{
					$options['country'] = $this->input->post('country');
				}
				// gorod
				if ($this->input->post('city'))
				{
					$options['city'] = $this->input->post('city');
				}
				// height from-to
				if ($this->input->post('height_from'))
				{
					$options['h_from'] = $this->input->post('height_from');
				}
				if ($this->input->post('height_to'))
				{
					$options['h_to'] = $this->input->post('height_to');
				}
				// weight from-to
				if ($this->input->post('weight_from'))
				{
					$options['w_from'] = $this->input->post('weight_from');
				}
				if ($this->input->post('weight_to'))
				{
					$options['w_to'] = $this->input->post('weight_to');
				}
				if ($this->input->post('user_online'))
				{
					$options['online'] = true;
				}
				
				$search_sex = '1';
				// установка по кому будем искать (мужчина-девушка)
				if ($this->isAuth != false)
				{
					if ($this->userInfo['sex'] == 1)
					{
						$search_sex = '2';
					}
					elseif ($this->userInfo['sex'] == 2)
					{
						$search_sex = '1';
					}
				}
				
				$result = $this->sModel->startSearch($options, $search_sex);
				$count = count($result);
				
				// если результатов нет
				if ($count == 0)
				{
					$result = array('type' => 'error', 'message' => $this->lang->line('search_no_result'));
					$this->layout('content', 'content/search_view', array('height_f' => $height['from'], 'height_t' => $height['to'], 'weight_f' => $weight['from'], 'weight_t' => $weight['to'], 'result' => $result), $this->lang->line('search'));
					return false;
				}
			}
			// занесем в сессию данные поиска
			$this->session->set_userdata('broadcast_search', base64_encode(json_encode($options)));
			
			$this->layout('content', 'content/broadcast_view', array('count' => $count), $this->lang->line('broadcast_title'));
			return false;
		}
		/*********************************************************************/
		// представление себя
		$is_broadcast = ($this->input->cookie('broadcast_yourself')) ? false : true;
		
		$this->layout('content', 'content/search_view', array('is_broadcast' => $is_broadcast, 'weight_f' => $weight['from'], 'weight_t' => $weight['to'], 'height_f' => $height['from'], 'height_t' => $height['to'], 'result' => $result), $this->lang->line('search'));
	}
	
	public function broadcast()
	{
		if ($this->input->post() && !$this->input->cookie('broadcast_yourself'))
		{
			$this->load->library('editor');
			$this->load->helper('create_avatars');
				
			$msg = $this->editor->parse_message($this->input->post('msg'));
			
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
			
			$insert = array(
					'user_id' => $this->selfId,
					'message' => $msg,
					'attach' => (!empty($attachImage)) ? $attachImage : '',
					'search' => $this->session->userdata('broadcast_search'),
					'to_id' => (!$this->session->userdata('broadcast_to_id')) ? '' : $this->session->userdata('broadcast_to_id')
			);
			$this->db->insert('user_broadcast', $insert);
			
			/*if (!$this->session->userdata('broadcast_to_id'))
			{
				//опции поиска
				$options = json_decode(base64_decode($this->session->userdata('broadcast_search')), true);
				//print_r($options);
				// поиск анкет
				$ankets = $this->sModel->startSearch($options, 1, 400);
				
				foreach ($ankets as $anket)
				{
					$message = array(
						'from_user_id' => $this->selfId,
						'to_user_id' => $anket['id'],
						'subject' => sprintf($this->lang->line('broadcast_subject'), $this->userInfo['name']),
						'message' => $msg,
						'msg_date' => time(),
					);
					
					$this->sModel->sendBroadcastMessage($message);
				}
				$this->session->unset_userdata('broadcast_search');
			}
			else 
			{
				$message = array(
					'from_user_id' => $this->selfId,
					'to_user_id' => (int)$this->session->userdata('broadcast_id'),
					'subject' => sprintf($this->lang->line('broadcast_subject'), $this->userInfo['name']),
					'message' => $msg,
					'msg_date' => time()
				);
				$this->sModel->sendBroadcastMessage($message);
				
				$this->session->unset_userdata(array('broadcast_to_id' => '', 'broadcast_id' => ''));
			}*/
			
			setcookie('broadcast_yourself', '1', time() + (3600 * 24), '/');
			
			$this->layout('content', 'content/broadcast_result_view', array(), $this->lang->line('broadcast_title'));
		}	
		else
		{
			redirect(site_url() . '/search/');
		}
	}
	
	function _createHeight($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => "4'7'' - 4'9'' (140-145 cm)",
			'2' => "4'10'' - 4'11'' (146-150 cm)",
			'3' => "5'0'' - 5'1'' (151-155 cm)",
			'4' => "5'2'' - 5'3'' (156-160 cm)",
			'5' => "5'4'' - 5'5'' (161-165 cm)",
			'6' => "5'6'' - 5'7'' (166-170 cm)",
			'7' => "5'8'' - 5'9'' (171-175 cm)",
			'8' => "5'10'' - 5'11'' (176-180 cm)",
			'9' => "6'0'' - 6'1'' (181-185 cm)",
			'10'=> "6'2'' - 6'3'' (186-190 cm)",
			'11'=> "6'4'' (191 cm) or above"
		);
		$class = 'class="select2"';
		
		$height1 = form_dropdown('height_from', $list, $selected, $class);
		$height2 = form_dropdown('height_to', $list, $selected, $class);
		
		return array('from' => $height1, 'to' => $height2);
	}
	
	
	
	
	function _createWeight($selected = 0)
	{
		$list = array (
			'0' => '',
			'1' => '45kg-50kg',
			'2' => '50kg-55kg',
			'3' => '55kg-60kg',
			'4' => '60kg-65kg',
			'5' => '65kg-70kg',
			'6' => '70kg-75kg',
			'7' => '75kg-80kg',
			'8' => '80kg-85kg',
			'9' => '85kg-90kg',
			'10'=> '90kg-95kg',
			'11'=> '95kg-100kg',
			'12'=> '100kg-105kg',
			'13'=> '105kg-110kg',
			'14'=> '110kg-115kg',
			'15'=> '115kg-120kg',
			'16'=> '120kg-125kg',
			'17'=> '125kg-130kg',
			'18'=> '130kg-135kg',
			'19'=> '135kg-140kg',
			'20'=> '140kg-145kg',
			'21'=> '145kg-150kg'
		);
		$class = 'class="select2"';
		
		$weight1 = form_dropdown('weight_from', $list, $selected, $class);
		$weight2 = form_dropdown('weight_to', $list, $selected, $class);
		
		return array('from' => $weight1, 'to' => $weight2);
	}
}
<?php

Class Gift extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->lang->load($this->language . '/profile');
		$this->load->model('profile_model', 'pModel');
		
		if ($this->isAuth == false)
		{
			redirect(base_url());
		}
		
		if ($this->isAuth != false && $this->userInfo['sex'] != 1)
		{
			redirect(base_url());
		}
	}
	
	function index($action, $id)
	{
		if ($action == 'id' && $id != '' && $id > 0)
		{
			$info = $this->pModel->getUserInfo($id);
			
			if ($info == false)
			{
				show_error($this->lang->line('gift_no_user'));
				return false;
			}
			else
			{
				$this->layout('profile', 'user/send_gift_view', array('info' => $info), sprintf($this->lang->line('gift_title'), $info['name']));
			}
		}
		else
		{
			show_404();
		}
	}
	
	function ajax()
	{
		if (IS_AJAX && $this->input->post('id') && $this->input->post('women'))
		{
			$women = $this->input->post('women');
			$giftId = $this->input->post('id');
			$count = ($this->input->post('count')) ? $this->input->post('count') : '0';
			$price = gift_price($giftId, $count);
			$womenProfile = $this->mainModel->getUserProfile($women);
			
			$data = array(
				'from_id'	=> $this->selfId,
				'to_id'		=> $women,
				'gift'		=> $giftId,
				'add_date'	=> time(),
				'price'		=> $price,
				'count'		=> $count,
				'gift_hash'	=> md5(time() . $this->selfId . $women)
			);
			
			if ($this->pModel->sendGift($data) == true)
			{
				if ($womenProfile['is_agency'] != 0)
				{
					$this->mainModel->insertPartnerGift($data['gift_hash'], $womenProfile['is_agency']);
				}
				
				$this->mainModel->insertLog($this->selfId, '1', sprintf($this->lang->line('log_send_gift'), $women));
				
				echo json_encode(array('result' => 'success', 'message' => $this->lang->line('gift_send_ok')));
			}
			else
			{
				echo json_encode(array('result' => 'error', 'message' => $this->lang->line('gift_send_error')));
			}
		}
	}
}
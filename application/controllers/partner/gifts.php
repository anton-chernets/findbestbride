<?php

Class Gifts extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if ($this->isPartAuth != true)
		{
			redirect(base_url() . 'login/partner');
			return false;
		}
		
		if ($this->partInfo['p_status'] != '2')
		{
			redirect(base_url() . 'partner/first');
			return false;
		}
		
		$this->load->model('partner/partner_model', 'pModel');
		$this->lang->load('english/partner');
		$this->load->library('all_gifts');
		
	}
	
	function index()
	{
		$resInfo = '';
		
		if ($this->input->post('gift'))
		{
			if ($_FILES['userfile'])
			{
				$hash						= $this->input->post('hash');
				$upload['upload_path'] 		= './profiles/partner/p_' . $this->partId . '/';
				$upload['allowed_types']	= 'jpg|jpeg';
				$upload['max_size']			= 1024 * 100;
				$upload['encrypt_name']		= true;
				
				$isDir = (file_exists($upload['upload_path'])) ? true : false;
				
				if ($isDir == false)
				{
					@mkdir($upload['upload_path'], 0777, true);
				}
				
				$this->load->library('upload', $upload);
				
				if ($this->upload->do_upload())
				{
					$data = $this->upload->data();
					
					$insert = array(
						'p_id'		=> $this->partId,
						'gift_hash'	=> $hash,
						'gift_image'=> $data['raw_name']
					);
					
					$this->pModel->approveGift($insert);
					
					$resInfo = array('result' => 'success', 'text' => $this->lang->line('partner_gift_app_ok'));
				}
			}
			else
			{
				$resInfo = array('result' => 'error',  'text' => $this->lang->line('partner_gift_nophoto'));
			}
		}
		
		
		$gifts = $this->pModel->agencyGifts($this->partId);
		
		$this->layout('partner', 'partner/gifts_view', array('gifts' => $gifts, 'resInfo' => $resInfo), $this->lang->line('partner_gift_title'));
	}
	
	
	function approve($g_hash)
	{
		if ($g_hash && $this->pModel->checkGiftByHash($g_hash, $this->partId) != false)
		{
			$gift = $this->pModel->getGiftInfo($g_hash);
			$this->layout('partner', 'partner/gift_approve_view', array('gift' => $gift), $this->lang->line('partner_gift_title'));
		}
	}
	
}
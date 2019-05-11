<?php

Class Payment extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('liqpay');
	}
	
	public function callback()
	{
		if ($this->input->post('data') && $this->input->post('signature'))
		{
			$info = json_decode(base64_decode($this->input->post('data')), true);
			//log_message('error', var_dump($info));
			$result = $this->liqpay->check_result($info, $this->input->post('signature'), $this->input->post('data'));			
			//$this->db->update('payment_log', array('other' => $info['status']), array('order_id' => $info['order_id']));
			if (!empty($result))
			{
				echo $result;
			}
		}
	}
}
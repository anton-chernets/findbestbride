<?php

Class Payment_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function createNewOrder($credits, $user_id, $amount)
	{
		$data = array (
			'id'		=> $user_id,
			'amount'	=> $amount,
			'credits'	=> $credits,
			'order_date'=> time()
		);
		
		$this->db->insert('user_payments', $data);
		
		return $this->db->insert_id();
	}
	
	function checkOrderId($order_id)
	{
		$query = $this->db->get_where('user_payments', array('order_id' => $order_id));
		
		if ($query->num_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function insertCredits($order_id)
	{
		// найдем пользователя и кол-во кредитов для зачисления с помощью номера заказа
		$info = $this->db->get_where('user_payments', array('order_id' => $order_id))->row_array();
		$user = $this->db->get_where('user_profile', array('id' => $info['id']))->row_array();
		
		$newCredits = $user['credits'] + $info['credits'];
		
		$this->db->update('user_profile', array('credits' => $newCredits), array('id' => $user['id']));
		$this->db->update('user_payments', array('order_status' => '1'), array('order_id' => $order_id));
	}
}
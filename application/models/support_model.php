<?php

Class Support_model extends CI_Model
{
	
	/***************** USER ********************/
	
	function createTicket($info)
	{
		$this->db->insert('support_tickets', $info);
	}
}
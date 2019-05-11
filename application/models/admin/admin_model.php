<?php

Class Admin_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function updateMainSettings($update)
	{
		$this->db->update('engine_settings', $update);
	}
	
	////////////////////////////////////////////
	// ÀÂÒÎÌÀÒÈ×ÅÑÊÀß ÎÒÏĞÀÂÊÀ ÑÎÎÁÙÅÍÈß ÏÀĞÒÍÅĞÀÌ
	function sendPartnerMessage($data)
	{
		$this->db->insert('user_partner_messages', $data);	
	}
	
	function sendUserMessage($data)
	{
		$this->db->insert('private_messages', $data);
	}
	
	///////////////////////////////////////////////
	// ÀÄÌÈÍÈÑÒĞÀÒÎĞÛ
	
	function getAdminList()
	{
		$this->db->order_by('id');
		$query = $this->db->get('user_admin');
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function deleteAdmin($id)
	{
		$this->db->delete('user_admin', array('id' => $id));
		
		return true;
	}
	
	function addNewAdmin($data)
	{
		$this->db->insert('user_admin', $data);
	}
	
	/////////////////////////////////////////////
	// ÀÊÒÈÂÀÖÈß
	
	function getGiftsToActivate()
	{
		$query = "
			SELECT
			gifts_wait_approve.*,
			women_gifts.*
			FROM gifts_wait_approve
			LEFT JOIN women_gifts ON women_gifts.gift_hash = gifts_wait_approve.gift_hash
			ORDER BY women_gifts.add_date
		";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function getAgencyName($p_id)
	{
		$query = $this->db->get_where('user_partner', array('id' => $p_id))->row_array();
		
		return $query['p_name'];
	}
	
	function deleteGift($hash)
	{
		$this->db->delete('gifts_wait_approve', array('gift_hash' => $hash));
	}
	
	function approveGift($hash)
	{
		$prices = array(
			'40'	=> '7',
			'50'	=> '9',
			'70'	=> '13',
			'80'	=> '15',
			'90'	=> '16',
			'100'	=> '18',
			'120'	=> '21', 
			'140'	=> '25',
			'150'	=> '27',
			'170'	=> '28',
			'190'	=> '30',
			'200'	=> '33',
			'220'	=> '35',
			'250'	=> '42',
			'300'	=> '51',
			'320'	=> '53',
			'330'	=> '54',
			'350'	=> '56',
			'400'	=> '63',
			'450'	=> '70',
			'900'	=> '130',
			'1400'	=> '170'
		);
		$gift = $this->db->get_where('women_gifts', array('gift_hash' => $hash))->row_array();
		$partner = $this->db->get_where('partner_gifts', array('gift_hash' => $hash))->row_array();
		
		// ñóììà ê îïëàòå
		$price = $prices[$gift['price']];
		// çà÷èñëåíèå ïàğòíåğó
		$money = array(
			'partner_id' => $partner['p_id'],
			'm_date' => time(),
			'm_name' => 'Gift',
			'm_message' => 'ID '.$gift['from_id'].' send gift to ID'.$gift['to_id'],
			'm_price' => $price,
			'from_girl' => $gift['to_id'],
			'from_man' => $gift['from_id']	
		);
		$this->db->insert('partner_money', $money);
		
		$this->db->update('women_gifts', array('status' => '1'), array('gift_hash' => $hash));
		$this->deleteGift($hash);
		
		return true;
	}
	
	function cancelGift($hash)
	{
		$this->db->update('women_gifts', array('status' => '0'), array('gift_hash' => $hash));
		$this->deleteGift($hash);
		
		return true;
	}
	
	function getGiftInfo($hash)
	{
		$query = "
			SELECT
			gifts_wait_approve.*,
			women_gifts.*
			FROM
			gifts_wait_approve
			LEFT JOIN women_gifts ON women_gifts.gift_hash = gifts_wait_approve.gift_hash
			WHERE
			gifts_wait_approve.gift_hash = ?
		";
		
		return $this->db->query($query, array($hash))->row_array();
	}
	
	// àíêåòû
	
	
	function cancelAnket($id)
	{
		$this->db->update('user_profile', array('user_status' => '1'), array('id' => $id));
		
		return true;
	}
	
	function approveAnket($id)
	{
		$this->db->update('user_profile', array('user_status' => '0'), array('id' => $id));
		
		return true;
	}
	
	// ïàğòíåğû
	
	function getPartnersToActivate()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get_where('user_partner', array('p_status' => '1'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function approvePartner($id)
	{
		$this->db->update('user_partner', array('p_status' => '2'), array('id' => $id));
		return true;
	}
	
	function cancelPartner($id)
	{
		$this->db->update('user_partner', array('p_status' => '0'), array('id' => $id));
		return true;
	}
	
	// ğîì. òóğû
	function getRtToActivate()
	{
		$this->db->order_by('tour_id', 'desc');
		$query = $this->db->get_where('romance_tours', array('status' => '0'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function getTourPhoto($id, $type)
	{
		$query = $this->db->get_where('user_partner_images', array('tour_id' => $id, 'photo_type' => $type));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return array();
	}
	
	function getPartnerByTour($tour_id)
	{
		$query = $this->db->get_where('romance_tours', array('tour_id' => $tour_id))->row_array();
		
		return $query['p_id'];
	}
	
	function approveRt($id)
	{
		$this->db->update('romance_tours', array('status' => '1'), array('tour_id' => $id));
		return true;
	}
	
	function cancelRt($id)
	{
		$this->db->update('romance_tours', array('status' => '2'), array('tour_id' => $id));
		return true;
	}
	
	/****************** ÇÀÏĞÎÑÛ *************************/
	// çàïğîñû êîíòàêòîâ
	function getContactsReq()
	{
		$this->db->order_by('req_date', 'desc');
		$query = $this->db->get('request_info');
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}	
		
		return false;
	}
	
	function checkContactReq($hash)
	{
		$this->db->update('request_info', array('status' => '1'), array('hash' => $hash));
	}
	
	function getContactReqInfo($hash)
	{
		return $this->db->get_where('request_info', array('hash' => $hash))->row_array();
	}
	
	function cancelContactReq($hash)
	{
		$this->db->delete('request_info', array('hash' => $hash));	
	}
	
	///////////////// çàïğîñû ğîì. òóğîâ
	function getRtReq()
	{
		$this->db->order_by('date', 'desc');
		$query = $this->db->get_where('rt_request', array('status' => '0'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function getRtInfo($id)
	{
		return $this->db->get_where('romance_tours', array('tour_id' => $id))->row_array();
	}
	
	function approveRtReq($hash)
	{
		$this->db->update('rt_request', array('status' => '1'), array('hash' => $hash));
	}
	
	/////////////////////////////////////
	// ÏÀĞÒÍÅĞÛ
	
	function insertNewPartner($data)
	{
		$this->db->insert('user_partner', $data);
	}
	
	
	// ñåëåêò âñåõ ïàğòíåğîâ
	function createPartnersList($selected = '-1')
	{
		$this->load->helper('html');
		
		$getPartners = $this->db->get_where('user_partner', array('p_status' => '2'));
		
		$return = array();
		$return['-1'] = 'Select partner';
		
		if ($getPartners->num_rows() > 0)
		{
			foreach($getPartners->result_array() as $row)
			{
				$return[$row['id']] = '[' . $row['id'] . '] ' . $row['p_name']; 
			}
		}
		return form_dropdown('p_id', $return, $selected, 'class="chzn-select" id="select01"');
	}
	
	// ñåëåêò âñåõ ïîëüçîâàòåëåé
	function createUserList()
	{
		$this->load->helper('html');
		
		$getUsers = $this->db->get_where('user_profile', array('user_status' => '0'));
		
		$return = array();
		$return['-1'] = 'Select user';
		
		if ($getUsers->num_rows() > 0)
		{
			foreach($getUsers->result_array() as $row)
			{
				$return[$row['id']] = '[' . $row['id'] . '] ' . $row['name'] .' ' . $row['lastname'];
			}
		}
		return form_dropdown('u_id', $return, '-1', 'class="chzn-select" id="select01"');
	}
	
	/**
	 * ÑÅËÅÊÒ ÂÑÅÕ ÏÎËÜÇÎÂÀÒÅËÅÉ ÂÊËŞ×Àß ÍÅ ÀÊÒÈÂÍÛÕ
	 * @return string
	 */
	function createAllUserList()
	{
		$this->load->helper('html');
		$this->db->where('user_status', '0');
		$this->db->or_where('user_status', '9');
		$getUsers = $this->db->get('user_profile');
	
		$return = array();
		$return['-1'] = 'Select user';
	
		if ($getUsers->num_rows() > 0)
		{
			foreach($getUsers->result_array() as $row)
			{
				$return[$row['id']] = '[' . $row['id'] . '] ' . $row['name'] .' ' . $row['lastname'];
			}
		}
		return form_dropdown('u_id', $return, '-1', 'class="chzn-select" id="select01"');
	}
	
	// ñåëåêò òîëüêî ÌÓÆ×ÈÍ
	
	function createMenList()
	{
		$this->load->helper('html');
		
		$getUsers = $this->db->get_where('user_profile', array('user_status' => '0', 'sex' => '1'));
		$return = array();
		$return['-1'] = 'Select user';
		
		if ($getUsers->num_rows() > 0)
		{
			foreach ($getUsers->result_array() as $row)
			{
				$return[$row['id']] = '[' . $row['id'] . '] ' . $row['name'] .' ' . $row['lastname'];
			}
		}
		
		return form_dropdown('u_id', $return, '-1', 'class="chzn-select" id="select01"');
	}
	
	/**
	 * Äîáàâëåíèå êğåäèòîâ íà àêêàóíò ìóæ÷èíû
	 * @param integer $user_id - ID àêêàóíòà
	 * @param integer $count - êîëè÷åñòâî êğåäèòîâ
	 */
	function addCreditsToMen($user_id, $count)
	{
		$getInfo = $this->db->get_where('user_profile', array('id' => $user_id))->row_array();
		
		$credits = $getInfo['credits'] + $count;
		
		$this->db->update('user_profile', array('credits' => $credits), array('id' => $user_id));
	}
	
	/**
	 * Äîáàâëåíèå øòğàôà ïàğòíåğó
	 * @param array $data ìàññèâ ñ äàííûìè äëÿ ÁÄ
	 */
	
	function addPartnerPenalty($data)
	{
		$this->db->insert('partner_penalty', $data);
	}
	
	// ğàññûëêà
	function getAllNews()
	{
		$this->db->order_by('news_id', 'desc');
		$query = $this->db->get_where('user_partner_news', array('is_show' => '1'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function deleteNews($id)
	{
		$this->db->delete('user_partner_news', array('news_id' => $id));
	}
	
	function insertNews($data)
	{
		$this->db->insert('user_partner_news', $data);
	}
	
	// âñå ïàğòíåğû
	function getAllPartners($sort = 0)
	{
		//$this->db->order_by('id');
		//$query = $this->db->get('user_partner');
		
		if ($sort > 0 && $sort == 1)
		{
			$sort = ' AND p_status = 2';
		}
		elseif ($sort > 0 && $sort == 2)
		{
			$sort = ' AND p_status != 2';
		}
		else
		{
			$sort = '';
		}
		
		$query = $this->db->query('SELECT * FROM user_partner WHERE id > 0 ' . $sort . ' ORDER BY id');

		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	///////////////////////////////////////
	// ÒÅÕÏÎÄÄÅĞÆÊÀ
	
	function getSupportList()
	{
		$this->db->order_by('date', 'desc');
		$query = $this->db->get_where('support_tickets', array('status' => '0'));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function getSupportInformation($hash)
	{
		return $this->db->get_where('support_tickets', array('hash' => $hash))->row_array();
	}
	
	function approveSupportAnswer($hash)
	{
		$this->db->update('support_tickets', array('is_answer' => '1'), array('hash' => $hash));
	}
	
	function approveSupport($hash)
	{
		$this->db->update('support_tickets', array('status' => '1'), array('hash' => $hash));
	}
	
	///////////////////////////////////////////////
	// ÀÍÊÅÒÛ
	
	function blockUser($id)
	{
		$this->db->update('user_profile', array('user_status' => '1'), array('id' => $id));
	}
	
	function createUserUnbanList()
	{
		$this->load->helper('html');
		
		$getUsers = $this->db->get_where('user_profile', array('user_status' => '1'));
		
		$return = array();
		$return['-1'] = 'Select user';
		
		if ($getUsers->num_rows() > 0)
		{
			foreach($getUsers->result_array() as $row)
			{
				$return[$row['id']] = '[' . $row['id'] . '] ' . $row['name'] .' ' . $row['lastname'];
			}
		}
		return form_dropdown('u_id', $return, '-1', 'class="chzn-select" id="select01"');
	}
	
	function unblockUser($id)
	{
		$this->db->update('user_profile', array('user_status' => '0'), array('id' => $id));
	}
	
	///////////////////////////////////
	// ÌÎÈ ÔÈÍÀÍÑÛ
	
	function getFinanceList($start_date, $end_date = null)
	{
		$end = '';
		
		if ($end_date != NULL)
		{
			$end = "AND user_payments.order_date < {$end_date}";
		}
		
		$query = "
			SELECT user_payments.*,
			user_profile.name
			FROM user_payments
			LEFT JOIN user_profile ON user_profile.id = user_payments.id
			WHERE
			user_payments.order_date > {$start_date}
			{$end}
			ORDER BY user_payments.order_id desc
		";
		
		return $this->db->query($query)->result_array();
	}
	
	////////////////////////////////////////
	// ÔÈÍÀÍÑÛ ÏÀĞÒÍÅĞÎÂ
	// ÍÀ×ÈÑËÅÍÈß
	
	function getPartnerMoney($start_date, $end_date = null, $partner_id = false)
	{
		$end = '';
		$part = '';
		
		if ($end_date != NULL)
		{
			$end = "AND partner_money.m_date < {$end_date}";
		}
		
		if ($partner_id != false)
		{
			$part = "AND partner_money.partner_id = {$partner_id}";
		}
		
		$query = "
			SELECT partner_money.*,
			user_partner.p_name
			FROM partner_money
			LEFT JOIN user_partner ON user_partner.id = partner_money.partner_id
			WHERE
			partner_money.m_date > {$start_date}
			{$end}
			{$part}
			ORDER BY partner_money.m_date desc
		";
			
		return $this->db->query($query)->result_array();
	}
	
	function deletePartnerFinance($partner_id, $m_date)
	{
		$this->db->delete('partner_money', array('partner_id' => $partner_id, 'm_date' => $m_date));
	}
	
	// ÊÎË-ÂÎ ÀÍÊÅÒ ÏÀĞÒÍÅĞÀ
	
	function getPartnerCountProfiles($p_id)
	{
		return $this->db->get_where('user_profile', array('is_agency' => $p_id))->num_rows();
	}
	
	// ØÒĞÀÔÛ
	
	function getPartnerPenalty($start_date, $end_date = null, $partner_id = false)
	{
		$end = '';
		$part = '';
		
		if ($end_date != NULL)
		{
			$end = "AND partner_penalty.add_date < {$end_date}";
		}
		
		if ($partner_id != false)
		{
			$part = "AND partner_penalty.p_id = {$partner_id}";
		}
		
		$query = "
			SELECT partner_penalty.*,
			user_partner.p_name
			FROM partner_penalty
			LEFT JOIN user_partner ON user_partner.id = partner_penalty.p_id
			WHERE
			partner_penalty.add_date > {$start_date}
			{$end}
			{$part}
			ORDER BY partner_penalty.add_date desc
		";
			
		return $this->db->query($query)->result_array();
	}
	
	function deletePartnerPenalty($partner_id, $m_date)
	{
		$this->db->delete('partner_penalty', array('p_id' => $partner_id, 'add_date' => $m_date));
	}
	
	////////////////////////////////////////////////////////////////////
	
	function getAllManEmails()
	{
		$query = "
			SELECT
			*
			FROM user_profile
			WHERE
			sex = '1'
			AND user_status = '0'
			ORDER BY id
		";
		
		return $this->db->query($query)->result_array();
	}
	
	function getAllWomenEmails()
	{
		$query = "
			SELECT
			*
			FROM user_profile
			WHERE
			sex = '2'
			AND user_status = '0'
			ORDER BY id
		";
		
		return $this->db->query($query)->result_array();
	}
	
	//////////////////////////////////////////////////////////////////////////
	
	function deleteAllLogs()
	{
		$this->db->query("DELETE FROM user_logs");
	}
	
	function getAnketsLogs($type = 1)
	{
		$query = $this->db->get_where('user_logs', array('log_type' => $type));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function getPartnerName($p_id)
	{
		return $this->getAgencyName($p_id);
	}
	
	function getPartnerEmail($p_id)
	{
		$query = $this->db->get_where('user_partner', array('id' => $p_id))->row_array();
		
		return $query['p_email'];
	}
	
	
	///////////////////////////////////////////////////////////////////////////
	
	function getNotActivatedAnkets()
	{
		$this->db->order_by('register_date', 'desc');
		$query = $this->db->get_where('user_profile', array('user_status' => '9', 'activate_code !=' => ''));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function getTotalProfiles($agency, $sort = '', $sex = '')
	{
		$this->db->order_by('id');
		
		// åñëè óêàçàí ïîèñê ïî àãåíñòâó - äîáàâèì çàïğîñ
		if ($agency != false)
		{
			$this->db->where('is_agency', $agency);
		}
		
		//$where['in_list'] = 1;
		
		switch($sort)
		{
			case 1:
				$where['user_status'] = 0;
				break;
			case 2:
				$where['user_status !='] = 0; 
				break;
			case 5:
				$where['last_online >='] = time();
				break;
			case 6:
				$where['last_online <'] = time();
				break;
			default:
				$where['user_status >='] = 0;
				break;
		}
		
		switch ($sex)
		{
			case 1:
				$where['sex'] = 1;
				break;
			case 2:
				$where['sex'] = 2;
				break;
		}
		
		return $this->db->get_where('user_profile', $where)->result_array();
	}
	
	//////////////////////////////////////////////////////////////////////////////
	// Ğàññûëêà 
	
	function getEmailList($type)
	{
		if ($type == 1)
		{
			$query = $this->db->get_where('user_profile', array('user_status' => '0'));
		}
		elseif ($type == 2)
		{
			$query = $this->db->get_where('user_profile', array('sex' => '2', 'user_status' => '0'));
		}
		elseif ($type == 3)
		{
			$query = $this->db->get_where('user_profile', array('sex' => '1', 'user_status' => '0'));
		}
		
		return $query->result_array();
	}
	
	function insertMailing($data)
	{
		$this->db->insert('engine_mailing', $data);
	}
	
	function getMailingList()
	{
		$query = $this->db->get('engine_mailing');
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
}
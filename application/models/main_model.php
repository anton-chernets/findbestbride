<?php


Class Main_model extends CI_Model
{
	
	var $time;
	
	
	function __construct()
	{
		parent::__construct();
		
		$this->time = time();
	}
	
	function getEngineSettings()
	{
		$query = $this->db->get('engine_settings')->row_array();
		
		return $query;
	}
	
	
	/************** ����������� **************/
	
	function createNewUser($data)
	{
		$this->db->insert('user_profile', $data);
		$lastId = $this->db->insert_id();
		
		if ($data['sex'] == 1)
		{
			$this->db->insert('man_details', array('id' => $lastId));
		}
		elseif ($data['sex'] == 2)
		{
			$this->db->insert('women_details', array('id' => $lastId));
		}
	}
	
	// ��������� ��������� �� ��� ������������ � ����� �����
	
	function checkEmail($email)
	{
		$getData = $this->db->get_where('user_profile', array('email' => $email))->num_rows();
		
		if ($getData > 0)
		{
			return false;
		}
		
		return true;
	}
	
	// ���������� �� �������, ���� ���������� ������ ��� ���� ��������
	
	function getUserProfile($id)
	{
		$data = $this->db->get_where('user_profile', array('id' => $id));
		
		if ($data)
		{
			return $data->row_array();
		}
		
		return false;
	}
	
	function checkAuthData($email, $password)
	{
		$password = md5($password);
		
		$check = $this->db->get_where('user_profile', array('email' => $email, 'password' => $password))->row_array();
		
		if (!empty($check))
		{
			return $check['id'];
		}
		return false;
	}
	
	/****************** ��������� ********************************/
	function isExistActivationCode($code)
	{
		$query = $this->db->get_where('user_profile', array('activate_code' => $code, 'user_status !=' => '0'));
		
		if ($query->num_rows() > 0)
		{
			$query = $query->row_array();
			
			return $query['id'];
		}
		
		return false;
	}
	
	function activateAccount($id)
	{
		$this->db->update('user_profile', array('user_status' => '0'), array('id' => $id));
	}
	
	/****************** �������� �� ������ ***********************/
	
	function checkOnline($id)
	{
		$userInfo = $this->getUserProfile($id);
		
		if ($userInfo['last_online'] > $this->time)
		{
			return true;
		}
		
		return false;
	}
	
	function updateOnline($id)
	{
		$newTime = $this->time + (30 * 60);
		
		$this->db->update('user_profile', array('last_online' => $newTime), array('id' => $id));
	}
	
	/*******************************************************************/
	
	function isExistUser($id)
	{
		$query = $this->db->get_where('user_profile', array('id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$info = $query->row_array();
			return array('is_exist' => true, 'sex' => $info['sex']);
		}
		
		return false;
	}
	
	/************************* �������� ������� ������� **********************/
	
	function getRandomProfile()
	{
		$query = "
			SELECT * FROM user_profile WHERE sex = '2' AND user_status = '0' AND photo_link != '' ORDER BY rand() LIMIT 1
		";
		
		return $this->db->query($query)->row_array();
	}
	
	/************************* 12 �������� �� ������� ***********************/
	
	function getMainPageProfiles()
	{
		$time = time();
		$query = "
			SELECT
			user_profile.*,
			women_details.*
			FROM
			user_profile
			LEFT JOIN women_details ON women_details.id = user_profile.id
			WHERE user_profile.sex = '2' AND user_profile.user_status = '0'
			AND user_profile.last_online > {$time}
			ORDER BY rand()
			LIMIT 12
		";
		
		return $this->db->query($query)->result_array();
	}
	
	/************************* ������������� ��������� **********************/
	
	function newUserMessages($id)
	{
		$msgCount = '';
		
		$query = $this->db->get_where('private_messages', array('to_user_id' => $id, 'is_read' => '0'))->num_rows();
		
		if ($query > 0)
		{
			$msgCount = '(' . $query . ')';
		}
		
		return $msgCount;
	}
	/************************ ���������� �������� ***********************/
	
	function updateCredits($user_id, $credits)
	{
		$this->db->update('user_profile', array('credits' => $credits), array('id' => $user_id));
	}
	
	function creditsLog($user_id, $credits, $type)
	{
		$this->db->query("INSERT INTO credits_logs (user_id, count, date, type) VALUES ('{$user_id}', '{$credits}', NOW(), '{$type}')");
	}
	
	/********************** ���������� ����� �� ���� �������� *************/
	
	function addPartnerMoney($data)
	{
		$this->db->insert('partner_money', $data);
	}
	
	/********************* ����������� �������� **************************/
	
	function authPartner($data)
	{
		$query = $this->db->get_where('user_partner', array('p_login' => $data['login'], 'p_password' => $data['pwd']));
		
		if ($query->num_rows() > 0)
		{
		    $row = $query->row_array();
		    $this->db->update('user_partner', array('last_online' => date('Y-m-d H:i:s')), array('id' => $row['id']));
			return $row;
		}
		
		return false;
	}
	
	function getPartnerProfile($login)
	{
		return $this->db->get_where('user_partner', array('p_login' => $login))->row_array();
	}
	
	/******************* ����������� �������������� ************************/
	
	function adminAuth($data)
	{
		$query = $this->db->get_where('user_admin', array('a_login' => $data['login'], 'a_password' => $data['pwd']));
		
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		
		return false;
	}
	
	function getAdminProfile($login)
	{
		return $this->db->get_where('user_admin', array('a_login' => $login))->row_array();
	}
	
	function getAnketsOnActivation()
	{
		return $this->db->get_where('user_profile', array('user_status' => '3'))->num_rows();
	}
	
	function getActivationBroadcast()
	{
		return $this->db->get_where('user_broadcast', array('approved' => '0'))->num_rows();
	}
	
	function getGiftsOnActivation()
	{
		return $this->db->get_where('women_gifts', array('status' => '2'))->num_rows();
	}
	
	function getPartnerOnActivation()
	{
		return $this->db->get_where('user_partner', array('p_status' => '1'))->num_rows();
	}
	
	function getVideoOnActivation()
	{
		return $this->db->get_where('user_videos', array('approved' => '0'))->num_rows();
	}
	
	function getSupportTickets()
	{
		return $this->db->get_where('support_tickets', array('status' => '0'))->num_rows();
	}
	
	function getContactReq()
	{
		return $this->db->get_where('request_info', array('status' => '0'))->num_rows();
	}
	
	function getRtReq()
	{
		return $this->db->get_where('rt_request', array('status' => '0'))->num_rows();
	}
	
	function getRtOnActivation()
	{
		return $this->db->get_where('romance_tours', array('status' => '0'))->num_rows();
	}
	
	/******************* ����� ��������� �������� *****************************/
	
	function partnerNewMessages($partner_id)
	{
		$query = $this->db->get_where('user_partner_messages', array('to_id' => $partner_id, 'is_read' => '0', 'is_deleted' => '0'));
		
		if ($query->num_rows() > 0)
		{
			return $query->num_rows();
		}
		
		return false;
	}
	
	function getPartnerBlockMessages($partner_id)
	{
		$query = "
			SELECT
			*
			FROM user_partner_messages
			WHERE
			to_id = ?
			AND is_deleted != '1'
			ORDER BY
			msg_date desc
			LIMIT 3
		";
		
		$query = $this->db->query($query, array($partner_id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	function insertPartnerGift($hash, $p_id)
	{
		$this->db->insert('partner_gifts', array('p_id' => $p_id, 'gift_hash' => $hash));
	}
	
	/******************************* ���������� ����� ****************************/
	
	function insertLog($user_id, $log_id, $comment)
	{
		$eng = $this->getEngineSettings();
		
		if ($eng['engine_is_logs'] == 1)
		{
			$logDate = date('Y-m-d H:i:s');
		
			$insertData = array(
				'user_id'	=> $user_id,
				'log_type'	=> $log_id,
				'comment'	=> $comment,
				'log_date'	=> $logDate
			);
		
			$this->db->insert('user_logs', $insertData);
		}
	}
	
	public function getGiftPrice($gift_id)
	{
		$query = $this->db->get_where('gift_price', array('giftId' => $gift_id))->row_array();
		
		return $query['prices'];
	}
	
	public function getAvatarsOnActivation()
	{
		$query = $this->db->get_where('user_profile', array('avatar_act !=' => ''))->num_rows();
		
		return $query;
	}
	
	function partnerNewGifts($partner_id)
	{
		$query = $this->db->query('SELECT * FROM women_gifts INNER JOIN user_profile ON user_profile.id = women_gifts.to_id WHERE women_gifts.status = 0 AND user_profile.is_agency = ' . $partner_id)->num_rows();
		
		$return = ($query > 0) ? '<sup style="color:red;">'.$query.'</sup>' : '';
		
		return $return;
	}
	
	public function oneProfile()
	{
		$query = $this->db->query('SELECT * FROM user_profile WHERE user_status = 0 AND sex = 2 AND photo_link != "" ORDER BY RAND() LIMIT 1')->row_array();
		
		return $query;
	}
}
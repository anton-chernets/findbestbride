<?php

Class Multichat_model extends CI_Model
{
    /**
     * Установка партнеру статуса "онлайн"
     * @param $partner_id int - ID партнера 
     */
    public function setPartnerOnline($partner_id)
    {
        $this->db->update('user_partner', array('last_online' => date('Y-m-d H:i:s')), array('id' => $partner_id));
    }
    
    /**
     * Выборка девушек, которых можно добавить в мультичат (оффлайн + пренадлежат данному партнеру)
     * @param $partner_id int - ID партнера
     * @return array
     */
    public function getOfflineGirls($partner_id)
    {
        $query = $this->db->get_where('user_profile', array('is_agency' => $partner_id, 'last_online <' => time(), 'user_status' => '0'));
        
        return $query->result_array();
    }
    
    /**
     * Выборка добавленных анкет в мультичат
     * @param $partner_id integer - ID партнера
     * @return array
     */
    public function getAddedAnkets($partner_id)
    {
        $query = $this->db->query("SELECT a.*, b.name, b.lastname, b.photo_link FROM partner_multichat a LEFT JOIN user_profile b ON a.added_user = b.id WHERE a.partner_id = " . $partner_id);
        
        return $query->result_array();
    }
    
    /**
     * Добавление анкеты в мультичат
     * @param $partner_id - ID партнера
     * @param $user_id - ID анкеты
     */
    public function addWomenToMultichat($partner_id, $user_id)
    {
        $this->db->query("INSERT INTO partner_multichat (partner_id, added_user) VALUES ('{$partner_id}', '{$user_id}')");
        $this->db->query("UPDATE user_profile SET is_multichat = 1 WHERE id = " . $user_id);
    }
    
    /**
     * Проверка принадлежит ли анкета этому партнеру
     * @param $user_id int - ID анкеты
     * @param $partner_id int - ID партнера
     * @return boolean
     */
    public function checkAnket($user_id, $partner_id)
    {
        $query = $this->db->query("SELECT * FROM user_profile WHERE is_agency = '{$partner_id}' AND id = '{$user_id}'");
        
        if ($query->num_rows() > 0)
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * Удаление анкеты из мультичата, изменение статуса анкеты на оффлайн, закрытие всех открытых чатов
     * у этой анкеты
     * @param $user_id int - ID анкеты
     */
    public function deleteWomenFromMultichat($user_id)
    {
        $this->db->query("DELETE FROM partner_multichat WHERE added_user = " . $user_id);
        $this->db->query("UPDATE user_profile SET last_online = 1, is_multichat = 0 WHERE id = " . $user_id);
        $this->db->query("UPDATE user_chat SET end_time = '1' WHERE end_time > UNIX_TIMESTAMP() AND (user_1 = '{$user_id}' OR user_2 = '{$user_id}')");
    }
    
    public function checkNewMessages($user_id)
    {
        $query = $this->db->query("select a.*, b.* from user_chat a INNER JOIN user_chat_messages b ON a.chat_name = b.chat_name
        WHERE a.end_time > UNIX_TIMESTAMP() AND b.status = 0 AND (a.user_1 = '{$user_id}' OR a.user_2 = '{$user_id}')");
        
        return $query->num_rows();
    }
    
    public function getNewMessages($c_name, $my_id)
    {
        $check = $this->db->query("SELECT * FROM user_chat WHERE chat_name = '{$c_name}' AND (user_1 = '{$my_id}' OR user_2 = '{$my_id}')");
        
        if ($check->num_rows() > 0)
        {
            $query = "
    			SELECT
    			user_chat_messages.*,
    			user_profile.name
    			FROM user_chat_messages
    			LEFT JOIN user_profile ON user_profile.id = user_chat_messages.from_id
    			WHERE
    			user_chat_messages.status = '0'
    			AND user_chat_messages.chat_name = ?
    			AND user_chat_messages.from_id != ?
    			ORDER BY message_date
    		";
        
            $query = $this->db->query($query, array($c_name, $my_id));
        
        
            return $query->result_array();
        }
        
        return array();
    }
}
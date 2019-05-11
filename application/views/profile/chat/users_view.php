<?php
if($this->userInfo['sex'] == 2)
    $users = $this->cModel->getDTLikeManProfiles($my_id);
  else
    $users = $this->cModel->getDTLikeWomenProfiles($my_id);

    $base = base_url();
if (empty($users)) { $users = array(); } 
    foreach ($users as $u)
    {   
		$is_chat = $this->db->query('SELECT * FROM user_chat WHERE ((user_1 = "'.$this->selfId.'" AND user_2 = "'.$u['id'].'") OR (user_1 = "'.$u['id'].'" AND user_2 = "'.$this->selfId.'")) AND end_time > "' . time() .'"');
		$style = '';
		if ($is_chat->num_rows() > 0)
		{
			$chat = $is_chat->row_array();
			$messages = $this->db->get_where('user_chat_messages', array('from_id !=' => $this->selfId, 'status' => 0, 'chat_name' => $chat['chat_name']))->num_rows();
			
			if ($messages > 0)
			{
				if ($auser != $u['id'])
				{
					$style = 'style="background-color: lightblue;"';
				}
			}
		}
		
        $photo=($u['photo_link'] == '')?"content/img/no-foto-100.png":"profiles/photo/user_".$u["id"]."/".$u['photo_link']."_101.jpg";
        $u['activity'] = 1;
        echo '<div class="user '.(($auser==$u['id'])?'active':'').'" '.$style.' uid="'.$u['id'].'" id="usr_'.$u['id'].'">';
        //echo '<div class="photo" style="background: url('.$base.$photo.') 50% 50% transparent"></div>';
        echo '<img class="photo" src="'.$base.$photo.'" />';
        echo '<div class="usrdata">
                <div class="uname">'.$u['name'].'</div>
                <div class="uage">ID: '.$u['id'].'</div>';
        
        if($u['room']!='')
            { $u['activity'] = 1;
              //check new message
                $newmsg = 0;
                $newmsg = ($u['newmsg']>0)?30:5;
            }
          else
            { $u['activity'] = 0; 
              $newmsg = 0;
            }
        
        $block='<div class="umsgstatus-0"></div>';    
        $block = "<a href='/user".$u['id']."' target='blank' title='View profile'>".$block.'</a>';
        
        echo $block;
        //echo '<div class="ustatus-'.$u['activity'].'"></div>';
        
        if($u['room']=='')
        {   
            echo '<div class="invite umsgstatus-20" title="Invite to chat" onclick="InviteUser('.$u['id'].')"></div>';            
            if($u['invite']==2)
                echo '<div class="invite umsgstatus-10"></div>';
        }      
        else{
            echo '<div class="invite ustatus-0" title="Close chat" onclick="closeChat(\''.$u['room'].'\')"></div>';
        }
       // echo '<a href="/my/videochat/conference/invite/'.$u['id'].'" target="blank"><div class="invite ucamera"></div><a>';
        echo '<div id="room" rname="'.$u['room'].'"></div>
            </div>';
        echo '</div>';    
    }
?>
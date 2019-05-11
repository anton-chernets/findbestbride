<?php
foreach ($msg as $row)
{    
        echo '<div class="msgbox">';
        echo '<div class="headmsg"><span class="dtime">['.date('H:i:s', $row['message_date']).']</span><span class="username-'.(($row['from_id']==$my_id)?0:1).'">'.$row['name'].'<span></div>';            
        echo '<div class="textmsg">'.$row['message'].'</div>';            
        echo '</div>';    
if ($row['status'] == 0)
	$this->chat_model->updateMsgStatus($row['message_id']);
}

?>
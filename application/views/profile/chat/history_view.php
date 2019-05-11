<?PHP

foreach ($history as $user) {
	$photo=($user['photo_link'] == '')?"content/img/no-foto-100.png":"profiles/photo/user_".$user["id"]."/".$user['photo_link']."_101.jpg";
	$online = (isOnlineUser($user['last_login']) == true) ? '<span style="color:green;">ONLINE</span>' : 'Offline';
	echo '<div class="user" id="history_'.$user['id'].'">';
	
	echo '<div class="usrdata">
			<img class="photo" src="'.base_url().$photo.'" />
            <div class="uname">'.$user['name'].'</div>
            <div class="uage">ID: '.$user['id'].'<br> '.$online.'</div>
			<div class="invite ustatus-0" title="Remove contact" onclick="deleteChat(\''.$user['id'].'\')"></div>
			<div id="room"></div>
	';
	
	echo '</div></div>';
}
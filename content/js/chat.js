var invited = false;
var manVideo = false;

function deleteChat(chat_name)
{
	$.ajax({
		url: chatInfo.url + 'my/chat/ajax/delete',
		type: 'POST',
		dataType: 'json',
		data: { chat_name: chat_name },
		success: function(obj) {
			if (obj.result == 'success')
			{
				$('#history_'+chat_name).remove();
			}
		}
	});
}

function delete_history()
{
	$.ajax({
		url: chatInfo.url + 'my/chat/ajax/deletehistory',
		type: 'POST',
		dataType: 'json',
		data: { del: '1' },
		success: function(obj) {
			if (obj.result == 'success')
			{
				$('#historybox').html('');
			}
		}
	});
}

function loadUser(userId) {
	$.ajax({
		url: chatInfo.url + 'my/chat/a_user',
		type: 'POST',
		dataType: 'html',
		data: { auser: userId },
		success: function(obj) {
			$('#a_user').html(obj);
		}
	});
}

function insertSmile(id)
{
	$('#msgbox').val($('#msgbox').val() + ':'+id+':');
}

function closeChat(chat_id)
{
	$.ajax({
		url: chatInfo.url + 'my/chat/ajax/close_chat',
		type: 'POST',
		dataType: 'json',
		data: { chat: chat_id },
		success: function(obj) {
			if (obj.result == 'success') {
				alert('Chat was closed.');
				$('#c_'+chat_id).html('');
                $('#msgbox').attr('readonly', true);
                $('#sendmsg').attr('disabled', true);   
				$('#closeBtn').hide();
				$('#chatText').hide();
				$('#videoText').hide();
				$('#roomsbox').html('');

				$('#a_user').html('<a href="#" title="View profile"><img src="/content/img/no-foto-100.png" title="View profile" style="width:100px;"></a>');
			}
			else {
				alert(obj.message);
			}
		}
	});	
}

function preload() {
    var room = $('.active .usrdata').find('#room').attr('rname');

    if(typeof(room) == 'string' && room != '') {
		$.ajax({
			url: chatInfo.url + 'my/chat/ajax/preload_new/',
			type: 'POST',
			dataType: 'json',
			data: { name: room },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#roomsbox').append(obj.html);
					
					if (obj.sound == '1')
					{
						ion.sound.play('chat_new_message');
					}
					
					_scrollBottom();
				}
			}
		});
		
        $('#msgbox').attr('readonly', false);
        $('#sendmsg').attr('disabled', false);
    }
}

function send()
{
	var msg = $('#msgbox').val();

	if (msg == '') {
		alert('Type your message');
		return;
	}

    var room = $('.active .usrdata').find('#room').attr('rname');
        
    if(typeof(room) == 'string' && room != '')
	{
        $.post(chatInfo.url + 'my/chat/ajax/send/',
		{
			message: msg,
			name: room
		},
		function(data) {	
			if(data.status == 'success') {
				$('#msgbox').val('');
				$('#roomsbox').append(data.html);
				_scrollBottom();
			}
			else {
				alert('Chat was closed.');
				window.location.href = chatInfo.url + 'my/chat/';
			}
		},
		'json');
	}
    else  {    
        $('#msgbox').attr('readonly', true);
        $('#sendmsg').attr('disabled', true);            
        
		alert('Please, invite user.');            
        
		return;
    }                    
}

function _scrollBottom() {
	if($('#roomsbox').length)
		$('#roomsbox').get(0).scrollTop = $('#roomsbox').get(0).scrollHeight;
}

function firstminusCreds()
{
    $.ajax({
		url: chatInfo.url + 'my/chat/ajax/check_credits/',
		type: 'POST',
		dataType: 'json',
		data: { id: '1' },
		success: function(obj) {
			if (obj.result == 'error') {
				clearInterval(minusCredits);
				alert(obj.message);
				window.location.href = chatInfo.url + 'my/credits/';
			}
		}
	});
}

function minusCreds()
{  
    $.ajax({
		url: chatInfo.url + 'my/chat/ajax/minus_credits/',
		type: 'POST',
		dataType: 'json',
		data: { id: '1', room: $('#actroom').val() },
		success: function(obj) {
			if (obj.result == 'error') {
				clearInterval(minusCredits);

				alert(obj.message);

				window.location.href = chatInfo.url + 'my/credits/';
			}
		}
	});  
}

function InviteUser(invite_id) {
	if (isNaN(invite_id) || invite_id < 0)
	{
		alert('ERROR');
		return;
	}
	
	if (invited == true && chatInfo.sex == 2) {
		alert('You can invite this user after 30 seconds');
		return;
	}

	$.ajax({
		url: chatInfo.url + 'my/chat/invite/',
		type: 'POST',
		dataType: 'json',
		data: { invite_id: invite_id },
		success: function(obj) {
			if (obj.result == 'success') {
				if (chatInfo.sex == 2) {
                    alert('Now, please write your message to man');
					
					invited = true;
					setTimeout(function() {
						invited = false;
					}, 30000);
				}
				else if (chatInfo.sex == 1) {
					alert('Now, please write your message to lady');
				}
				
				GetUsers();
				
				$('#closeBtn').show();
				$('#chatText').show();
			}
			else
			{
				alert(obj.message);
			}

		}
	});
}

function getHistory() {
	$.ajax({
		url: chatInfo.url + 'my/chat/history',
		type: 'POST',
		dataType: 'html',
		data: { auser: $('#actuser').val() },
		success: function(obj) {
			$('#historybox').html(obj);
		}
	});
}

function GetUsers() {
    $.ajax({
		url: chatInfo.url + 'my/chat/users',
		type: 'POST',
		dataType: 'html',
		data: { auser: $('#actuser').val() },
		success: function(obj) {
			$('#userbox').html(obj);
            var room = $('.active .usrdata').find('#room').attr('rname');
            
			if(typeof(room) == 'string' && room != '') {
                $('#msgbox').attr('readonly', false);
                $('#sendmsg').attr('disabled', false);
            }
		}
	});
}

function activateWomanCamera() {
	$('.my-profile').hide();
	$('#myVideo').show();
	$('#historybox').css('height', '225px');
	
	$.post(chatInfo.url + 'my/chat/camera', { type: 1});
	
	setTimeout(function() {
		getFlashMovie('video1').setProperty('src', root + '?publish=' + chatInfo.id);
		getFlashMovie('video1').setProperty('microphone', false);
		getFlashMovie('video1').setProperty('cameraQuality', 90);
	}, 3000);
}

function deactivateWomanCamera() {
	getFlashMovie('video1').setProperty('src', null);
	
	$('#myVideo').hide();
	$('#historybox').css('height', '325px');
	$('.my-profile').show();
	
	$.post(chatInfo.url + 'my/chat/camera', { type: 2 });
}

function openVideoChat(nearId, userId) {
	$('#roomsbox').css('height', '150px').css('margin-top', '200px');
	$('#chatbox').css('height', '640px');
	$('#remoteVideo').show();
	
	setTimeout(function() {
		getFlashMovie('video2').setProperty('src', root + '?play=' + userId + '&farID=' + nearId);
		getFlashMovie('video2').setProperty('sound', false);
	}, 4000);
	
	clearInterval(loadUserInterval);
	
	var videoMoneys = setInterval(videoMoney, 60000);
	var checkVideo = setInterval(checkVideoChat, 6000);
	
	chatInfo.video = 1;
	chatInfo.videoId = userId;
	
	$('#manVideoBtn').show();
	$('#video-button').hide();
	$('#video-button-stop').show();
	$('#chatText').hide();
	$('#videoText').show();
}

function stopVideoChat() {
	chatInfo.video = 0;
	chatInfo.myVideo = 0;
	chatInfo.videoId = 0;
	
	$('#remoteVideo').hide();
	$('#myVideo').hide();
	$('#video-button-stop').hide();
	$('#video-button').show();
	$('#manVideoBtn').hide();
	$('#historybox').css('height', '325px');
	$('.my-profile').show();
	$('#videoText').hide();
	$('#chatText').show();
	
	$('#roomsbox').css('height', '300px').css('margin-top', '0px');
}

function videoMoney() {
	if (chatInfo.video == 1) {
		$.ajax({
			url: chatInfo.url + 'my/chat/ajax/video_money',
			type: 'post',
			dataType: 'json',
			data: { room: $('.active .usrdata ').find('#room').attr('rname') },
			success: function(e) {
				if (e.result == 'error') {
					alert(e.message);
					
					window.location.href = chatInfo.url + 'my/credits';
				}
			}
		});
	}
}

function checkVideoChat() {
	if (chatInfo.video == 1) {
		$.ajax({
			url: chatInfo.url + 'my/chat/check_camera',
			type: 'post',
			dataType: 'json',
			data: { user: chatInfo.videoId },
			success: function(e) {
				if (e.result == 'error') {
					//clearInterval(videoMoneys);
					//clearInterval(checkVideo);
					
					closeVideoChat();
					
					if (chatInfo.sex == 1) {
						var loadUserInterval = setInterval(loadUserCamera, 9000);
					}
					else if (chatInfo.sex == 2) {
						chatInfo.isMan = 0;
						chatInfo.videoId = '';
						chatInfo.video = 0;
					}
				}
			}
		});
	}
}

function closeVideoChat() {
	if (chatInfo.myVideo == 1) {
		getFlashMovie('video1').setProperty('src', null);
		
		$('#myVideo').hide();
		$('#historybox').css('height', '325px');
		$('.my-profile').show();
		
		$.post(chatInfo.url + 'my/chat/camera', { type: 2 });
		
		chatInfo.myVideo = 0;
	}
	
	getFlashMovie('video2').setProperty('src', null);
	$('#remoteVideo').hide();
	$('#video-button').hide();
	$('#video-button-stop').hide();
	$('#manVideoBtn').hide();
	$('#roomsbox').css('height', '300px').css('margin-top', '0px');
	
	$('#chatText').show();
	$('#videoText').hide();
	
	
	chatInfo.video = 0;
	chatInfo.videoId = 0;
}

function loadUserCamera() {
	var room = $('.active .usrdata').find('#room').attr('rname');
	
	if (typeof(room) == 'string' && room != '' && chatInfo.video == 0) {
		$.ajax({
			url: chatInfo.url + 'my/chat/check_lady_camera',
			type: 'post',
			dataType: 'json',
			data: { room: room },
			success: function(e) {
				if (e.result == 'success') {
					$('#video-button').show();
					$('#video-button-a').attr('onClick', 'openVideoChat(\'' + e.nearId + '\', '+ e.userId +');');
				}
				else if (e.result == 'error') {
					$('#video-button').hide();
				}
			}
		});
	}
}

function isManCamera() {
	var room = $('.active .usrdata').find('#room').attr('rname');
	
	if (typeof(room) == 'string' && room != '' && chatInfo.isMan == 0) {
		$.ajax({
			url: chatInfo.url + 'my/chat/check_lady_camera',
			type: 'post',
			dataType: 'json',
			data: { room: room },
			success: function(e) {
				if(e.result == 'success') {
					$('#roomsbox').css('height', '150px').css('margin-top', '200px');
					$('#chatbox').css('height', '640px');
					$('#remoteVideo').show();
					chatInfo.isMan = 1;
					chatInfo.videoId = e.userId;
					chatInfo.video = 1;
					
					var isNotManCamera = setInterval('checkVideoChat()', 8000);
					
					setTimeout(function() {
						getFlashMovie('video2').setProperty('src', root + '?play=' + e.userId + '&farID=' + e.nearId);
						getFlashMovie('video2').setProperty('sound', false);
					}, 3000);
					
				}
			}
		});
	}
}

function loadRoom(room) {
	$.ajax({
		url: '/my/chat/ajax/load_messages/' +  room,
		type: 'GET',
		dataType: 'HTML',
		success: function(e) {
			$('#roomsbox').html(e);
		}
	});
	$('#chatText').show();
	
	_scrollBottom();
}
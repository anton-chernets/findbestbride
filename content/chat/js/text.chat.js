var textchat = {
	is_sound: true,
	
	smile: function(smile) {
		$('#message').val($('#message').val() + ' ' + smile).focus();
	},
	
	sound: function() {
		if (this.is_sound == true) {
			this.is_sound = false;
			$('#sound').html('Turn on sound');
		}
		else {
			this.is_sound = true;
			$('#sound').html('Turn off sound');
		}
	},
	
	loadRoom: function(room) {
		this.history(room);
		
		$.ajax({
			url: info.url + 'my/chat/ajax/load_messages',
			type: 'post',
			dataType: 'html',
			data: { room: room },
			success: function(e) {
				$('#chat_body').html(e);
				users.loadUser(room);
				
				info.room = room;
				textchat.scrollBottom();
			
				$('#file_chatName').val(room);
				
				if (info.gender == 2) {
					$('#close').show();
				}
			}
		});
	},
	
	history: function(room) {
		$.ajax({
			url: info.url + 'my/chat/ajax/load_history',
			type: 'post',
			dataType: 'html',
			data: { room: room },
			success: function(e) {
				$('#chat_body').html(e);
			}
		});
	},
	
	scrollBottom: function() {
		if ($('#chat_body').length) {
			$('#chat_body').get(0).scrollTop = $('#chat_body').get(0).scrollHeight;
		}
	},
	
	close: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/chat/ajax/close',
				type: 'post',
				data: { room: info.room },
				success: function() {
					$('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>You have left the conversation.</strong></i></span></div>');
					users.unloadUser();
					users.onlineList();
					videochat.disconnect();
					info.room = '';
					
					if (info.gender == 2) {
						$('#close').hide();
					}
				}
			});
		}
	},
	
	send: function() {
		var message = $('#message').val();
		
		if (message == '') {
			return;
		}
		
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/chat/ajax/send',
				type: 'post',
				dataType: 'json',
				data: { room: info.room, message: message },
				success: function(e) {
					if (e.status == 'success') {
						$('#message').val('');
						
						$('#chat_body').append(e.html);
						textchat.scrollBottom();
					} else {
						$('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>Chat was closed.</strong></i></span></div>');
						
						users.unloadUser();
						users.onlineList();
						videochat.disconnect();
						
						info.room = '';
					}
				}
			});
		}
	},
	
	preload: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/chat/ajax/preload',
				type: 'post',
				dataType: 'json',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'success') {
						$('#chat_body').append(e.html);
						
						if (e.count > 0 && textchat.is_sound == true) {
							ion.sound.play('chat_new_message');
							textchat.scrollBottom();
						}
					} else {
						$('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>Chat was closed.</strong></i></span></div>');
						
						users.unloadUser();
						users.onlineList();
						videochat.disconnect();
						
						info.room = '';
					}
				}
			})
		}
	},
	
	inviteAll: function() {
		var message = $('#message').val();
		
		if (message == '')
		{
			alert('Please, type invite message');
			return;
		}
		
		$.ajax({
			url: info.url + 'my/chat/invite_all',
			type: 'post',
			data: { message: message },
			success: function(e) {
				$('#message').val('');
				users.onlineList();
			}
		});
	},
	
	pay: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/chat/ajax/credits',
				type: 'post',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'error') {
						window.location.href = info.url + 'my/credits/';
					}
				}
			});
		}
	}
}

setInterval('textchat.preload()', 4000);

if (info.gender == 1) {
	setInterval('textchat.pay()', 60000);
}
var mchat = {
	type: 0,
	loadRoom: function(room) {
		this.history(room);
		
		$.ajax({
			url: info.url + 'load_messages',
			type: 'post',
			dataType: 'html',
			data: { room: room, selfId: info.selfId },
			success: function(e) {
				$('#chat_body').append(e);
				musers.contactList();
				musers.loadUser(room);
				
				info.room = room;
				mchat.scrollBottom();
				
				$('#file_selfId').val(info.selfId);
				$('#file_chatName').val(room);
				
				$('#close').show();
			}
		});
	},
	
	history: function(room) {
		if (this.type > 0) {
			$.ajax({
				url: info.url + 'load_history',
				type: 'post',
				dataType: 'html',
				data: { room: room, type: this.type, selfId: info.selfId },
				success: function(e) {
					$('#chat_body').html(e);
				}
			});
		}
	},
	
	changeType: function(type) {
		$('#type_' + this.type).removeClass('hbold');
		$('#type_' + type).addClass('hbold');
		this.type = type;
		
		if (info.room != '') {
			this.loadRoom(info.room);
		}
	},
	
	scrollBottom: function() {
		if ($('#chat_body').length) {
			$('#chat_body').get(0).scrollTop = $('#chat_body').get(0).scrollHeight;
		}
	},
	
	close: function() {
		$.ajax({
			url: info.url + 'close',
			type: 'post',
			data: { room: info.room },
			success: function() {
				$('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>You have left the conversation.</strong></i></span></div>');
				musers.unloadUser();
				musers.onlineList();
				musers.contactList();
				info.room = '';
					
				$('#close').hide();
			}
		});
	},
	
	smile: function(smile) {
		$('#message').val($('#message').val() + ' ' + smile).focus();
	},
	
	send: function() {
		var message = $('#message').val();
		
		if (message == '') {
			return;
		}
		
		if (info.room != '') {
			$.ajax({
				url: info.url + 'send',
				type: 'post',
				dataType: 'json',
				data: { room: info.room, message: message, selfId: info.selfId },
				success: function(e) {
					if (e.status == 'success') {
						$('#message').val('');
						
						$('#chat_body').append(e.html);
						mchat.scrollBottom();
					} else {
						$('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>Chat was closed.</strong></i></span></div>');
						
						musers.unloadUser();
						musers.onlineList();
						
						info.room = '';
					}
				}
			});
		}
	},
	
	preload: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'preload',
				type: 'post',
				dataType: 'json',
				data: { room: info.room, selfId: info.selfId },
				success: function(e) {
					if (e.result == 'success') {
						$('#chat_body').append(e.html);
						
						if (e.count > 0) {
							ion.sound.play('chat_new_message');
							mchat.scrollBottom();
						}
					} else {
						$('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>Chat was closed.</strong></i></span></div>');
						
						musers.unloadUser();
						musers.onlineList();
						
						info.room = '';
					}
				}
			})
		}
	}
}

setInterval('mchat.preload()', 4000);
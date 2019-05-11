var musers = {
	usersPage: 1,
	selected: 0,
	sorting: 0,
	
	onlineList: function() {
		$.ajax({
			url: info.url + 'online_list',
			type: 'post',
			dataType: 'json',
			data: { page: this.usersPage, sort: this.sorting, selfId: info.selfId },
			success: function(e) {
				$('#count').html(e.count);
				$('#profilecontainer').html(e.list);
				$('#profilepages').html(e.pages);
				//$('#contact-list').html(e.history);
				
				if (musers.selected != 0) {
					$('#id_contact_' + musers.selected).addClass('selected');
				}
				
				if (e.count < 1) {
					$('.b-bottom-buttons2').hide();
				}
				else if (e.count > 0) {
					$('.b-bottom-buttons2').show();
				}
			}
		});
	},
	
	sort: function() {
		this.sorting = $('#sort').val();
		
		this.onlineList();
	},
	
	nextUserPage: function(page_id) {
		this.usersPage = page_id;
		
		this.onlineList();
	},
	
	offlist: function() {
		$.ajax({
			url: info.url + 'offlist',
			type: 'post',
			dataType: 'json',
			data: { type: 1 },
			success: function(e) {
				$('#contacto2-list').html(e.html);
			}
		})
	},
	
	onlist: function() {
		$.ajax({
			url: info.url + 'onlist',
			type: 'post',
			dataType: 'json',
			data: { type: 2 },
			success: function(e) {
				$('#contacto-list').html(e.html);
				
				if (info.selfId != 0) {
					$('#id_online_' + info.selfId).addClass('selected');
				}
				
				if (e.play > 0) {
					ion.sound.play('chat_new_message');
				}
			}
		});
	},
	
	turnOn: function(user_id) {
		$.ajax({
			url: info.url + 'turn_on',
			type: 'post',
			dataType: 'json',
			data: { user_id: user_id },
			success: function(e) {
				if (e.result == 'success') {
					musers.offlist();
					musers.onlist();
				}
			}
		});
	},
	
	turnOff: function(user_id) {
		$.ajax({
			url: info.url + 'turn_off',
			type: 'post',
			dataType: 'json',
			data: { user_id: user_id },
			success: function(e) {
				if (e.result == 'success') {
					musers.offlist();
					musers.onlist();
					$('#contact-list').html('');
					
					if (user_id == info.selfId) {
						$('#my').hide();
					}
				}
			}
		});
	},
	
	activate: function(user_id) {		
		if (info.selfId != 0) {
			$('#id_online_' + info.selfId).removeClass('selected');
			info.selfId = 0;
		}
		
		$('#id_online_' + user_id).addClass('selected');
		info.selfId = user_id;
		this.contactList();
		this.onlineList();
		info.room = '';
		this.unloadUser();
		$('#close').hide();
		$('#chat_body').html('');
		
		$.ajax({
			url: info.url + 'my',
			type: 'post',
			dataType: 'json',
			data: { selfId: info.selfId },
			success: function(e) {
				$('#my').show();
				$('#myphoto').attr('src', e.photo);
			}
		});
	},
	
	contactList: function() {
		if (info.selfId != 0) {
			$.ajax({
				url: info.url + 'history',
				type: 'post',
				dataType: 'html',
				data: { user_id: info.selfId },
				success: function(e) {
					$('#contact-list').html(e);
				}
			});
		}
	},
	
	deleteContact: function(user_id) {
		if (info.selfId != 0) {
			$.ajax({
				url: info.url + 'contact',
				type: 'post',
				dataType: 'json',
				data: { type: 1, user_id: user_id, selfId: info.selfId },
				success: function(e) {
					if (e.result == 'success') {
						$('#id_contact_' + user_id).remove();
					}
				}
			});
		}
	},
	
	clearContacts: function() {
		if (info.selfId != 0) {
			$.post(info.url + 'contact', { type: 1, selfId: info.selfId });
			this.contactList();
		}
	},
	
	invite: function(user_id) {
		if (info.selfId != 0) {
			$.ajax({
				url: info.url + 'invite',
				type: 'post',
				dataType: 'json',
				data: { user_id: user_id, selfId: info.selfId },
				success: function(e) {
					if (e.result == 'success') {
						musers.onlineList();
						
						mchat.loadRoom(e.room);
					} else {
						alert(e.message);
					}
				}
			});
		}
	},
	
	loadUser: function(room) {
		$.ajax({
			url: info.url + 'load_user',
			type: 'post',
			dataType: 'json',
			data: { room: room, selfId: info.selfId },
			success: function(e) {
				$('#men_img').attr('src', e.photo);
			}
		});
	},
	
	unloadUser: function() {
		$('#men_img').attr('src', '/content/img/nophoto-mini.png');
	}
}

musers.onlineList();
musers.offlist();
musers.onlist();

setInterval('musers.onlineList()', 7000);
setInterval('musers.contactList()', 15000);
setInterval('musers.onlist()', 15000);
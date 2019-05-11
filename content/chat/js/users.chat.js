var users = {
	usersPage: 1,
	selected: 0,
	sorting: '',
	
	onlineList: function() {
		$.ajax({
			url: info.url + 'my/chat/online_list',
			type: 'post',
			dataType: 'json',
			data: { page: this.usersPage, sort: this.sorting },
			success: function(e) {
				$('#count').html(e.count);
				$('#profilecontainer').html(e.list);
				$('#profilepages').html(e.pages);
				$('#contact-list').html(e.history);
				
				if (users.selected != 0) {
					$('#id_contact_' + users.selected).addClass('selected');
				}
				
				if (info.gender == 2 && e.count < 1) {
					$('.b-bottom-buttons2').hide();
				}
				else if (info.gender == 2 && e.count > 0) {
					$('.b-bottom-buttons2').show();
				}
			}
		});
	},
	
	sort: function() {
		this.sorting = $('#sort').val();
		
		this.onlineList();
	},
	
	page: function(page_id) {
		this.usersPage = page_id;
		
		this.onlineList();
	},
	
	selectToDelete: function(user_id) {
		if (this.selected != 0) {
			$('#id_contact_' + this.selected).removeClass('selected');
			this.selected = 0;
		}
		
		this.selected = user_id;
		$('#id_contact_' + this.selected).addClass('selected');
	},
	
	clearContact: function() {
		if (this.selected != 0) {
			$.ajax({
				url: info.url + 'my/chat/remove_contact',
				type: 'post',
				dataType: 'json',
				data: { user: this.selected },
				success: function(e) {
					if (e.result == 'success') {
						$('#id_contact_' + users.selected).remove();
						users.selected = 0;
						users.onlineList();
					}
				}
			});
		} else {
			alert('Please, select contact');
		}
	},
	
	clearContacts: function() {
		$.ajax({
			url: info.url + 'my/chat/remove_contact',
			type: 'post',
			dataType: 'json',
			data: { type: 'all' },
			success: function(e) {
				if (e.result == 'success') {
					users.selected = 0;
					$('#contact-list').html('');
					users.onlineList();
				}
			}
		});
	},
	
	invite: function(user_id) {
		$.ajax({
			url: info.url + 'my/chat/invite',
			type: 'post',
			dataType: 'json',
			data: { userId: user_id },
			success: function(e) {
				if (e.result == 'success') {
					users.onlineList();
					
					textchat.loadRoom(e.room);
				} else {
					alert(e.message);
				}
			}
		});
	},
	
	loadUser: function(room) {
		if (info.gender == 1) {
			$.ajax({
				url: info.url + 'my/chat/load_user',
				type: 'post',
				dataType: 'json',
				data: { room: room },
				success: function(e) {
					$('#user_avatar').attr('src', e.photo);
					$('#user_link').attr('href', '/user' + e.id);
					$('.b-contact-avatar-right').html(e.main);
					$('.b-contact-info-right').html(e.info);
					$('#w_name').html(e.name);
					$('#onlyVideo').show();
					//var gifturl = "window.location.href='" + info.url + "gift/id/" + e.id + "';";
					var gifturl = "window.open('"+info.url+"gift/id/" + e.id + "', '_blank');";
					$('.remove-all-contact-list3').attr('onclick', gifturl);
					
					$('#contact_block_wrap').css('bottom', '200px');
					$('#user_block_wrap').show();
				}
			});
		} else {
			$.ajax({
				url: info.url + 'my/chat/load_user',
				type: 'post',
				dataType: 'json',
				data: { room: room },
				success: function(e) {
					var menurl = "window.open('/user" + e.id + "', '_blank');";
					$('#men_img').css('cursor', 'pointer').attr('src', e.photo).attr('onClick', menurl);
				}
			});
		}
	},
	
	unloadUser: function() {
		if (info.gender == 1) {
			$('#user_block_wrap').hide();
			$('#contact_block_wrap').css('bottom', '0px');
			$('#onlyVideo').hide();
		} else {
			$('#men_img').css('cursor', 'default').attr('src', info.url + 'content/img/nophoto-mini.png').attr('onClick', '');
			$('#connect').hide();
		}
	},
	
	addFavorite: function(user_id) {
		$.ajax({
			url: info.url + 'my/chat/ajax/favorite',
			type: 'post',
			data: { user_id: user_id },
			dataType: 'json',
			success: function(e) {
				alert(e.message);
			}
		});
	},
	
	getInvites: function() {
		$.ajax({
			url: info.url + 'my/chat/ajax/check_chat',
			type: 'post',
			dataType: 'json',
			data: { id: info.selfId },
			success: function(e) {
				if (e.count > 0) {
					if (info.gender == 1) {
						$('#invites_container').append(e.text);
						
						if (textchat.is_sound == true) {
							ion.sound.play('new_notification');
						}
					} else {
						ion.sound.play('new_notification');
					}
				}
			}
		});
	}
}


//setInterval('users.getInvites()', 15000);


users.onlineList();
setInterval('users.onlineList()', 12000);
var videochat = {
	audio: 0,
	rtmfp: 'rtmfp://stratus.rtmfp.net/d1e1e5b3f17e90eb35d244fd-c711881365d9/',
	
	audioOn: function() {
		if (info.gender == 2) {
			this.audio = 1;
			
			$('#audio_on').css('color', '#70ba3c');
			$('#audio_off').css('color', 'gray');
			
			if (info.mycamera == 1) {
				$.post(info.url + 'my/videochat/audio', { audio: this.audio });
				
				setTimeout(function() {
					getFlashMovie('video1').setProperty('microphone', true);
				}, 1000);
			}
		}
	},
	
	audioOff: function() {
		if (info.gender == 2 && this.audio == 1) {
			this.audio = 0;
			
			$('#audio_off').css('color', 'red');
			$('#audio_on').css('color', 'gray');
			
			if (info.mycamera == 1) {
				$.post(info.url + 'my/videochat/audio', { audio: this.audio });
				
				setTimeout(function() {
					getFlashMovie('video1').setProperty('microphone', false);
				}, 1000);
			}
		}
	},
	
	cameraOn: function() {
		if (info.mycamera == 0) {
			var voice = false;
			
			if (this.audio == 1) {
				voice = true;
			}
			
			setTimeout(function () {
				getFlashMovie('video1').setProperty('src', videochat.rtmfp + '?publish=' + info.selfId);
				getFlashMovie('video1').setProperty('microphone', voice);
				getFlashMovie('video1').setProperty('cameraQuality', 95);
			}, 2000);
			
			
			info.mycamera = 1;
			
			$('#video_on').css('color', '#70ba3c');
			$('#video_off').css('color', 'gray');
		}
	},
	
	cameraOff: function() {
		if (info.mycamera == 1) {
			getFlashMovie('video1').setProperty('src', '');
			
			$.post(info.url + 'my/videochat/camera_off');
			
			info.mycamera = 0;
			
			$('#video_off').css('color', 'red');
			$('#video_on').css('color', 'gray');
		}
	},
	
	changeNearID: function(nearID) {		
		$.post(info.url + 'my/videochat/camera', { nearId: nearID, voice: this.voice });
    },
	
	pay: function() {
		if (info.room != '' && info.video == 1) {
			$.ajax({
				url: info.url + 'my/videochat/credits',
				type: 'post',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'error') {
						window.location.href = info.url + 'my/credits/';
					}
				}
			});
		}
	},
	
	checkLadyCamera: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/videochat/is_camera',
				type: 'post',
				dataType: 'json',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'success') {
						if (info.video == 0) {
							$('#connect').show();
						}
					} else {
						if (info.video == 1) {
							$('#connect').hide();
							videochat.disconnect();
						}
					}
				}
			});
		}
	},
	
	connect: function() {
		if (info.room != '') {
			$('#video2').show();
			
			$.ajax({
				url: info.url + 'my/videochat/load_near',
				method: 'post',
				dataType: 'json',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'success') {
						if (e.sound == 0) { sound = false; } else { sound = true; }
						
						setTimeout(function() {
							getFlashMovie('video2').setProperty('src', videochat.rtmfp + '?play=' + e.user + '&farID=' + e.nearId);
							getFlashMovie('video2').setProperty('sound', sound);
						}, 2000);						
						
						$('#connect').html('Stop video').attr('onClick', 'videochat.disconnect();');
						info.video = 1;
					}
				}
			});
		}
	},
	
	disconnect: function() {
		if (info.room != '' && info.video == 1) {
			getFlashMovie('video2').setProperty('src', '');
			$('#video2').hide();
			info.video = 0;
			$('#connect').html('Start video').attr('onClick', 'videochat.connect();');
			$.post(info.url + 'my/videochat/disconnect', { room: info.room });
		}
	},
	
	checkLadyVoice: function() {
		if (info.room != '' && info.video == 1) {
			$.ajax({
				url: info.url + 'my/videochat/check_voice',
				type: 'post',
				dataType: 'json',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'success') {
						setTimeout(function() {
							getFlashMovie('video2').setProperty('sound', true);
						}, 1000);
					} else {
						setTimeout(function() {
							getFlashMovie('video2').setProperty('sound', false);
						}, 1000);
					}
				}
			});
		}
	},
	
	cancelTo: function(room) {
		if (info.mycamera == 1) {
			$.post(info.url + 'my/videochat/cancel_man', { room: room });
			users.onlineList();
			alert('User was disconnected from your stream');
		}
	},
	
	approveTo: function(room) {
		if (info.mycamera == 1) {
			$.post(info.url + 'my/videochat/approve_man', { room: room });
			users.onlineList();
			alert('User was restored to your stream');
		}
	},
	
	checkManCamera: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/videochat/is_man_camera',
				type: 'post',
				dataType: 'json',
				data: { room: info.room },
				success: function(e) {
					if (e.result == 'success') {
						if (info.video == 0) {
							$('#connect').show();
						}
					} else {
						if (info.video == 1) {
							$('#connect').hide();
							videochat.disconnect();
						} else {
							$('#connect').hide();
						}
					}
				}
			});
		}
	},
	
	forAll: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/videochat/only',
				type: 'post',
				//dataType: 'json',
				data: { room: info.room, type: 1 },
				success: function() {
					$('#for_on').css('color', '#70ba3c');
					$('#for_off').css('color', 'gray');
				}
			});
		}
	},
	
	onlyChat: function() {
		if (info.room != '') {
			$.ajax({
				url: info.url + 'my/videochat/only',
				type: 'post',
				//dataType: 'json',
				data: { room: info.room, type: 2 },
				success: function() {
					$('#for_off').css('color', '#70ba3c');
					$('#for_on').css('color', 'gray');
				}
			});
		}
	}
}

if (info.gender == 1) {
	setInterval('videochat.pay()', 60000);
	setInterval('videochat.checkLadyCamera()', 8000);
	setInterval('videochat.checkLadyVoice()', 12000);
} else {
	setInterval('videochat.checkManCamera()', 8000);
}
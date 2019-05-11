var vm = new Vue({
    el: '#app',
    data: {
        step1Display: true,
        step1ErrorDisplay: false,
        step2Display: false,
        step3Display: false,
        calltoId: '',
        theirId: '...',
        video: true,
        audio: true,
        audioText: 'Disable',
        videoText: 'Disable',
        callerBrowser: '...',
        modalDisplay: false,
        fullScreen: false
    },
    methods: {
        makeCall: function () {
            var contact_id = parseInt($('#contact-list .item.selected').attr('contact-id'));
            if (parseInt >= 0) {
                return;
            }
            vm.calltoId = contact_id;
            var call = peer.call(vm.calltoId, window.localStream);
            step3(call);
        },

        endCall: function () {
            window.existingCall.close();
            step2();
        },

        step1Retry: function () {
            vm.step1ErrorDisplay = false;
            step1();
        },

        changeAudio: function () {
            vm.audio = !vm.audio;
            if (vm.audio) {
                vm.audioText = 'Disable';
            } else {
                vm.audioText = 'Enable';
            }
            window.localStream.getTracks().forEach(function (track) {
                if (track.kind === 'audio') {
                    track.enabled = vm.audio;
                }
            });
        },

        changeVideo: function () {
            vm.video = !vm.video;
            if (vm.video) {
                vm.videoText = 'Disable';
            } else {
                vm.videoText = 'Enable';
            }
            window.localStream.getTracks().forEach(function (track) {
                if (track.kind === 'video') {
                    track.enabled = vm.video;
                }
            });
        },

        acceptCall: function () {
            window.newCall.answer(window.localStream);
            vm.modalDisplay = false;
            step3(window.newCall);
        },

        declineCall: function () {
            window.newCall.close();
            vm.modalDisplay = false;
        },

        changeFullScreen: function () {
            vm.fullScreen = !vm.fullScreen;
        }
    }
});

var payTimeout;

function payMoney() {
    if (info.gender !== 1)
        return;

    var ladyCam = false;
    if (window.existingCall && window.existingCall.remoteStream) {
        window.existingCall.remoteStream.getTracks().forEach(function (track) {
            if (track.kind === 'video') {
                ladyCam = track.enabled;
            }
        });
    }

    if (ladyCam) {
        $.ajax({
            url: info.url + 'my/videochat/credits_new',
            type: 'post',
            data: { selfId: info.selfId, lady: vm.theirId },
            success: function(e) {
                if (e.result == 'error') {
                    window.location.href = info.url + 'my/credits/';
                }
            }
        });
    }

    clearTimeout(payTimeout);
    payTimeout = setTimeout(payMoney, 60000);
}

if (['Firefox', 'Chrome', 'Supported'].indexOf(util.browser) !== -1) {

    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    var peer;

    peer = new Peer(info.selfId, {
        host: 'server.testc4l.site',
        port: 9000,
        path: '/video-chat',
    });

    peer.on('open', function () {
    });

    peer.on('call', function (call) {
        window.newCall = call;
        vm.callerBrowser = window.newCall.options._payload.browser;
        vm.modalDisplay = true;
    });

    peer.on('error', function (err) {
        alert(err.message);
        // Return to step 2 if error occurs
        step2();
    });


    function step1() {
        navigator.getUserMedia({audio: vm.audio, video: vm.video}, function (stream) {
            // Set your video displays
            vm.$refs.myVideo.srcObject = stream;
            window.localStream = stream;
            step2();
        }, function () {
            vm.step1ErrorDisplay = true;
        });
    }

    function step2() {
        vm.step1Display = vm.step3Display = false;
        vm.step2Display = true;
    }

    function step3(call) {
        // Hang up on an existing call if present
        if (window.existingCall) {
            window.existingCall.close();
        }

        call.on('error', function (error) {
            //
        });

        call.on('stream', function (stream) {
            vm.$refs.theirVideo.srcObject = stream;
        });

        // UI stuff
        window.existingCall = call;
        vm.theirId = call.peer;
        call.on('close', step2);

        clearTimeout(payTimeout);
        payTimeout = setTimeout(payMoney, 60000);

        vm.step3Display = true;
        vm.step1Display = vm.step2Display = false;
    }

    step1();
}
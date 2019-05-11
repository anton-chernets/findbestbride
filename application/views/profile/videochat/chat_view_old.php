<div id="maket-account-050">
<script src="//simplewebrtc.com/latest.js"></script> 
<style type="text/css">
/**DT**/
#chatbox{
    display: block;
    width: 100%;
    height: 200px;
    margin: 0 auto;
    /* border: 1px solid brown; */
}
#roomsbox{
    display: block;
    height: 200px;
    margin: 0 300px 0 0; 
    border: 1px solid #888;        
    background-color: #efefef; 
    overflow-x: hidden;
    overflow-y: scroll;

}
#sendbox{
    clear: both;
    display: block;
    height: 10%;
    margin: 0 0;
    padding: 5px;
    /* border: 1px solid blue; */
}
#sendmsg,#msgbox{
   display: block;
   height: 50px;
}
#msgbox
{
   font-size: 1.2em;
   width: 73%;
   float: left;
   margin-right: 5px;
}
.msgbox{
    text-align: left;
}
#sendmsg{
    color: white;
    font-weight: bold;
    font-size: 1.5em;
    margin:5px;
    width: 25%;
    background: #fa4f00;
    background-image: -webkit-linear-gradient(top, #fa4f00, #ff0000);
    background-image: -moz-linear-gradient(top, #fa4f00, #ff0000);
    background-image: -ms-linear-gradient(top, #fa4f00, #ff0000);
    background-image: -o-linear-gradient(top, #fa4f00, #ff0000);
    background-image: linear-gradient(to bottom, #fa4f00, #ff0000);
}

#smilebox{
    display: block;
    height: 1em;
    margin: -1em 2em;
}
#smilebox img{
    margin: 3px;
}
.textmsg{
 color:#191970; 
 padding-left: 15px;
 padding-top: 5px;
 ext-indent: 1.5em;
}
.msgbox-1,.msgbox-0{
    display: block;
    padding: 5px 5px 5px 10px;
}
.msgbox-1
{
background-color: #F5FFFA;    
}
.msgbox-0
{
background-color: #FFFAF0;    
}
#my-video{
    float: right;
}
</style>
    
  <script>
/*
    peer.on('open', function(){
      $('#my-id').text(peer.id);
    	
    });

    // �������������� ����� �� ������
    peer.on('call', function(call){
      call.answer(window.localStream);
      step3(call);
    });
    peer.on('error', function(err){
      alert(err.message);
      // �������� �����, ���� ������
      step2();
    });

	
    $(function(){
   		<? if($room != NULL): ?>
        $('#make-call').click(function(){
            // Initiate a call!
            var call = peer.call('<?=$room?>', window.localStream);
            step3(call);
        });
      <? endif; ?>

      $('#end-call').click(function(){
        window.existingCall.close();
        step2();
      });

      // ���� � ������ � ����� ������ �� �������
      $('#step1-retry').click(function(){
        $('#step1-error').hide();
        step1();
      });

      step1();
    });

    function step1 () {
      // ������� ����� � �����
      navigator.getUserMedia({audio: true, video: true}, function(stream){
        // ��������� ����������� �����
        $('#my-video').prop('src', URL.createObjectURL(stream));

        window.localStream = stream;
        step2();
      }, function(){ $('#step1-error').show(); });
    }

    function step2 () {
      $('#step1, #step3').hide();
      $('#step2').show();
    }

    function step3 (call) {
      // ���� ��� ���� ������, ������� ���
      if (window.existingCall) {
        window.existingCall.close();
      }

      // ���� ����������� ������� ������������, ����� ��������� �����
      call.on('stream', function(stream){
        $('#their-video').prop('src', URL.createObjectURL(stream));
      });

      window.existingCall = call;
      $('#their-id').text(call.peer);
      call.on('close', step2);
      $('#step1, #step2').hide();
      $('#step3').show();
    }
*/
  </script>
 <style type="text/css">
     #remoteVideo { height: 50%; margin-top: 5%; background: #000; }
</style>
 
 
  <div id="status" style="background-color:transparent;color:red;display:block;height:50px;width:500px">
     <!-- Start Message: <?php echo (!$room)?$roomname:$room; ?> -->
 </div>    
 <?php 
    $roomname = (!$roomname)?$room:$roomname;
    //echo "[$roomname]:[$room]"; 
    ?>
 <? 
    if($this->userInfo['sex'] == 1){
        echo '<input type="hidden" id="ptype" value="0" />';
    }
 ?>
 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="430" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('video_chat_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="430" height="8px">
     </div> 

<div class="edit-content">
<div class="pure-g">
      <div class="pure-u-2-3" id="video-container">
        <!-- <video id="their-video" autoplay></video> -->
        <div id="remoteVideos"></div>
        <div id="chatbox">
            <video id="my-video" muted="true" autoplay></video>
            <div id="roomsbox"></div>
            <div id="sendbox">
                <textarea id="msgbox" name="msg_content"></textarea>
                <button name="sendmsg" id="sendmsg" onclick="_send()">Send</button>
            </div>
        </div>
        
      </div>
      <div id="clear"></div>
      <div class="pure-u-1-3">
          
              <!-- Get local audio/video stream -->
        <div id="step1">
          <p><?=$this->lang->line('video_camera_info')?></p>
          <div id="step1-error">
            <p><?=$this->lang->line('video_camera_false')?></p>
            <a href="#" class="pure-button pure-button-error" id="step1-retry">Try again</a>
          </div>
        </div>

        <!-- Make calls to others -->
       <? if($room): ?>
        <div id="step2">
          <div class="pure-form">
            
            <div align="center"><button type="button" id="make-call" class="btn">Make call</button></div>
          </div>
        </div>
		<? else: ?>
		<div id="step2">
			<div align="center"><img src="<?=base_url()?>content/img/712.gif"><br/><b>Loading answer...</b></div>
		</div>
		<? endif; ?>
        <!-- Call in progress -->
        <div id="step3">
          
          <div align="center"><button type="button" id="end-call" class="btn">End call</button></div>
        </div>
        </div>
</div>
</div>
</div>
<div id="clear"></div>

<script>
    $('#roomsbox,#msgbox').attr('readonly', true);
    $('#sendmsg').attr("disabled", true); 
    
    <? if(!$room): ?>
    	$.ajax({
    		url: '<?=base_url()?>my/videochat/ajax/create_room/',
    		type: 'POST',
    		dataType: 'json',
//    		data: { name: peer.id, invite: '<?=$invite?>' },
                data: { name: '<?=$roomname?>', invite: '<?=$invite?>' },
    		success: function(obj) {
    			if (obj.result == 'success') {
    			}
    		}
    	});
    <?endif;?>
    
    var webrtc = new SimpleWebRTC({
      localVideoEl: 'my-video',
      remoteVideosEl: '',
      autoRequestMedia: true,
      url: 'http://s1.donteam.net:8001/'
   });
                             
   webrtc.on('readyToCall', function () {
   // you can name it anything
       webrtc.joinRoom('<?php echo (!$room)?$roomname:$room; ?>');
   });                       

    // we did not get access to the camera
    webrtc.on('localMediaError', function (err) {
    
    });

webrtc.on('videoAdded', function (video, peer) {
    //console.log('video added', peer);
//    var remotes = document.getElementById('their-video');
    var remotes = document.getElementById('remoteVideos');

    if (remotes) {
        var container = document.createElement('div');
        container.className = 'videoContainer';
        container.id = 'container_' + webrtc.getDomId(peer);
        container.appendChild(video);
            
        // suppress contextmenu
        video.oncontextmenu = function () { return false; };
        // show the remote volume
    
        // show the ice connection state
        if (peer && peer.pc) {
        var ptp = 0;     
        var connstate = document.getElementById('status');
        peer.pc.on('iceConnectionStateChange', function (event) {
            switch (peer.pc.iceConnectionState) {
                case 'checking':
                    connstate.innerText = 'Connecting to peer...';
                    ptp = 0;
                    break;
                case 'connected':
                case 'completed': // on caller side
                    connstate.innerText = 'Connection established.';
                    ptp = 1;
                    $('#roomsbox').load('<?=base_url()?>my/videochat/ajax/load_messages/<?=$roomname?>');
                    $('#roomsbox,#msgbox').attr('readonly', false);
                    $('#sendmsg').attr("disabled", false); 
                    break;
                case 'disconnected':
                    connstate.innerText = 'Disconnected.';
                    ptp = 0;
                    $('#roomsbox,#msgbox').attr('readonly', true);
                    $('#sendmsg').attr("disabled", true); 
                    break;
                case 'failed':
                    connstate.innerText = 'Connection failed.';
                    ptp = 0;
                    break;
                case 'closed':
                    connstate.innerText = 'Connection closed.';
                    ptp = 0;
                    $('#roomsbox,#msgbox').attr('readonly', true);
                    $('#sendmsg').attr("disabled", true); 
                    break;
            }
            var pstat = document.getElementById('ptype');
            pstat.value = ptp;
           
        });
    }
    remotes.innerHTML = '';//removeChild(container);
    remotes.appendChild(container);

    }
});

/*
webrtc.createRoom(val, function (err, name) {
    console.log(' create room cb', arguments);
    var newUrl = location.pathname + '?' + name;
    if (!err) {
        history.replaceState({foo: 'bar'}, null, newUrl);
        setRoom(name);
    } else {
        console.log(err);
    }
});
*/


var newMessages = setInterval(preload, 3000);

function preload()
{
    
 /*       var pstat = document.getElementById('ptype').value;

        if(pstat.value == 1)
        {    
*/	$.ajax({
		url: '<?=base_url()?>my/videochat/ajax/preload_new/',
		type: 'POST',
		dataType: 'json',
		data: { name: '<?=$roomname?>' },
		success: function(obj) {
			if (obj.result == 'success') {
				$('#roomsbox').append(obj.html);
				if (obj.sound == '1' && isSound == true)
				{
					ion.sound.play("chat_new_message");
				}
				_scrollBottom();
			}
		}
	});
//    }    
}


function _send()
{
	var msg = $('#msgbox').val();

	if (msg == '')
	{
		alert('Type your message');
		return;
	}

            $.post('<?=base_url()?>my/videochat/ajax/send/',{
		message: msg,
		name: '<?=$roomname?>'
		},
		function(data){	
			if( data.status == 'success' ){
				$('#msgbox').val('');
				$('#roomsbox').append(data.html);
				_scrollBottom();
			}
			else
			{
				alert('<?=$this->lang->line('chat_closed')?>');
				window.location.href='<?=base_url()?>my/videochat/';
			}
		},
		'json');       
               
}

$('#msgbox').keydown(function(eventObject){
    if(eventObject.which == 13) _send();
})

function _scrollBottom(){
	if( $('#roomsbox').length )
		$('#roomsbox').get(0).scrollTop = $('#roomsbox').get(0).scrollHeight;
    }


</script>    


<script type="text/javascript">
<? if($this->userInfo['sex'] == 1):?>
    
var minusCredits = setInterval(minusCreds, 60000);

function minusCreds()
{
        var pstat = document.getElementById('ptype').value;

        if(pstat.value == 1)
        {    
            $.ajax({
		url: '<?=base_url()?>my/chat/ajax/minus_credits/',
		type: 'POST',
		dataType: 'json',
		data: { id: '1' },
		success: function(obj) {
			if (obj.result == 'error') {
				clearInterval(minusCredits);
				alert(obj.message);
				window.location.href = '<?=base_url()?>my/credits/';
			}
		}
            });
        }
}
<? endif; ?>

<? if(!$room): ?>

var ans = setInterval(checkAnswer, 10000);

function checkAnswer()
{
	$.ajax({
		url: '<?=base_url()?>my/videochat/ajax/check_answer/',
		type: 'POST',
		dataType: 'json',
		data: { id: '1' },
		success: function(obj) {
			if (obj.result == 'success') {
				clearInterval(ans);
			}

			else if (obj.result == 'error')
			{
				clearInterval(ans);
				alert('User declined your request');
				window.location.href = '<?=base_url()?>my/videochat/';
			}

/*			else if (obj.result == 'timeout')
			{
				clearInterval(ans);
				alert('Your request timed out');
				window.location.href = '<?=base_url()?>my/videochat/';
			}*/
		}
	});
        
} 
<? endif; ?>

</script>
<div id="maket-account-050">

  <script>

    // Compatibility shim
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // PeerJS object
    var peer = new Peer({ key: 'yrtnfida6m6ajor', debug: 3, config: {'iceServers': [
      { url: 'stun:stun.l.google.com:19302' } // Pass in optional STUN and TURN server for maximum network compatibility
    ]}});

    peer.on('open', function(){
      $('#my-id').text(peer.id);
	<? if(!$room): ?>
    	$.ajax({
    		url: '<?=base_url()?>my/videochat/ajax/create_room/',
    		type: 'POST',
    		dataType: 'json',
    		data: { name: peer.id, invite: '<?=$invite?>' },
    		success: function(obj) {
    			if (obj.result == 'success') {
    			}
    		}
    	});
    <?endif;?>
    	
    });

    // автоматический ответ на звонок
    peer.on('call', function(call){
      call.answer(window.localStream);
      step3(call);
    });
    peer.on('error', function(err){
      alert(err.message);
      // вернемся назад, если ошибка
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

      // если к камере и микро доступ не получен
      $('#step1-retry').click(function(){
        $('#step1-error').hide();
        step1();
      });

      step1();
    });

    function step1 () {
      // получим аудио и видео
      navigator.getUserMedia({audio: true, video: true}, function(stream){
        // отобразим собственный стрим
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
      // если уже есть звонок, закроем его
      if (window.existingCall) {
        window.existingCall.close();
      }

      // ждем подключения второго пользователя, после отобразим видео
      call.on('stream', function(stream){
        $('#their-video').prop('src', URL.createObjectURL(stream));
      });

      window.existingCall = call;
      $('#their-id').text(call.peer);
      call.on('close', step2);
      $('#step1, #step2').hide();
      $('#step3').show();
    }

  </script>
  
 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="430" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('video_chat_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="430" height="8px">
     </div> 

<div class="edit-content">
<div class="pure-g">
      <div class="pure-u-2-3" id="video-container">
        <video id="their-video" autoplay></video>
        <video id="my-video" muted="true" autoplay></video>
      </div>
      
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

<script type="text/javascript">
<? if($this->userInfo['sex'] == 1):?>
var minusCredits = setInterval(minusCreds, 60000);

function minusCreds()
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

			else if (obj.result == 'timeout')
			{
				clearInterval(ans);
				alert('Your request timed out');
				window.location.href = '<?=base_url()?>my/videochat/';
			}
		}
	});
}
<? endif; ?>
</script>

<style type="text/css">
/**DT**/
#chatbox{
	
    display: block;
    width: 100%;
    height: 360px;
    margin: 0 auto;
    border: 1px solid #31708F;
	background: #fff;
}
#roomsbox{
    display: block;
    height: 225px;
    margin: 0 300px 0 0; 
    border-bottom: 1px solid #888;
    border-right: 1px solid #888;
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
	width:550px;
    display: block;
    text-align: left;
    height: 2em;
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
#video1{
    float: right;
	margin-right: 70px;
	margin-top: 10px;
}
#video2 {
	padding-bottom: 15px;
}
</style>
   
 <style type="text/css">
     #remoteVideo { height: 50%; background: #000; }
</style>
 
 
  <div id="status" style="background-color:transparent;color:red;display:block;height:50px;width:500px;position:absolute">
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

<div id="maket-account-050">
	<div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="410" height="8px">
        <div class="h2" style="float:left;" align="center">VIDEOCHAT</div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="410" height="8px">
     </div> 
	<div class="text-osnov">

<div class="pure-g">
      <div class="pure-u-2-3" id="video-container">
        <!-- <video id="their-video" autoplay></video> -->
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
				id="video2" width="540" height="350"
				codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
				<param name="movie" value="<?=base_url()?>content/swf/VideoIO.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="allowFullScreen" value="true" />
				<param name="allowScriptAccess" value="always" />
				<param name="flashVars" value="controls=true" />
				<embed src="<?=base_url()?>content/swf/VideoIO.swf" quality="high" bgcolor="#000000"
					width="540" height="300" name="video2" align="middle"
					play="true" loop="false" quality="high"
					allowFullScreen="true"
					allowScriptAccess="always"
					flashVars="controls=true"
					type="application/x-shockwave-flash"
					pluginspage="http://www.adobe.com/go/getflashplayer">
				</embed>
			</object>
			<br><br>
        <div id="chatbox">
           <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
						id="video1" width="260" height="200" style="padding-left: 55px;"
						codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
						<param name="movie" value="<?=base_url()?>content/swf/VideoIO.swf" />
						<param name="quality" value="high" />
						<param name="bgcolor" value="#FFFFFF" />
						<param name="allowFullScreen" value="true" />
						<param name="allowScriptAccess" value="always" />
						<param name="flashVars" value="controls=false" />
						<embed src="<?=base_url()?>content/swf/VideoIO.swf" quality="high" bgcolor="#FFFFFF"
							width="260" height="200" name="video1" align="middle"
							play="true" loop="false" quality="high"
							allowFullScreen="true"
							allowScriptAccess="always"
							flashVars="controls=false"
							type="application/x-shockwave-flash"
							pluginspage="http://www.adobe.com/go/getflashplayer">
						</embed>
				</object>
            <div id="roomsbox"></div>
            <div id="sendbox">
                <textarea id="msgbox" name="msg_content"></textarea>
                <button name="sendmsg" id="sendmsg" onclick="_send()">Send</button>
<!-- SMILE BLOCK -->
<br>
<div id="smilebox">
<?php
    $smile = array(0,1,8,11,10,22,12,5,4,2,3,6,9,13,14,15,16,17,18,19,20,27,21,23);
    $num = count($smile);
    $path = base_url();
    for($i=1;$i<$num;$i++) {
        echo '<img style="cursor:pointer;" onClick="insertSmile('.$i.')" src="'.$path.'content/img/smiles/'.$smile[$i].'.png">';
}    
?>
</div>

<!--  /SMILE BLOCK -->
            </div>
        </div>
        
      </div>
</div>
</div>
</div>


<script>
	function getFlashMovie(movieName) {
		var isIE = navigator.appName.indexOf("Microsoft") != -1;
		return (isIE) ? window[movieName] : document[movieName];  
	}
		
	function onPropertyChange(event) {
		if (event.property == 'nearID') {
			if (event.objectID == 'video1') {
				updateNearID(event.newValue);
					
				console.log('NearID was changed', event.newValue);
			}
		}
	}
	
	function updateNearID(nearId) {
		$.ajax({
			url: '<?=base_url()?>my/videochat/near',
			type: 'post',
			dataType: 'json',
			data: { nearId: nearId }
		});
	}
	
	var root = 'rtmfp://stratus.rtmfp.net/d1e1e5b3f17e90eb35d244fd-c711881365d9/';
	</script>

<script>
	//$(document).ready(function() {
	setTimeout(function() {
	//window.onload = function() {
		getFlashMovie('video1').setProperty('src', root + '?publish=<?=$this->selfId?>');
		getFlashMovie('video1').setProperty('microphone', false);
		getFlashMovie('video1').setProperty('cameraQuality', 90);
	//};
	}, 3000);
	//});
	
	var checkCamera = setInterval('checkUserCamera()', 5000);
	
	function checkUserCamera() {
		$.ajax({
			url: '<?=base_url()?>my/videochat/check_camera',
			type: 'post',
			dataType: 'json',
			data: { room: '<?=$room?>' },
			success: function(e) {
				if (e.result == 'success') {
					setTimeout(function() {
						getFlashMovie('video2').setProperty('src', root + '?play=' + e.user + '&farID=' + e.farID);
						console.log('Chat loaded', root+ '?play=' + e.user + '&farID=' + e.farID);
					}, 10000);
					
					clearInterval(checkCamera);
				} else {
					console.log('No camera found');
				}
			}
		});
	}
</script>

<script>

    $('#roomsbox').attr('readonly', true);
   // $('#sendmsg').attr("disabled", true); 
    
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
firstminusCreds();    
var minusCredits = setInterval(minusCreds, 60000);

function minusCreds()
{
        var pstat = document.getElementById('ptype').value;
console.log('Pstat:'+pstat);
        //if(pstat == 1)
      //  {    
            $.ajax({
		url: '<?=base_url()?>my/videochat/ajax/minus_credits/',
		type: 'POST',
		dataType: 'json',
		data: { id: '2', room: '<?=$roomname?>' },
		success: function(obj) {
			if (obj.result == 'error') {
				clearInterval(minusCredits);
                                window.webrtc.stopLocalVideo();
                                window.webrtc.leaveRoom();
				alert(obj.message);
				window.location.href = '<?=base_url()?>my/credits/';
			}
		}
            });
        //}
}
function firstminusCreds()
{
        var pstat = document.getElementById('ptype').value;

            $.ajax({
		url: '<?=base_url()?>my/chat/ajax/check_credits/',// minus_credits/',
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

function insertSmile(id)
{
	$('#msgbox').val($('#msgbox').val() + ':'+id+':');
}

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
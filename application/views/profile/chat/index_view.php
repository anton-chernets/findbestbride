<div id="maket-account-050">
	 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="430" height="8px">
        <div class="h2" style="float:left;" align="center">CHAT</div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="430" height="8px">
     </div> 
	<div>

<div style="position:absolute; top: 285px; left: 460px; display:none;" id="remoteVideo">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
				id="video2" width="240" height="190"
				codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
				<param name="movie" value="<?=base_url()?>content/swf/VideoIO.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="allowFullScreen" value="true" />
				<param name="allowScriptAccess" value="always" />
				<param name="flashVars" value="controls=true" />
				<embed src="<?=base_url()?>content/swf/VideoIO.swf" quality="high" bgcolor="#000000"
					width="340" height="210" name="video2" align="middle"
					play="true" loop="false" quality="high"
					allowFullScreen="true"
					allowScriptAccess="always"
					flashVars="controls=false"
					type="application/x-shockwave-flash"
					pluginspage="http://www.adobe.com/go/getflashplayer">
				</embed>
			</object>
</div>

<div id="clear"></div>
<div id="chatbox">
<div id="chat-all">
    <div id="panelbox">
        <input type="hidden" id="actroom" value="<?php echo $room;?>" />
        <input type="hidden" id="actuser" value="<?php echo $actuser;?>" />
		
    </div>	
	
		<div class="chat-left">
			<div class="chat-title user-online ">On-Line</div>
			<div id="userbox"></div>
			</div>
		
		<div class="chat-center">
		<div class="help-chat" title="Instruction"><a href="javascript:;" onClick="$('#showModalWindow').arcticmodal();"><img src="<?=base_url()?>content/chat/help_chat.jpg" style="width:25px;"></a></div>
			<div id="roomsbox"></div>
				<!-- SMILE BLOCK -->
<div id="smilebox">
<img class="smile" onClick="insertSmile(1)" src="<?=base_url()?>content/chat/1.gif" title="Smile">
<img class="smile" onClick="insertSmile(2)" src="<?=base_url()?>content/chat/2.gif" title="Sad">
<img class="smile" onClick="insertSmile(3)" src="<?=base_url()?>content/chat/3.gif" title="Laugh">
<img class="smile" onClick="insertSmile(4)" src="<?=base_url()?>content/chat/4.gif" title="Hi">
<img class="smile" onClick="insertSmile(5)" src="<?=base_url()?>content/chat/5.gif" title="Winks">
<img class="smile" onClick="insertSmile(6)" src="<?=base_url()?>content/chat/6.gif" title="I wonder">
<img class="smile" onClick="insertSmile(7)" src="<?=base_url()?>content/chat/7.gif" title="Crying smiley">
<img class="smile" onClick="insertSmile(8)" src="<?=base_url()?>content/chat/8.gif" title="Mmm...">
<img class="smile" onClick="insertSmile(9)" src="<?=base_url()?>content/chat/9.gif" title="Hee hee">
<img class="smile" onClick="insertSmile(10)" src="<?=base_url()?>content/chat/10.gif" title="Kiss">
<img class="smile" onClick="insertSmile(11)" src="<?=base_url()?>content/chat/11.gif" title="Sly">
<img class="smile" onClick="insertSmile(12)" src="<?=base_url()?>content/chat/12.gif" title="Red">
<img class="smile" onClick="insertSmile(13)" src="<?=base_url()?>content/chat/13.gif" title="Doubt">
<img class="smile" onClick="insertSmile(14)" src="<?=base_url()?>content/chat/14.gif" title="Sleepy">
<img class="smile" onClick="insertSmile(15)" src="<?=base_url()?>content/chat/15.gif" title="I'm bored">
<img class="smile" onClick="insertSmile(16)" src="<?=base_url()?>content/chat/16.gif" title="Love">
<img class="smile" onClick="insertSmile(17)" src="<?=base_url()?>content/chat/17.gif" title="Evil grin">
<img class="smile" onClick="insertSmile(18)" src="<?=base_url()?>content/chat/18.gif" title="Yawn">
<img class="smile" onClick="insertSmile(19)" src="<?=base_url()?>content/chat/19.gif" title="Evil">
<img class="smile" onClick="insertSmile(20)" src="<?=base_url()?>content/chat/20.gif" title="It's not me!">
<img class="smile" onClick="insertSmile(21)" src="<?=base_url()?>content/chat/21.gif" title="Celebration">
<img class="smile" onClick="insertSmile(22)" src="<?=base_url()?>content/chat/22.gif" title="What to do?">
<img class="smile" onClick="insertSmile(23)" src="<?=base_url()?>content/chat/23.gif" title="I get tired of waiting">
<img class="smile" onClick="insertSmile(24)" src="<?=base_url()?>content/chat/24.gif" title="Winding head">
<img class="smile" onClick="insertSmile(25)" src="<?=base_url()?>content/chat/25.gif" title="Nod">
<img class="smile" onClick="insertSmile(26)" src="<?=base_url()?>content/chat/26.gif" title="Angel">
<img class="smile" onClick="insertSmile(27)" src="<?=base_url()?>content/chat/27.gif" title="Happiness">
<img class="smile" onClick="insertSmile(28)" src="<?=base_url()?>content/chat/28.gif" title="Makeup">
<img class="smile" onClick="insertSmile(29)" src="<?=base_url()?>content/chat/29.gif" title="Well done!">
<img class="smile" onClick="insertSmile(30)" src="<?=base_url()?>content/chat/30.gif" title="Applause">
<img class="smile" onClick="insertSmile(31)" src="<?=base_url()?>content/chat/31.gif" title="I think">
<img class="smile" onClick="insertSmile(32)" src="<?=base_url()?>content/chat/32.gif" title="Rolling on the floor laughing">
<img class="smile" onClick="insertSmile(42)" src="<?=base_url()?>content/chat/42.gif" title="Heart">
<img class="smile" onClick="insertSmile(43)" src="<?=base_url()?>content/chat/43.gif" title="Flower">
<img class="smile" onClick="insertSmile(45)" src="<?=base_url()?>content/chat/45.gif" title="The sun">
<img class="smile" onClick="insertSmile(47)" src="<?=base_url()?>content/chat/47.gif" title="Broken heart">
</div>
<!--  /SMILE BLOCK -->
        <div id="sendbox" style="float:left;">
        <textarea id="msgbox" name="msg_content" placeholder="Type your message"></textarea>
        <button name="sendmsg" id="sendmsg" onclick="send()">Send</button>
    </div>
	<div class="prof-msg" id="a_user">
	<a href="#" title="View profile">
	<img src="<?=base_url()?>content/img/no-foto-100.png" title="View profile" style="width:100px;">
	</a>
	<!--<div class="chat-button profile-button">
	<a href="#" title="View profile">
	View profile
	</a>
	</div>
	
	<div class="chat-button video-button">
	<a  href="#" title="Open video chat">
	Video chat
	</a>
	</div>-->
	</div>
		</div>
	<div class="chat-right">
		<div class="my-profile">
		<div class="chat-title">My Profile</div>
			<? if($this->userInfo['photo_link'] == '') { ?>
			<img src="<?=base_url()?>content/img/no-foto-100.png" style="width:100px; padding-top: 15px; float:left;">
			<? } else { ?>
			<img src="<?=base_url()?>profiles/photo/user_<?=$this->selfId?>/<?=$this->userInfo['photo_link']?>_101.jpg" style="width: 100px; padding-top: 15px; float: left;">
			<? } ?>
			<div style="float:left; padding-top: 30px; padding-left: 10px;"><? if(strlen($this->userInfo['name']) > 10) { echo substr($this->userInfo['name'], 0, 7) . '...'; } else { echo $this->userInfo['name']; }?><br>ID: <?=$this->selfId;?></div>
			
			<?php if($this->userInfo['sex'] == 2) { ?>
			<div style="padding-top:65px;" class="chat-button video-button"><a href="javascript:;" onClick="activateWomanCamera();">ON Camera</a></div>
			<?php } elseif ($this->userInfo['sex'] == 1) { ?>
			<div style="padding-top:65px;display:none;" class="chat-button video-button" id="manVideoBtn"><a href="javascript:;" onClick="activateWomanCamera();">ON Camera</a></div>
			<?php } ?>
		</div>
		<div id="myVideo" style="display:none;">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
				id="video1" width="200" height="150" 
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
			<br>
			<div class="chat-button clear-button"><a href="javascript:;" onClick="deactivateWomanCamera();">OFF Camera</a></div>
		</div>
		<div class="chat-title">Chat List</div>
		<div id="historybox"></div>
	<div class="chat-button clear-button" style="width:60%; margin: 10px auto 0 auto">	
	<a href="javascript:;" onClick="delete_history();">Clear chat list</a>
	</div>
		</div>

    
	
</div>    


</div>

<!-- Modal -->
<div style="display:none;">
       		<div class="box-modal" id="showModalWindow">
				<div class="box-modal_close arcticmodal-close">close</div>
        How to enter the chat?
<br><br>
In order to enter the chat there are several ways: click “chat on” your home page;
<br>or  click on «Videochat» on your panel (there you will see all ladies online and you can invite them to have a text or video chat);
<br>or click on “text chat” on your account page.

<br><br>
How to start the chat?
<br><br>
To start chatting, select a lady  from the list of women online in the left part of chat page, click on the picture of a lady and click on the blue button.
<br>When the lady's photo will appear in the upper part of chat list, write your message in the box lower the chat list and click on the icon “send message” to send your message or use the button “enter” on your keyboard.
<br>You will see your message in the chat window.When a lady accepts your invitation, then a small blue icon will be changed to the red icon.
<br>If a lady is not currently willing to communicate, the icon will not be changed.
<br><br>
How to accept an invitation from a lady?
<br><br>
If a lady invites you to chat, you will see a pop-up window where there will be lady's photo and two options: accept or decline. Click the button “accept” and start chatting with a lady.
<br>If you are busy or not interested in chatting with this lady, click on button “decline”.
<br><br>
How to see lady's profile in chat?
<br><br>
To view the lady's profile, click on the green icon near the lady's photo, and it will be opened  in a new browser window.
<br><br>
How does the “Contact List” work?
<br><br>
The “contact list” shows all ladies with whom you had a chat and it is placed in the right part of chat page.
<br>With the help of “contact list” you can identify a current status of your lady, and switch between sessions if you communicate with more than one ladies.
<br>Ladies that are shown in “contact list” are not shown in the list of “ladies online”.
<br>In order to remove a lady from the “contact list”, click on the photo of a lady and then click the red button. Also in the bottom you will see the  option “clear contact list” if you want to remove all contacts.

      </div>
    </div>
  </div>

<script type="text/javascript">
var chatInfo = {
	url: '<?=base_url();?>',
	sex: <?=$this->userInfo['sex'];?>,
	video: 0,
	videoId: 0,
	myVideo: 0,
	id: <?=$this->selfId;?>,
	isMan: 0
};

ion.sound({
    sounds: [
        {
            name: 'chat_new_message',
            volume: 0.5
        },
    ],
    path: '/content/sound/',
    preload: true
});

$(document).ready(function(){
    $('#msgbox').attr('readonly', true);
    $('#sendmsg').attr('disabled', true);
 
   GetUsers();
   var newUsers = setInterval(GetUsers, 5000);
   getHistory();
   
   var newMessages = setInterval(preload, 4000);
});  

$('#msgbox').keydown(function(eventObject){
    if(eventObject.which == 13) send();
});  

if (chatInfo.sex == 1) {
	firstminusCreds();
	setInterval(minusCreds, 60000);
	
	var loadUserInterval = setInterval(loadUserCamera, 9000);
}
else if (chatInfo.sex == 2) {
	var checkManCamera = setInterval(isManCamera, 6000);
}

$('#userbox').on('click','.user',function(){
    $('#userbox').find('.user').removeClass('active');
    $(this).addClass('active');
	$(this).removeAttr('style');
    $('#actuser').val($(this).attr('uid'));
    $('#actroom').val($(this).find('#room').attr('rname'));
       
    $('#roomsbox').load(chatInfo.url + 'my/chat/ajax/load_messages/'+$(this).find('#room').attr('rname'));
	loadUser($(this).attr('uid'));
	_scrollBottom();
	
    var room = $('.active .usrdata ').find('#room').attr('rname');
	
    if(typeof(room) == 'string' && room != '') {
        $('#msgbox').attr('readonly', false);
        $('#sendmsg').attr('disabled', false);
    }
    else {
        $('#msgbox').attr('readonly', true);
        $('#sendmsg').attr('disabled', true);            
    }
});

<?php if($actuser != '') { ?>
loadUser(<?=$actuser;?>);
<?php } ?>
</script> 

<script type="text/javascript">
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
		$.post(chatInfo.url + 'my/chat/near', { nearId: nearId });
	}
	
	var root = 'rtmfp://stratus.rtmfp.net/d1e1e5b3f17e90eb35d244fd-c711881365d9/';
</script>                                                       

</div>
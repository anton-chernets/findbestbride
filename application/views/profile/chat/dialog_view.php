<div id="maket-account-050">

 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="450" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('chat_page_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="450" height="8px">
     </div> 

<div class="edit-content">
<div align="right"><a href="<?=base_url()?>my/videochat/conference/invite/<?=$info['id']?>" target="_blank"><img src="<?=base_url()?>content/img/movie.png"><b>Invite to videochat</b></a><br/>
<span id="mute"><a href="#." onClick="mute(1);"><img src="<?=base_url()?>content/img/mute.png"><b>turn off sound</b></a></span>
<br/><a href="<?=base_url()?>my/chat/close/<?=$c_name?>"><img src="<?=base_url()?>content/img/close.png"><b>close chat</b></a></div>
<div style="margin-top:5px;" id="message_box">

</div>
<div id="message_form">
<div class="float_left">
<div align="center">
<table border="0">
<tr><td><? if($this->userInfo['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$this->selfId?>/<?=$this->userInfo['photo_link']?>_101.jpg"><?else:?><img src="<?=base_url()?>content/img/no-foto-100.png"><?endif;?><br/><b><center><?=$this->userInfo['name']?></center></b>
</td><td><textarea rows="3" id="msg_content" name="message"></textarea><br/>
<!-- SMILE BLOCK -->

<img style="cursor:pointer;" onClick="insertSmile(1)" src="<?=base_url()?>content/img/smiles/1.png">
<img style="cursor:pointer;" onClick="insertSmile(2)" src="<?=base_url()?>content/img/smiles/8.png">
<img style="cursor:pointer;" onClick="insertSmile(3)" src="<?=base_url()?>content/img/smiles/11.png">
<img style="cursor:pointer;" onClick="insertSmile(4)" src="<?=base_url()?>content/img/smiles/10.png">
<img style="cursor:pointer;" onClick="insertSmile(5)" src="<?=base_url()?>content/img/smiles/22.png">
<img style="cursor:pointer;" onClick="insertSmile(6)" src="<?=base_url()?>content/img/smiles/12.png">
<img style="cursor:pointer;" onClick="insertSmile(7)" src="<?=base_url()?>content/img/smiles/5.png">
<img style="cursor:pointer;" onClick="insertSmile(8)" src="<?=base_url()?>content/img/smiles/4.png">
<img style="cursor:pointer;" onClick="insertSmile(9)" src="<?=base_url()?>content/img/smiles/2.png">
<img style="cursor:pointer;" onClick="insertSmile(10)" src="<?=base_url()?>content/img/smiles/3.png">
<img style="cursor:pointer;" onClick="insertSmile(11)" src="<?=base_url()?>content/img/smiles/6.png">
<img style="cursor:pointer;" onClick="insertSmile(12)" src="<?=base_url()?>content/img/smiles/9.png">
<img style="cursor:pointer;" onClick="insertSmile(13)" src="<?=base_url()?>content/img/smiles/13.png">
<img style="cursor:pointer;" onClick="insertSmile(14)" src="<?=base_url()?>content/img/smiles/14.png">
<img style="cursor:pointer;" onClick="insertSmile(15)" src="<?=base_url()?>content/img/smiles/15.png">
<img style="cursor:pointer;" onClick="insertSmile(16)" src="<?=base_url()?>content/img/smiles/16.png">
<img style="cursor:pointer;" onClick="insertSmile(17)" src="<?=base_url()?>content/img/smiles/17.png">
<img style="cursor:pointer;" onClick="insertSmile(18)" src="<?=base_url()?>content/img/smiles/18.png">
<img style="cursor:pointer;" onClick="insertSmile(19)" src="<?=base_url()?>content/img/smiles/19.png">
<img style="cursor:pointer;" onClick="insertSmile(20)" src="<?=base_url()?>content/img/smiles/20.png">
<img style="cursor:pointer;" onClick="insertSmile(21)" src="<?=base_url()?>content/img/smiles/27.png">
<img style="cursor:pointer;" onClick="insertSmile(22)" src="<?=base_url()?>content/img/smiles/21.png">
<img style="cursor:pointer;" onClick="insertSmile(23)" src="<?=base_url()?>content/img/smiles/23.png">


<!--  /SMILE BLOCK -->
</td>
<td><a href="<?=base_url()?>user<?=$info['id']?>" target="_blank"><? if($info['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$info['photo_link']?>_101.jpg"><?else:?><img src="<?=base_url()?>content/img/no-foto-100.png"><?endif;?><br/><b><center><?=$info['name']?></center></b></a></td>
</tr>
</table>

</div>
<div align="center">
<input onclick="send();" class="btn" type="button" value="Send"/>
</div>
</div>
<div class="clearex"></div>
</div>
<br/><br/>
<!-- MY OPENED CHATS BLOCK START -->
<? if ($chat_me != false || $chat_my != false):?><hr/><div align="center"><b><?=$this->lang->line('chat_other_ch')?></b></div><?endif;?>
	<div align="center">
	<?if($chat_my != false):?>
	<table border="0" width="60%">
		<tr>
		<? foreach ($chat_my as $row): 
			$name = $this->mainModel->getUserProfile($row['user_2']);
		?>
			<td align="center" id="c_<?=$row['chat_name']?>"><img <?if($name['photo_link'] == ''):?>src="<?=base_url()?>content/img/no-foto-100.png"<?else:?>src="<?=base_url()?>profiles/photo/user_<?=$name['id']?>/<?=$name['photo_link']?>_101.jpg"<?endif;?>><br/><b><?=$name['name']?></b><br/><a href="<?=base_url()?>my/chat/dialog/<?=$row['chat_name']?>">open</a> / <a href="#." onClick="closeChat('<?=$row['chat_name']?>');">close</a></td>
		<? endforeach; ?>
		</tr>
	</table>
	<?endif;?>
	
	<?if($chat_me != false):?>
	<table border="0" width="60%">
		<tr>
		<? foreach ($chat_me as $row):
			$name = $this->mainModel->getUserProfile($row['user_1']);
		?>
			<td align="center" id="c_<?=$row['chat_name']?>"><img <?if($name['photo_link'] == ''):?>src="<?=base_url()?>content/img/no-foto-100.png"<?else:?>src="<?=base_url()?>profiles/photo/user_<?=$name['id']?>/<?=$name['photo_link']?>_101.jpg"<?endif;?>><br/><b><?=$name['name']?></b><br/><a href="<?=base_url()?>my/chat/dialog/<?=$row['chat_name']?>">open</a> / <a href="#." onClick="closeChat('<?=$row['chat_name']?>');">close</a></td>
		<? endforeach; ?>
		</tr>
	</table>
	<?endif;?>
</div>
<!-- MY OPENED CHATS BLOCK END -->
</div>
</div>
<div id="clear"></div>

<script type="text/javascript">
var isActive = true;
var isSound = true;

function onBlur() {
    isActive = false;
}
function onFocus() {
    isActive = true;
    document.title = "<?=$this->lang->line('chat_page_title')?> | <?=$this->engine['engine_title']?>";
}
if (/*@cc_on!@*/false) { // Internet Explorer
    document.onfocusin = onFocus;
    document.onfocusout = onBlur;
} else {
    window.onfocus = onFocus;
    window.onblur = onBlur;
}

// play sound if new message found

ion.sound({
    sounds: [
        {
            name: "chat_new_message",
            volume: 0.5
        },
    ],
    path: "/content/sound/",
    preload: true
});

// turn on/off sound on new message
function mute(type)
{
	if (type == 1)
	{
		isSound = false;
		$('#mute').html('<a href="#." onClick="mute(2);"><img src="<?=base_url()?>content/img/sound.png"><b>turn on sound</b></a>');
	}
	else if (type == 2)
	{
		isSound = true;
		$('#mute').html('<a href="#." onClick="mute(1);"><img src="<?=base_url()?>content/img/mute.png"><b>turn off sound</b></a>');
	}
}

var newMessages = setInterval(preload, 3000);

function preload()
{
	$.ajax({
		url: '<?=base_url()?>my/chat/ajax/preload_new/',
		type: 'POST',
		dataType: 'json',
		data: { name: '<?=$c_name?>' },
		success: function(obj) {
			if (obj.result == 'success') {
				$('#message_box').append(obj.html);
				if (obj.sound == '1' && isSound == true)
				{
					ion.sound.play("chat_new_message");
				}

				if (isActive == false && obj.sound == 1)
				{
					document.title = 'You have '+obj.count+' new messages';
				}
				_scrollBottom();
			}
		}
	});
}

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

function send()
{
	msg = $('#msg_content').val();

	if (msg == '')
	{
		alert('Type your message');
		return;
	}

	$.post('<?=base_url()?>my/chat/ajax/send/',{
		message: msg,
		name: '<?=$c_name?>'
		},
		function(data){	
			if( data.status == 'success' ){
				$('#msg_content').val('');
				$('#message_box').append(data.html);
				_scrollBottom();
			}
			else
			{
				alert('<?=$this->lang->line('chat_closed')?>');
				window.location.href='<?=base_url()?>my/chat/';
			}
		},
		'json');
}

function closeChat(chat_id)
{
	$.ajax({
		url: '<?=base_url()?>my/chat/ajax/close_chat',
		type: 'POST',
		dataType: 'json',
		data: { chat: chat_id },
		success: function(obj) {
			if (obj.result == 'success') {
				alert('<?=$this->lang->line('chat_close_ok')?>');
				$('#c_'+chat_id).html('');
			}
			else {
				alert(obj.message);
			}
		}
	});	
}

function insertSmile(id)
{
	value = $('#msg_content').val();
	$('#msg_content').val(value + ':'+id+':');
}

function _scrollBottom(){
	if( $('#message_box').length )
		$('#message_box').get(0).scrollTop = $('#message_box').get(0).scrollHeight;
}
$(function(){
	$('#message_box').load('<?=base_url()?>my/chat/ajax/load_messages/<?=$c_name?>');
	_scrollBottom();
});

</script>
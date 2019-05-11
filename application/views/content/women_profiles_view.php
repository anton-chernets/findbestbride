<!-- div content -->
<script type="text/javascript">
function addFavorite(id)
{
	$.ajax({
		url: '/user/ajax/favorite/',
		type: 'POST',
		dataType: 'json',
		data: { id: id },
		success: function(obj) {
			if (obj.result == 'success') {
				showNotification({ type: 'success', message: obj.message, autoClose: true, duration: '4' });
				$('#favor').remove();
			}
			else
				showNotification({ type: 'error', message: obj.message, autoClose: true, duration: '4' });
		}
	});	
}
</script>
   
<div id="maket-profiles">
    
     <div class="line">
	 <!--
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="290" height="8px">
        <span class="h2" style="float:left; "> <?=$this->lang->line('prof_text')?></span>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="290" height="8px">
     -->
	 </div>
      
 <div id="clear"></div>

 <div id="left_column">
 <? foreach ($list as $row): ?>
	<div id="gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>"> 
		<div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_240.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>

	<? if ($this->isAuth == true): ?>
		<div id="prams" onClick="document.location='<?=base_url()?>user<?=$row['id']?>'">
	<? else: ?>
		<div id="prams" class="open-modal">
	<? endif; ?>
			<div id="status-user">
			<? if(isOnlineUser($row['last_online']) == true):?>
			<img src="/content/img/status_on-icon.png" title="On-line">
			<?else:?>
			<img src="/content/img/status_off-icon.png" title="Off-line">
			<?endif;?>
			</div>
			
			<?php if($this->isAuth != false) { ?>
			<div id="favor"><a href="#." onClick="addFavorite('<?=$row['id']?>')">
				<img src="<?=base_url()?>content/img/add_favorites.png"></a>
			</div>
			<?php } ?>
			
			<div id="name-wp"><?=$row['name']?></div>
			<div id="age">age: <?=$row['age']?></div>
			
			<div class="serv-girls">
			<a <?if($this->isAuth == true):?>href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> title="Write new letter" class="let"></a> 
			<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/start/<?=$row['id']?>"<?endif;?> class="chat" title="Invite to chat" class="chat"></a>
			<a <?if($this->isAuth == true):?><? if (isOnlineUser($row['last_online']) == false):?>href="#" onClick="alert('You can invite only online users');"<? else: ?>href="/my/chat/start/<?=$row['id']?>/1"<? endif ?><?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> title="Invite to video chat" class="cam"></a>
			<!--<a <?if($this->isAuth == true):?>href="#"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> title="Invite to video chat with voice" class="vid"></a>-->
			</div>
		</div>
		</div>
	
 <? endforeach; ?>   
 <div id="clear"></div>
 </div>

<?=$links?>
<div style="margin:50px 0;"></div>
</div>

<!--end div content-->  

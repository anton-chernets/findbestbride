<!-- div content -->
   
<div id="maket">
    <!--
     <div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="400" height="8px">
        <span class="h2" style="float:left; "> <?=$this->lang->line('search_result')?></span>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="400" height="8px">
     </div>
    -->  
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
			
			<?php if(isOnlineUser($row['last_online']) == true){ ?>
			<img src="/content/img/status_on-icon.png">
			<?php } else { ?>
			<img src="/content/img/status_off-icon.png">
			<?php } ?>
			</div>
			
			<div id="favor"><a href="#." onClick="addFavorite('<?=$row['id']?>')">
				<img src="<?=base_url()?>content/img/add_favorites.png"></a>
			</div>
			<div id="name-wp"><?=$row['name']?></div>
			<div id="age">age: <?=$row['age']?></div>
			
			<div class="serv-girls">
			<a <?if($this->isAuth == true):?>href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup').fadeIn(300);"<?endif;?> title="Write new letter" class="let"></a> 
			<a <?if(isOnlineUser($row['last_online']) == false):?> 
				href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" 
			<?else:?>
				href="
					<?if($this->isAuth == true):?>
						<?=base_url()?>my/chat/start/<?=$row['id']?>
					<?else:?>
						#." onClick="javascript:$('#hide-layout, #popup').fadeIn(300);
					<?endif;?>"
			<?endif;?> 
				class="chat" title="Invite to chat" class="chat"></a>
			<a <?if($this->isAuth == true):?><? if (isOnlineUser($row['last_online']) == false):?>href="#" onClick="alert('You can invite only online users');"<? else: ?>href="/my/chat/start/<?=$row['id']?>/1"<? endif ?><?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> title="Invite to video chat" class="cam"></a>
			</div>
		</div>
	</div>
 <? endforeach; ?>   
<div id="clear"></div>
 </div>

</div>

   
<!--end div content--> 
<!-- div content -->
  <script type="text/javascript">
function addFavorite(id)
{
	$.ajax({
		url: '<?=base_url()?>user/ajax/favorite/',
		type: 'POST',
		dataType: 'json',
		data: { id: id },
		success: function(obj) {
			if (obj.result == 'success') {
				alert(obj.message);
				$('#favor').html('');
			}
			else {
				alert(obj.message);
			}
		}
	});	
}
</script>
   
<div id="maket-profiles">
    
     <!--<div class="line">
	 
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="390" height="8px">
        <span class="h2" style="float:left; "> Men profiles</span>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="390" height="8px">
       
	 </div>-->   
      
 <div id="clear"></div>  
   
 <div id="left_column">
 <? foreach ($list as $row): ?>
	<div id="gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>"> 
		<div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_240.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>  
		<div id="prams" onClick="document.location='<?=base_url()?>user<?=$row['id']?>'">
			<div id="status-user">
			<? if(isOnlineUser($row['last_online']) == true) { ?>
			<img src="/content/img/status_on-icon.png">
			<? } else { ?>
			<img src="/content/img/status_off-icon.png">
			<? } ?>
			</div>
			<!--<div id="favor"><a href="#." onClick="addFavorite('<?=$row['id']?>')">
				<img src="<?=base_url()?>content/img/add_favorites.png"></a>
			</div>-->
			<div id="name-wp"><?=$row['name']?></div>
			<div id="age">age: <?=$row['age']?></div>
			
			<div class="serv-girls">
			<a href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>" class="let" title="<?=$this->lang->line('mail_title')?>"></a>
			<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="/my/chat/start/<?=$row['id']?>"<?endif;?> class="chat" title="<?=$this->lang->line('chat_title')?>"></a>
			<a <?if($this->isAuth == true):?><? if (isOnlineUser($row['last_online']) == false):?>href="#" onClick="alert('You can invite only online users');"<? else: ?>href="/my/chat/start/<?=$row['id']?>/1"<? endif ?><?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> title="Invite to video chat" class="cam"></a>
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
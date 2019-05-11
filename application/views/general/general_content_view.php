<? if ($resInfo): ?>
<script type="text/javascript">                      
showNotification({
    type : "<?=$resInfo['type']?>",
    message: "<?=$resInfo['message']?>",
    autoClose: true,
    duration: "20"
});    
</script>
<? endif; 
   if ($resInfo && $resInfo['openForm'] == 'true'):
?>
<script type="text/javascript">
$(document).ready(function(){
$('#hide-layout, #popup-reg').fadeIn(300);
});
</script>
<? endif;
   if ($resInfo && $resInfo['openLoginForm'] == 'true'):
?>
<!--<script type="text/javascript">
$(document).ready(function(){
$('#hide-layout, #popup').fadeIn(300);
});
</script>-->
<? endif; ?>
 <!-- div content -->
<div  class="t-main">
	<div id="mes" class="cat-block">
		<div class="title">
		LETTERS
		</div>
		<p>
				</p>
	</div>
	<div id="l-chat" class="cat-block">
		<div class="title">
		LIVE CHAT
		</div>
		<p>
				</p>
	</div>
	<div id="v-chat" class="cat-block">
		<div class="title">
		VIDEO CHAT
		</div>
		<p>
		
		</p>
	</div>
	<div id="r-tours" class="cat-block">
		<div class="title">
		TOURS
		</div>
		<p>
	 		</p>
	</div>
<? if ($show != false): ?>    
      <div class="line">
     <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="428" height="8px">
        <span class="h2" style="float:left;">Women profiles</span>
    <img src="<?=base_url()?>content/img/line.png" style="float:left;margin-top:30px;" width="428" height="8px"></td>
      </div>
  <div id="clear"></div>    
      
<div id="left_column">
<? foreach ($one as $row): ?>
        <div id="gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>"> 
        <div id="name-wp"><a <? if($this->isAuth != false):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?> href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?>><?=$row['name']?></a></div>
         <div id="age"><?=$row['age']?></div>
             <div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>  
             <div id="prams">
             <? if($row['city'] != ''): $c = userCountry(); ?><p><?=sprintf($this->lang->line('prof_from'), $row['city'], $c[$row['country']])?></p><? endif; ?>
			<? if($row['eyes'] > 0 && $row['hair'] > 0): ?><p><?=sprintf($this->lang->line('prof_eyes_hair'), $this->assistant->userEyes($row['eyes']), $this->assistant->userHair($row['hair']));?></p><? endif; ?>
			<? if($row['age_from'] != '' && $row['age_to'] != ''):?><p><?=sprintf($this->lang->line('prof_age'), $row['age_from'], $row['age_to'])?></p><? else: ?><p><?=$this->lang->line('prof_not_age')?></p><? endif; ?>
			</div>
        
<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?endif;?> class="cam" title="<?=$this->lang->line('chat_title')?>" class="cam"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="let"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="vid"></a>
			        </div>
<? endforeach; ?>
</div>
 
<div id="right_column">
<? foreach ($three as $row): ?>
        <div id="gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>"> 
        <div id="name-wp"><a <? if($this->isAuth != false):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?> href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?>><?=$row['name']?></a></div>
         <div id="age"><?=$row['age']?></div>
             <div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>  
             <div id="prams">
             <? if($row['city'] != ''): $c = userCountry(); ?><p><?=sprintf($this->lang->line('prof_from'), $row['city'], $c[$row['country']])?></p><? endif; ?>
			<? if($row['eyes'] > 0 && $row['hair'] > 0): ?><p><?=sprintf($this->lang->line('prof_eyes_hair'), $this->assistant->userEyes($row['eyes']), $this->assistant->userHair($row['hair']));?></p><? endif; ?>
			<? if($row['age_from'] != '' && $row['age_to'] != ''):?><p><?=sprintf($this->lang->line('prof_age'), $row['age_from'], $row['age_to'])?></p><? else: ?><p><?=$this->lang->line('prof_not_age')?></p><? endif; ?>
			</div>
        
<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?endif;?> class="cam" title="<?=$this->lang->line('chat_title')?>" class="cam"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="let"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="vid"></a>
			        </div>
<? endforeach; ?>
</div>
   
<div id="main_column">
<? foreach ($two as $row): ?>
        <div id="gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>"> 
        <div id="name-wp"><a <? if($this->isAuth != false):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?> href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?>><?=$row['name']?></a></div>
         <div id="age"><?=$row['age']?></div>
             <div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>  
             <div id="prams">
             <? if($row['city'] != ''): $c = userCountry(); ?><p><?=sprintf($this->lang->line('prof_from'), $row['city'], $c[$row['country']])?></p><? endif; ?>
			<? if($row['eyes'] > 0 && $row['hair'] > 0): ?><p><?=sprintf($this->lang->line('prof_eyes_hair'), $this->assistant->userEyes($row['eyes']), $this->assistant->userHair($row['hair']));?></p><? endif; ?>
			<? if($row['age_from'] != '' && $row['age_to'] != ''):?><p><?=sprintf($this->lang->line('prof_age'), $row['age_from'], $row['age_to'])?></p><? else: ?><p><?=$this->lang->line('prof_not_age')?></p><? endif; ?>
			</div>
        
<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?endif;?> class="cam" title="<?=$this->lang->line('chat_title')?>" class="cam"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="let"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="vid"></a>
			        </div>
 <? endforeach; ?>
 </div>
 <? endif; ?>

<!-- div content -->
   
<div id="maket-account-045">
    
  <? if ($this->pModel->isNeedAttention($this->selfId) == true):?>
    <div class="pc"><div class="txt"><?=sprintf($this->lang->line('profile_main_need_com'), base_url() . 'my/edit/', base_url() . 'my/photo/')?></div> </div>    
  <? endif; ?>

   
 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="390" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('profile_favor_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="390" height="8px">
     </div> 
<? if ($list != false): 
?>

<?
	$count = 0;
	foreach ($list as $row):
	if ($count%3 == 0):
		echo '<div class="bottom-gal"><div id="clear"></div>';
	endif;
	$count++;
?>     
          
          <div class="botom-gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>">
          <div id="img2"><? if($row['photo_link'] == ''): ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? else: ?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? endif; ?></div>  
             <div id="b-prams">
             <div id="b-txt"><img src="<?=base_url()?>content/img/star.png"><a href="<?=base_url()?>user<?=$row['id']?>"><p><?=$row['name']?></p></a><br> <? if($row['age'] != ''): echo sprintf($this->lang->line('profile_prev_like_age'), $row['age']); endif;?></div>
             <div id="b-txt-chat"><img src="<?=base_url()?>content/img/bottom-chat.png"><a <?if(isOnlineUser($row['last_online']) == true):?>href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?else:?>href="#." onClick="alert('You can invite only online users');"<?endif;?>><p>Invite to chat</p></a></div>
             <div id="b-txt-let"><img src="<?=base_url()?>content/img/bottom-let.png"><a href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"><p>Write a letter</p></a></div>
             <div id="b-txt-let"><img src="<?=base_url()?>content/img/delete.png"><a href="<?=base_url()?>my/favorites/delete/<?=$row['id']?>"><p><?=$this->lang->line('profile_favor_delete')?></p></a></div>
             </div>
          </div>
 <? if ($count%3 == 0): echo '</div>'; endif;
 	
 	endforeach;
 	if ($count === $all && $all != 3 && $all != 6 && $all != 9 && $all != 12): echo '</div>'; endif;
 else: ?>
 <div class="bottom-gal">
    <div class="title"><p><?=$this->lang->line('profile_favor_empty')?></p></div>
 </div>
<? endif; ?>

<div id="clear"></div> 

</div>
 
   
<!--end div content-->  

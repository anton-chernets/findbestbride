<div id="maket">
	
     <div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="400" height="8px">
        <span class="h2" style="float:left; "> <?=$this->lang->line('search_result')?></span>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="400" height="8px">
     </div>
	
	<div id="clear"></div> 

<? foreach ($result as $row): ?>
			    <div id="gal-<? if(isOnlineUser($row['last_online']) == true):?>on<?else:?>of<?endif;?>">
        		
			<div>			
				<div id="name-wp">
				 <a <? if($this->isAuth == true): ?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?>><?=$row['name']?></a>
				</div>

				<div id="age">
				<?=$row['age']?></div>
			</div>
			<div class="clear"></div>

			<div id="img1">
								<? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?>
							</div>  

			<div id="prams">
				<? if($row['city'] != ''): $c = userCountry(); ?><p><?=sprintf($this->lang->line('prof_from'), $row['city'], $c[$row['country']])?></p><? endif; ?>
				<? if($row['eyes'] > 0 && $row['hair'] > 0): ?><p><?=sprintf($this->lang->line('prof_eyes_hair'), $this->assistant->userEyes($row['eyes']), $this->assistant->userHair($row['hair']));?></p><? endif; ?>
				<? if($row['age_from'] != '' && $row['age_to'] != ''):?><p><?=sprintf($this->lang->line('prof_age'), $row['age_from'], $row['age_to'])?></p><? else: ?><p><?=$this->lang->line('prof_not_age')?></p><? endif; ?>
			</div>
			<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?endif;?> class="cam" title="<?=$this->lang->line('chat_title')?>" class="cam"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="let"></a> <a <?if($this->isAuth == true):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?>href="#." onClick="javascript:$('#hide-layout, #popup-reg').fadeIn(300);"<?endif;?> class="vid"></a>
			
		</div>	
<? endforeach; ?>
	<div id="clear"></div>

	</div>

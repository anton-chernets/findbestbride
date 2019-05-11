<div id="maket-account-045">

<? if($this->userInfo['sex'] == 1):?>
<div align="center">
	<h3>
		<b><?=$this->lang->line('chat_women_on')?> (
		<a href="#." onClick="location.reload();"><?=$this->lang->line('chat_show_other')?></a>
		):</b>
	</h3>
</div>
<?else:?>
<div align="center">
	<h3><b>Men online (
		<a href="#." onClick="location.reload();"><?=$this->lang->line('chat_show_other')?></a>
		):</b>
	</h3>
</div>
<?endif;?>
<? if($this->userInfo['sex'] == 2):
	$list = $this->cModel->getLikeManProfiles();
	if ($list != false):
	$count = 0;
	$all = count($list);
	foreach ($list as $row):
	if ($count%3 == 0):
	echo '<div class="bottom-gal"><div id="clear"></div>';
	endif;
	$count++;
?>     
<div id="gal-on"> 
		<div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>  
		<div id="prams" onClick="document.location='<?=base_url()?>user<?=$row['id']?>'">
			<div id="name-wp"><a <? if($this->isAuth != false):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?> href="#." onClick="alert('<?=$this->lang->line('need_login')?>');"<?endif;?>><?=$row['name']?></a></div>
			<div id="age"><?=$row['age']?></div>
			<div id="favor"><a href="#." onClick="addFavorite('<?=$row['id']?>')">
				<img src="<?=base_url()?>content/img/add_favorites.png"></a>
			</div>			
			<div class="girls-info">
			</div>
			<div class="serv-girls">
			<a href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>" class="let" title="<?=$this->lang->line('mail_title')?>"></a>
			<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?endif;?> class="chat" title="<?=$this->lang->line('chat_title')?>"></a>
			<a href="<?=base_url()?>user<?=$row['id']?>" class="cam" title="View profile"></a>
			<a href="<?=base_url()?>user<?=$row['id']?>" class="vid" title="View profile"></a>
			</div>
		</div>
	 </div>
 <? if ($count%3 == 0): echo '</div>'; endif;
 	endforeach;
 	if ($count === $all && $all != 3 && $all != 6 && $all != 9 && $all != 12): echo '</div>'; endif;
?>
<? endif ?>
 <div id="clear"></div> 
 <? elseif ($this->userInfo['sex'] == 1):
	$list = $this->cModel->getLikeWomenProfiles();
	if ($list != false):
	$count = 0;
	$all = count($list);
	foreach ($list as $row):
	if ($count%3 == 0):
	echo '<div class="bottom-gal"><div id="clear"></div>';
	endif;
	$count++;
 ?>
<div id="gal-on"> 
		<div id="img1"><? if($row['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><? else: ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><? endif; ?></div>  
		<div id="prams" onClick="document.location='<?=base_url()?>user<?=$row['id']?>'">
			<div id="name-wp"><a <? if($this->isAuth != false):?>href="<?=base_url()?>user<?=$row['id']?>"<?else:?> href="#." onClick="alert('<?=$this->lang->line('need_login')?>');"<?endif;?>><?=$row['name']?></a></div>
			<div id="age"><?=$row['age']?></div>
			<div id="favor"><a href="#." onClick="addFavorite('<?=$row['id']?>')">
				<img src="<?=base_url()?>content/img/add_favorites.png"></a>
			</div>			
			<div class="girls-info">
			</div>
			<div class="serv-girls">
			<a href="<?=base_url()?>my/letters/write/new/<?=$row['id']?>" class="let" title="<?=$this->lang->line('mail_title')?>"></a>
			<a <? if (isOnlineUser($row['last_online']) == false):?> href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" <?else:?> href="<?=base_url()?>my/chat/invite/<?=$row['id']?>"<?endif;?> class="chat" title="<?=$this->lang->line('chat_title')?>"></a>
			<a href="<?=base_url()?>user<?=$row['id']?>" class="cam" title="View profile"></a>
			<a href="<?=base_url()?>user<?=$row['id']?>" class="vid" title="View profile"></a>
			</div>
		</div>
	 </div>
 <? if ($count%3 == 0): echo '</div>'; endif;
 	
 	endforeach;
 	if ($count === $all && $all != 3 && $all != 6 && $all != 9 && $all != 12): echo '</div>'; endif;
?>
<div id="clear"></div> 
<? endif; endif; ?>
 </div>


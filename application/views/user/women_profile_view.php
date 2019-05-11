<!-- div content -->
<script type="text/javascript">


function hide_show()
{
    var div=document.getElementById("div").style.display;
    var link=document.getElementById("link").innerHTML;
 
    
    if(div=="")div="none";
 
    if(div=="none")
    {
        div="block";
        link="<?=$this->lang->line('profile_prev_photo_hide')?>";
    }
    
    else
    {
        div="none";
        link="<?=$this->lang->line('profile_prev_view_photo')?>";
    }
    
    document.getElementById("div").style.display=div;
    document.getElementById("link").innerHTML=link;
}

function requestInfo(id)
{
	$.ajax({
		url: '<?=base_url()?>user/ajax/contact/',
		type: 'POST',
		dataType: 'json',
		data: { id: id },
		success: function(obj) {
			if (obj.result == 'success') {
				alert(obj.message);;
			}
			else {
				alert(obj.message);
			}
		}
	});
}

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
				$('#fav').html('');
			}
			else {
				alert(obj.message);
			}
		}
	});	
}

function romance_tour(id)
{
	$.ajax({
		url: '<?=base_url()?>user/ajax/rt/',
		type: 'POST',
		dataType: 'json',
		data: { id: id },
		success: function(obj) {
			if (obj.result == 'success') {
				alert(obj.message);
				$('#rt').html('');
			}
			else {
				alert(obj.message);
			}
		}
	});	
}
</script>
   
<div id="maket-account-045">
    
    
    <div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="340" height="8px">
        <div class="h2" style="float:left;" align="center"> <?=$info['name']?><?if ($info['age'] != ''): echo ', '.$info['age']; endif;?></div> <? if(isOnlineUser($info['last_online']) == false):?><div id="status-offline"><p>OFFLINE NOW</p></div><? else: ?><div id="status-online"><p>ONLINE NOW</p></div><?endif;?>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="340" height="8px">
     </div>
     
 <div id="left_column">
        <div id="block-foto"> 
       <? if($favorite == true): ?> <div id="fav"><img src="<?=base_url()?>content/img/star.png"><a href="#." onClick="addFavorite('<?=$info['id']?>')"><h4>Add to favorites</h4></a></div><? endif; ?>
        
           <div class="big-foto"><? if($info['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$info['photo_link']?>_342.jpg"><? else: ?><img width="342" height="500" src="<?=base_url()?>content/img/no-foto.png"><? endif; ?></div>
        
                <div class="profile-id"><?=sprintf($this->lang->line('profile_prev_userid'), $info['id'])?></div>                           
        
        <? if($photo != false): ?>
		  <div class="s-link"> <a onClick="hide_show();" id="link"><?=$this->lang->line('profile_prev_view_photo')?></a></div>

            <div id="div">
            <? foreach ($photo as $row): 
            	$server = ($row['photo_server'] == 1) ? base_url() : $this->mobSrc;
            ?>
            <div class="small-foto"><a href="<?=$server?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_name']?>_full.jpg"><img src="<?=$server?>profiles/photo/user_<?=$info['id']?>/<?=$row['photo_name']?>_105.jpg"></a></div>
       
             <? endforeach; ?>             </div>
         <? endif; ?>
        </div>
      
             
		<?if($rt != false && $info['is_agency'] != '0' && $this->user->isAgencyHaveRt($info['is_agency']) != false):?><a href="<?=base_url()?>tour/index/<?=$info['id']?>" class="but-heart" id="rt"><p><?=sprintf($this->lang->line('profile_prev_tour'), $info['name'])?></p></a><? endif; ?>
        <? if($req == true): ?>
		<a href="#." onClick="requestInfo('<?=$info['id']?>');" class="but-info">
		<p><?=$this->lang->line('user_contact_req')?></p></a>
	<? endif; ?>
      
 </div>
 
 <div id="content-prof">
	<? if ($this->isAuth != false && $this->userInfo['sex'] == 1): ?>
	<? if(isOnlineUser($info['last_online']) == true):?>
		<a href="<?=base_url()?>my/chat/start/<?=$info['id']?>" class="but-ichat">
	<? else:?>
		<a href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>');" class="but-ichat">
	<?endif;?>
		<p><?=$this->lang->line('user_invite_chat')?></p></a>
	<? endif; ?>
	<? if($this->isAuth != false && $this->userInfo['sex'] == 1): ?>
	<? if(isOnlineUser($info['last_online']) == true):?>
		<a href="<?=base_url()?>my/chat/start/<?=$info['id']?>/1" class="but-vchat">
	<?else:?>
		<a href="#." onClick="alert('<?=$this->lang->line('chat_user_offline')?>')" class="but-vchat">
	<?endif;?>
		<p>Invite to videochat</p></a>
	<?endif;?>
		<a href="<?=base_url()?>my/letters/write/new/<?=$info['id']?>" class="but-let">
		<p><?=$this->lang->line('user_write_letter')?></p></a>
	
	<? if($this->isAuth != false && $this->userInfo['sex'] == 1): ?>
		<a href="<?=base_url()?>gift/id/<?=$info['id']?>" class="but-gift">
		<p><?=$this->lang->line('user_send_gift')?></p></a>
	<? endif; ?>

 <div class="profile-data">
         <div class="col">
          <div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_country')?>:</span><span class="h-txt"> <? $c = userCountry(); echo $c[$this->userInfo['country']]?></span></div>
		 <div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_city')?>:</span><span class="h-txt"> <? echo ($info['city'] != '') ? $info['city'] : $this->lang->line('profile_prev_no_info');?></span></div>
		 <div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_marital')?>:</span><span class="h-txt"><?=$this->assistant->userMaritalStatus($info['marriage'])?></span></div>
		 <div class="row-even"><span class="h"><?=$this->lang->line('profile_edit_children')?>:</span><span class="h-txt"><?=$this->assistant->userChildren($info['children'])?></span></div>
		<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_height')?>:</span><span class="h-txt"><? echo ($info['height'] != '' && $info['height'] != '0') ? getUserHeight($info['height']) : $this->lang->line('profile_prev_no_info;');?></span></div>
		<div class="row-even"><span class="h"><?=$this->lang->line('profile_edit_weight')?>:</span><span class="h-txt"><? echo ($info['weight'] != '' && $info['weight'] != '0') ? getUserWeight($info['weight']) : $this->lang->line('profile_prev_no_info');?></span></div>
		<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_eyes')?>:</span><span class="h-txt"><?=$this->assistant->userEyes($info['eyes'])?></span></div>   
          </div>   
         
       <div class="col">            
        	<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_hair')?>:</span><span class="h-txt"><?=$this->assistant->userHair($info['hair'])?></span></div>
			<div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_occup')?>:</span><span class="h-txt"><? echo ($info['occupation'] != '') ? $info['occupation'] : $this->lang->line('profile_prev_no_info');?></span></div>
			<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_rel')?>:</span><span class="h-txt"><?=$this->assistant->userReligion($info['religion'])?></span></div>
			<div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_edu')?>:</span><span class="h-txt"><?=$this->assistant->userEdu($info['education'])?></span></div>
			<div class="row-odd"><span class="h"><?=$this->lang->line('profile_prev_smoke')?>:</span> <span class="h-txt"><?=$this->assistant->userSmokeDrink($info['smoke'])?></span></div>
			<div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_drink')?>:</span><span class="h-txt"><?=$this->assistant->userSmokeDrink($info['drink'])?></span></div>
			<div class="row-odd"><span class="h">English:</span><span class="h-txt"><?=$this->assistant->userEnglish($info['english'])?></span></div>
         </div>
 </div>
 
	<? if($info['hobbies'] != ''): ?>
    <div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_prev_hobby')?></div>
						<?=$info['hobbies']?>
     </div>
     <? endif; ?>
     <? if($info['age_from'] != '' && $info['age_to'] != ''): ?>
     <div class="profile-info">
				<div class="title"><?=$this->lang->line('profile_prev_age')?></div><?=sprintf($this->lang->line('profile_prev_age2'), $info['age_from'], $info['age_to'])?> 
      </div>
      <? endif; ?>
      <? if($info['aoa'] != ''): ?>
      <div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_edit_aoa')?></div>
						<?=$info['aoa']?>
		</div>
		<? endif; ?>
		<? if($info['about_me'] != ''): ?>
       <div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_prev_about_me')?></div>
						<?=$info['about_me']?>
		</div>
		<? endif; ?>
        <? if($info['about_partner'] != ''):?><div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_prev_about_part')?></div>
						<?=$info['about_partner']?><br />

		</div>
		<? endif; ?>
        <? if($video != false && $this->isAuth != false && $this->userInfo['sex'] == 1) { ?>
		<div class="profile-info">
			<div class="title"><?=$this->lang->line('profile_prev_video')?></div>
			<?php $i = 0; foreach ($video as $video) { $i++; ?>
				<div id="videoElement_<?=$i;?>">
			  		<video width="620" height="270" controls="true">
						<source src="<?=base_url()?>profiles/video/user_<?=$info['id']?>/<?=$video['video_name']?>" type="<?=$video['mime_type']?>">
					</video> 
				</div>
				<script>
					$('#videoElement_<?=$i;?>').block({ 
				        message: '<?=sprintf($this->lang->line('user_video_pay'), $info['id'], $i);?>', 
				        css: { border: '3px solid #a00', cursor: 'default' } 
				    }); 
				</script>
			<?php } ?>
		</div>
		<? } ?>                          
    


</div>      



 <div id="clear"></div>

<? if($this->userInfo['sex'] == 1 && $this->user->lastRegistered() != false): ?>

<div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="410" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('user_new_profiles')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="410" height="8px">
     </div>
  <?=$this->load->view('general/user_scroll_bottom')?>  
 <? endif; ?>
  <div id="clear"></div>   

<!--end div content-->  
<script type="text/javascript">
$(function() {
    $('#div a').lightBox({
        imageLoading: '<?=base_url()?>content/img/gallery/loading.gif',
        imageBtnClose: '<?=base_url()?>content/img/gallery/close.gif',
        imageBtnPrev: '<?=base_url()?>content/img/gallery/prev.gif',
        imageBtnNext: '<?=base_url()?>content/img/gallery/next.gif'

    });
});


function payVideo(id, video)
{
	$.ajax({
		url: '<?=base_url()?>user/ajax/video/',
		type: 'POST',
		dataType: 'json',
		data: { pay: '1', id: id },
		success: function(obj) {
			if (obj.result == 'success') {
				$('#videoElement_'+video).unblock();
			}
			else {
				alert(obj.message);
			}
		}
	});	
}


</script>
</div>
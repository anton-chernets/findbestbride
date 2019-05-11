<!-- div content -->

<? if ($resInfo): ?>
<script type="text/javascript">                      
showNotification({
    type : "<?=$resInfo['type']?>",
    message: "<?=$resInfo['message']?>",
    autoClose: true,
    duration: "4"
});    
</script>
<? endif; ?>

<script type="text/javascript">
	function submitForm()
	{
		image = $('#uploadImage').val();
		if (image == '')
		{
			alert('<?=$this->lang->line('profile_main_avatar_noimage')?>');
			return;
		}
		
		$('#avatarForm').submit();
	}

	function deletePhoto()
	{
		$('#deleteAvatar').submit();
	}
</script>
   
<div id="maket-account-045">

<? if($this->userInfo['photo_link'] != '' && $this->userInfo['is_agency'] == '0'): ?>
<form action="" method="post" id="deleteAvatar">
<input type="hidden" value="1" name="deleteMyAvatar" />
</form>
<? endif; ?>


  <? if ($this->pModel->isNeedAttention($this->selfId) == true):?>
    <div class="pc"><div class="txt"><?=sprintf($this->lang->line('profile_main_need_com'), base_url() . 'my/edit/', base_url() . 'my/photo/')?></div> </div>    
  <? endif; ?>
  
     <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="335" height="8px">
        <div class="h2" style="float:left;" align="center"> <?=sprintf($this->lang->line('profile_main_head_line'), $this->selfId)?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="335" height="8px">
     </div>
     
      <div class="welcome">
      <div class="name"><?=sprintf($this->lang->line('profile_main_hello'), $this->userInfo['name'])?> </div>
      <? if($this->userInfo['sex'] == 1):?><div class="crb"><?=$this->lang->line('profile_main_credit_bal')?>:<b> <?=$this->userInfo['credits']?></b></div><? endif; ?>
       </div>
      

<? if($this->userInfo['is_agency'] == 0):?>
<div id="block-ac-foto"> 
         <? if($this->userInfo['photo_link'] == ''): ?>  
         <form enctype="multipart/form-data" action="" method="POST" id="avatarForm">
         <input type="hidden" value="1" name="uploadMyAvatar" />
         <div id="no-foto"><center><input id="uploadImage" type="file" accept="image/*" name="userfile" style="margin-top: 160px" /> <a href="#" onClick="submitForm()" class="b-upload"></a></center></div>
         </form>
         <? else: ?> 
         <div class="img_profile_container" id="deleteHover"> 
           <img src="<?=base_url()?>profiles/photo/user_<?=$this->selfId?>/<?=$this->userInfo['photo_link']?>_220.jpg" />
        	<div class="img_description"><a href="#" onClick="deletePhoto()"><?=$this->lang->line('profile_main_avatar_delete')?></a></div></div>
         <? endif; ?>
         
         <? if($this->userInfo['sex'] == 1):?><center><a href="<?=base_url()?>my/profile/invite/" class="but-inv"><p>Invite your friend</p></a>  </center><?endif;?>
</div>
<? else: ?>
 <div id="block-ac-foto"> 
         <? if($this->userInfo['photo_link'] == ''): ?>  
         <div class="img_profile_container"> 
           <img src="<?=base_url()?>content/img/no-foto.png" />
        </div>
         <? else: ?> 
         <div class="img_profile_container"> 
           <img src="<?=base_url()?>profiles/photo/user_<?=$this->selfId?>/<?=$this->userInfo['photo_link']?>_220.jpg" />
        </div>
         <? endif; ?>
</div>
<? endif; ?>
<div id="content-account">

<div id="but-account"><a href="<?=base_url()?>my/profile/preview/" class="profile-cat-bg"><h3 class="prev-prof-icon"><?=$this->lang->line('profile_main_preview')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_preview_text')?></div>
</a></div>
<? if($this->userInfo['is_agency'] == 0): ?>
<div id="but-account"><a href="<?=base_url()?>my/edit/" class="profile-cat-bg"><h3 class="edit-prof-icon"><?=$this->lang->line('profile_main_edit')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_edit_text')?></div>
</a></div>
<? endif; ?>
<div id="but-account"><a href="<?=base_url()?>my/letters/" class="profile-cat-bg"><h3 class="letters-prof-icon"><?=$this->lang->line('profile_main_letters')?><?=$this->mainModel->newUserMessages($this->selfId)?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_letters_text')?></div>
</a></div>
<? if($this->userInfo['is_agency'] == 0):?>
<div id="but-account"><a href="<?=base_url()?>my/photo/" class="profile-cat-bg"><h3 class="photos-prof-icon"><?=$this->lang->line('profile_main_photos')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_photos_text')?></div>
</a></div>
<?endif;?>
<div id="but-account"><a href="<?=base_url()?>my/chat/" class="profile-cat-bg"><h3 class="chat-prof-icon"><?=$this->lang->line('profile_main_chat')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_chat_text')?></div>
</a></div>
<? if($this->userInfo['sex'] == 2 && $this->userInfo['is_agency'] == 0): ?>
<div id="but-account"><a href="<?=base_url()?>my/profile/video/" class="profile-cat-bg"><h3 class="video-pres-prof-icons"><?=$this->lang->line('profile_video')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_video_text')?></div>
</a></div>
<? endif; ?>
<? if($this->userInfo['sex'] == 1):?>
<div id="but-account"><a href="<?=base_url()?>my/favorites/" class="profile-cat-bg"><h3 class="favorites-prof-icon"><?=$this->lang->line('profile_main_favorites')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_favorites_text')?></div>
</a></div>


<div id="but-account"><a href="<?=base_url()?>my/credits/" class="b-credit"><h3 class="credit-prof-icon"><?=$this->lang->line('profile_main_credits')?></h3>
                             <div id="txt"><?=$this->lang->line('profile_main_credits_text')?></div>
</a></div>                                      
<? endif; ?>

</div>

<?=$this->load->view('general/user_scroll_bottom')?>

 <div id="clear"></div> 


</div>
 
   
<!--end div content-->  
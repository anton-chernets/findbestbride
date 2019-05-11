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
function deletePhoto(id)
{
	$('#setPhotoId').val(id);
	$('#deletePhoto').submit();
}

</script>
<div id="maket-account-045">

<form action="" method="post" id="deletePhoto">
<input type="hidden" value="" id="setPhotoId" name="deleteThisPhoto"/>
</form>

  <? if ($this->pModel->isNeedAttention($this->selfId) == true):?>
    <div class="pc"><div class="txt"><?=sprintf($this->lang->line('profile_main_need_com'), base_url() . 'my/edit/', base_url() . 'my/photo/')?></div> </div>    
  <? endif; ?> 
  
  
   
     <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="410" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('profile_photo_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="410" height="8px">
     </div>
     
     <div class="edit-link">
     
   <div class="el"> <a href="<?=base_url()?>my/edit/" class="prof-edit-icon" ><h3>Edit profile</h3></a></div>
    <div class="el">   <a href="<?=base_url()?>my/photo/" class="active-link prof-edit-photo-icon"><h3>My photos</h3></a>  </div>
       <div class="el"> <a href="<?=base_url()?>my/profile/preview/" class="prof-edit-prev-icon"><h3>Preview profile</h3> </a></div>
       </div>
       
       
 <div id="clear"></div>      
   
<div class="edit-content">
<?=$this->lang->line('profile_photo_text')?>
     <div class="new-foto">
<? if($pCount < 5): ?>
     
        <a href="#" class="input-foto" onClick="$('#showModalWindow').arcticmodal()"><div id="txt"><?=$this->lang->line('profile_photo_addnew')?></div></a>
       	<div style="visibility:hidden;">
       		<div class="box-modal" id="showModalWindow">
				<div class="box-modal_close arcticmodal-close"><?=$this->lang->line('profile_photo_close')?></div>
					<form action="" enctype="multipart/form-data" method="post" id="newPhoto">
					<input type="hidden" value="1" name="uploadPhoto"/>
						<div align="center"><input type="file" name="userfile" accept="image/*"/>
							<input type="submit" class="bt-save" value="Upload"/>
						</div>
					</form>
				</div>
		</div>
<? endif; ?>
 
<? foreach ($photos as $row): 
	$server = ($row['photo_server'] == 1) ? base_url() : $this->mobSrc;

	echo '<div class="col-foto"><div class="img_photos_container"><img width="170" src="'.$server.'profiles/photo/user_'.$this->selfId.'/'.$row['photo_name'].'_170.jpg">';
	
?>
<div class="photo_description"><a href="#" onClick="deletePhoto('<?=$row['photo_name']?>')"><?=$this->lang->line('profile_main_avatar_delete')?></a></div></div></div>

<?
	endforeach;
?> 
 
<?=getEmptyPhotos($pCount)?>

</div>


</div>     

<div id="clear"></div>

</div>
  <div id="clear"></div> 
   
<!--end div content-->  
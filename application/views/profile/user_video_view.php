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

	<script>
	$(document).ready(function() {
		$('video').mediaelementplayer({
			alwaysShowControls: false,
			videoVolume: 'horizontal',
			features: ['playpause','progress','volume','fullscreen']
		});
	});

	function deleteVideo(id)
	{
		$.ajax({
			url: '<?=base_url()?>my/profile/delete_video/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					alert(obj.message);
					$('#player').html('');
					$('#deletedPlayer').show();
				}
				else {
					alert(obj.message);
				}
			}
		});
	}	
	</script>

<div id="maket-account-045">
<? if ($this->pModel->isNeedAttention($this->selfId) == true):?>
    <div class="pc"><div class="txt"><?=sprintf($this->lang->line('profile_main_need_com'), base_url() . 'my/edit/', base_url() . 'my/photo/')?></div> </div>    
<? endif; ?>   
     <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="360" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('profile_video')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="360" height="8px">
     </div>

         
   
<div class="edit-content">
<?=$this->lang->line('profile_video_rules')?>


        <a href="#" class="input-video" onClick="$('#showModalWindow').arcticmodal()"><div id="txt"><?if($isExist == 0):?><?=$this->lang->line('profile_video_add')?><?else: echo $this->lang->line('profile_video_change'); endif;?></div></a>
       	<div style="visibility:hidden;">
       		<div class="box-modal" id="showModalWindow">
				<div class="box-modal_close arcticmodal-close"><?=$this->lang->line('profile_photo_close')?></div>
					<form action="" enctype="multipart/form-data" method="post" id="newVideo">
					<input type="hidden" value="1" name="uploadVideo"/>
						<div align="center"><input type="file" name="userfile" accept="video/*"/>
							<input type="submit" class="bt-save" value="Upload"/>
						</div>
					</form>
				</div>
		</div>


<div align="center" id="player"><? if($isExist == 0):?><a href="#" onClick="javascript:alert('<?=$this->lang->line('profile_video_alert')?>');"><img src="<?=base_url()?>content/img/no-video.jpg"></a><?else:?>
	<video width="640" height="267">
		<source src="<?=base_url()?>profiles/video/user_<?=$this->selfId?>/<?=$videoInfo['video_name']?>" type="<?=$videoInfo['mime_type']?>">
	</video>
	<br/><a href="#" onClick="deleteVideo('<?=$videoInfo['video_name']?>')">Delete video</a>
	<? endif; ?>
</div>

<div align="center" id="deletedPlayer" style="display: none;"><a href="#" onClick="javascript:alert('<?=$this->lang->line('profile_video_alert')?>');"><img src="<?=base_url()?>content/img/no-video.jpg"></a>
</div>

</div>  


<div id="clear"></div>

</div>
  <div id="clear"></div> 
   
<!--end div content-->  
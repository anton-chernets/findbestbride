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


<div id="maket-account-045">
    
     <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="440" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('letters_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="440" height="8px">
     </div>
     

<div id="letters-content"> 
 
<div id="menu-letter">
        <a href="<?=base_url()?>my/letters/" class="inbox"><p><?=$this->lang->line('letters_inbox')?></p></a>
        <a href="<?=base_url()?>my/letters/outbox/" class="outbox"><p><?=$this->lang->line('letters_outbox')?></p></a>
        <a href="<?=base_url()?>my/letters/admin_messages/" class="let-admin"><p><?=$this->lang->line('letters_admin')?></p></a>
        
</div>
 
<div id="clear"></div> 
<form action="" method="post" id="answerForm" enctype="multipart/form-data">
<input type="hidden" value="1" name="writeLetter" />
<input type="hidden" value="<?=$user['id']?>" name="to_user_id" />
<div class="letters-list-content">
   <div class="letters-sender">
    <div id="block-letters-foto"><? if($user['photo_link'] != ''): ?><img src="<?=base_url()?>profiles/photo/user_<?=$user['id']?>/<?=$user['photo_link']?>_101.jpg"><?else:?><img src="<?=base_url()?>content/img/no-foto-100.png"><?endif;?> </div>
   </div>
   
   <div class="letters-action"><div id="row"><b><?=$this->lang->line('letters_to')?>:</b> <a href="<?=base_url()?>user<?=$user['id']?>"><?=$user['name']?></a>, ID: <?=$user['id']?></div>
						<div id="row"><b><?=$this->lang->line('letters_from')?>:</b> <?=$this->userInfo['name']?></div>	
                        <div id="row"><b><?=$this->lang->line('letters_date')?>:</b> <?=date('d M Y H:i')?></div>
                       <div id="row"><b><?=$this->lang->line('letters_subj')?>:</b><br/><input type="text" id="inputtxt" name="subject" value="<?=$subj?>" /></div>	
    </div>
    
    <div id="clear"></div> 
    
    <div class="letters-txt">
		<textarea id="msg_content" name="new_msg"><?=$msg?></textarea>
		<br/><br/>
	<div class="send-btn">
		<input type="button" id="add_button" onClick="$('#showModalWindow').arcticmodal()" class="btn-add-image" value="<?=$this->lang->line('letters_img_add')?>" />
		<input type="button" onClick="javascript:checkForm();" class="btn-send-let" value="Send" />
	<!--  MODAL WINDOW -->
	 <div style="visibility:hidden;">
       	<div class="box-modal" id="showModalWindow">
			<div class="box-modal_close arcticmodal-close">close</div>
				<div align="center"><input id="image" type="file" name="userfile" accept="image/*"/>
					<input type="button" onClick="javascript:checkImage()" class="bt-save" value="<?=$this->lang->line('letters_img_add')?>"/>
				</div>
		</div>
	</div>
	<!--  END MODAL WINDOW -->
	</div>
	</div>
     </div>
</form>
  
</div>
  <div id="clear"></div> 
</div>
</div>
<script type="text/javascript">
function checkImage()
{
	image = $('#image').val();

	if (image == '')
	{
		alert('<?=$this->lang->line('letters_no_img')?>');
		return;
	}

	$.arcticmodal('close');
	$('#add_button').val('<?=$this->lang->line('letters_change_but')?>');
}

function checkForm()
{
	msg = $('#msg_content').val();
	subj = $('#inputtxt').val();

	if (msg == '')
	{
		alert ('<?=$this->lang->line('letters_no_msg')?>');
		return;
	}

	if (subj == '')
	{
		alert ('<?=$this->lang->line('letters_no_subj')?>');
		return;
	}

	$('#answerForm').submit();
}
</script>
<!--end div content-->  
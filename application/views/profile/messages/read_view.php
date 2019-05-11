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

<div class="letters-list-content">
   <div class="letters-sender">
    <div id="block-letters-foto"><? if($info['photo'] != '' && $info['from_user_id'] != '0'): ?><img src="<?=base_url()?>profiles/photo/user_<?=$info['from_user_id']?>/<?=$info['photo']?>_101.jpg"><? elseif($info['from_user_id'] == '0'):?><img src="<?=base_url()?>content/img/admin-photo.png"><?else:?><img src="<?=base_url()?>content/img/no-foto-100.png"><?endif;?> </div>
   </div>
   
   <div class="letters-action"><div id="row"><b><?=$this->lang->line('letters_from')?>:</b> <? if($info['from_user_id'] != '0'):?><a href="<?=base_url()?>user<?=$info['from_user_id']?>"><?=$info['name']?></a>, ID: <?=$info['from_user_id']?><? else:?>Administrator<? endif;?></div>
						<div id="row"><b><?=$this->lang->line('letters_to')?>:</b> <?=$this->userInfo['name']?></div>	
                        <div id="row"><b><?=$this->lang->line('letters_date')?>:</b> <?=date('d M Y H:i', $info['msg_date'])?></div>
                       <div id="row"><b><?=$this->lang->line('letters_subj')?>:</b> <?=$info['subject']?></div>	
    </div>
    
    <div id="clear"></div> 
    
    <div class="letters-txt">
		<?=$info['message']?>
		<? if($info['attachment'] != ''):
			// куда загружено прикрепление - на мобильную или основную версию
			$server = ($info['attach_server'] == 1) ? base_url() : $this->mobSrc;
		?>
		<br/><br/><br/>
		<div id="attach">
		<a href="<?=$server?>profiles/attachments/<?=$info['attachment']?>_orig.jpg"><img src="<?=$server?>profiles/attachments/<?=$info['attachment']?>_prev.jpg" /></a>
		</div>
		<? endif;?>
		<? if($info['from_user_id'] != '0'):?>
		<br/><br/>
		<div id="answer"><b><?=$this->lang->line('letters_y_answer')?>:</b></div>
		<div id="answer_form">
		<form action="" method="post" id="answerForm" enctype="multipart/form-data">
		<input type="hidden" name="reMessage" value="1" />
		<input type="hidden" name="msg_id" value="<?=$info['msg_id']?>" />
		<input type="hidden" name="subject" value="<?=$info['subject']?>" />
		<textarea id="msg_content" name="new_msg"></textarea>
		<br/>
			<div class="send-btn">
		<input type="button" id="add_button" onClick="$('#showModalWindow').arcticmodal()" class="btn-send-let" value="<?=$this->lang->line('letters_img_add')?>" />
		<input type="button" onClick="javascript:checkForm();" class="btn-send-let" value="Send" />
		</div>
		<!--  MODAL WINDOW -->
		 <div style="visibility:hidden;">
       		<div class="box-modal" id="showModalWindow">
				<div class="box-modal_close arcticmodal-close">close</div>
						<div align="center"><input id="image" type="file" name="userfile" accept="image/*"/>
							<input type="button" onClick="javascript:checkImage()" class="bt-save" value="<?=$this->lang->line('letters_img_add')?>"/>
						</div>
					</form>
				</div>
		<!--  END MODAL WINDOW -->
		</div>
		</form>
		</div>
		<? endif; ?>
	</div>
     </div>

  
</div>

  <div id="clear"></div> 
</div>
</div>
<!--end div content-->  
<script type="text/javascript">
$(function() {
    $('#attach a').lightBox({
        imageLoading: 'http://192.168.1.199/dating/content/img/gallery/loading.gif',
        imageBtnClose: 'http://192.168.1.199/dating/content/img/gallery/close.gif',
        imageBtnPrev: 'http://192.168.1.199/dating/content/img/gallery/prev.gif',
        imageBtnNext: 'http://192.168.1.199/dating/content/img/gallery/next.gif'

    });
});

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

	if (msg == '')
	{
		alert ('<?=$this->lang->line('letters_no_msg')?>');
		return;
	}

	$('#answerForm').submit();
}
</script>
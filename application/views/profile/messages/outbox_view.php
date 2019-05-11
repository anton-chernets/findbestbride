<!-- div content -->

<script type="text/javascript">

function deleteMessage(msg_id)
{
	$.ajax({
		url: '<?=base_url()?>my/letters/ajax/my_delete/',
		type: 'POST',
		dataType: 'json',
		data: { id: msg_id },
		success: function(obj) {
			if (obj.result == 'success') {
				$('#msg_'+msg_id).html('');
			}
			else
			{
				alert(obj.message);
			}
		}	
	});
}
</script>

<div id="maket-account-045">
    
     <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="440" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('letters_title')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="440" height="8px">
     </div>
     

<div id="letters-content"> 
 
<div id="menu-letter">
        <a href="<?=base_url()?>my/letters/" class="inbox"><p><?=$this->lang->line('letters_inbox')?></p></a>
        <a href="#" class="outbox"><p><?=$this->lang->line('letters_outbox')?></p></a>
        <a href="<?=base_url()?>my/letters/admin_messages/" class="let-admin"><p><?=$this->lang->line('letters_admin')?></p></a>
        
</div>
 
 
<div class="letters-head">
    <div class="letters-head-sender"><p><?=$this->lang->line('letters_sender')?></p></div>
    <div class="letters-head-action"><p><?=$this->lang->line('letters_action')?></p></div>
    <div class="letters-head-att"><p><?=$this->lang->line('letters_attach')?></p></div>
    <div class="letters-head-date"><p><?=$this->lang->line('letters_date')?></p></div>
</div>

<? foreach ($result as $row): ?>
<div class="letters-list<?if($row['is_read'] == 0):?>-unread<?endif;?>" id="msg_<?=$row['msg_id']?>">
   <div class="letters-sender">
    <div id="block-letters-foto"><? if($row['photo'] != ''): ?><img src="<?=base_url()?>profiles/photo/user_<?=$row['to_user_id']?>/<?=$row['photo']?>_101.jpg"><?else:?><img src="<?=base_url()?>content/img/no-foto-100.png"><?endif;?> </div>
   </div>
   
    <div class="letters-action"><div id="row"><b><?=$this->lang->line('letters_to')?>:</b> <? if($row['to_user_id'] != '0'):?><a href="<?=base_url()?>user<?=$row['to_user_id']?>"><?=$row['name']?></a>, ID: <?=$row['to_user_id']?><? else: ?>Adminitrator<?endif;?></div>
						<div id="row"><b><?=$this->lang->line('letters_subj')?>:</b> <?=$row['subject']?></div>	
                        <a href="<?=base_url()?>my/letters/outbox/read/<?=$row['msg_id']?>" class="letters-button"><p><?=$this->lang->line('letters_read')?></p></a>
                        <a href="#." onClick="deleteMessage('<?=$row['msg_id']?>')" class="letters-button"><p><?=$this->lang->line('letters_delete')?></p></a>
                      
                        
                        </div>
    <? if($row['attachment'] != ''): ?><div class="letters-att"><img src="<?=base_url()?>content/img/image.png"></div><? endif; ?>
    <div class="letters-date"><p><?=date('d M Y', $row['msg_date'])?><br/><?=date('H:i', $row['msg_date'])?></p></div>
</div>

<? endforeach; ?>


<?=$links?>

  <div id="clear"></div> 

</div>
</div>
  <div id="clear"></div> 
   
<!--end div content-->  
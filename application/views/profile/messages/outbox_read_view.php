<!-- div content -->

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
    <div id="block-letters-foto"><? if($info['photo'] != ''): ?><img src="<?=base_url()?>profiles/photo/user_<?=$info['to_user_id']?>/<?=$info['photo']?>_101.jpg"><?else:?><img src="<?=base_url()?>content/img/no-foto-100.png"><?endif;?> </div>
   </div>
   
   <div class="letters-action"><div id="row"><b><?=$this->lang->line('letters_to')?>:</b> <a href="<?=base_url()?>user<?=$info['to_user_id']?>"><?=$info['name']?></a>, ID: <?=$info['to_user_id']?></div>
						<div id="row"><b><?=$this->lang->line('letters_from')?>:</b> <?=$this->userInfo['name']?></div>	
                        <div id="row"><b><?=$this->lang->line('letters_date')?>:</b> <?=date('d M Y H:i', $info['msg_date'])?></div>
                       <div id="row"><b><?=$this->lang->line('letters_subj')?>:</b> <?=$info['subject']?></div>	
    </div>
    
    <div id="clear"></div> 
    
    <div class="letters-txt">
		<?=$info['message']?>
		<? if($info['attachment'] != ''):
			$server = ($info['attach_server'] == 1) ? base_url() : $this->mobSrc;
		?>
		<br/><br/><br/>
		<div id="attach">
		<a href="<?=$server?>profiles/attachments/<?=$info['attachment']?>_orig.jpg"><img src="<?=$server?>profiles/attachments/<?=$info['attachment']?>_prev.jpg" /></a>
		</div>
		<? endif;?>
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
</script>
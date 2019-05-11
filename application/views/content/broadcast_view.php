<form action="<?=base_url()?>search/broadcast/" method="POST" id="broadcast_yourself" enctype="multipart/form-data">

<div id="maket-052">
	
	<div class="line">
		<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="365" height="8px">
		<span class="h2" style="float:left; ">Broadcast yourself</span>
		<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="355" height="8px">
	</div>

	<div class="clear"></div>  
	
	<div id="main-content">
		<div class="text">
			<strong><?=sprintf($this->lang->line('broadcast_result'), $count); ?></strong>
			<br>
			<?=$this->lang->line('broadcast_text'); ?>
			<br><br><br>
		
			<label for="msg_account">Your message:</label><br>
			<textarea id="msg_account" name="msg"></textarea>
			
			<p><input type="button" id="add_button" onClick="$('#showModalWindow').arcticmodal()" class="btn" value="Add image" /><button type="button" onClick="send();" class="btn">Send</button></p>
		
	</div>
	</div>
</div>

<!--  MODAL WINDOW -->
		 <div style="visibility:hidden;">
       		<div class="box-modal" id="showModalWindow">
				<div class="box-modal_close arcticmodal-close">close</div>
						<div align="center"><input id="image" type="file" name="userfile" accept="image/*"/>
							<input type="button" onClick="javascript:checkImage()" class="bt-save" value="Add image"/>
						</div>
				</div>
		</div>
		<!--  END MODAL WINDOW -->
</form>
<script>
	function send()
	{
		if ($('#msg_account').val() != '')
		{
			$('#broadcast_yourself').submit();
		}
		else
		{
			alert('<?=$this->lang->line('broadcast_error');?>');
		}
	}

	function checkImage()
	{
		image = $('#image').val();

		if (image == '')
		{
			alert('You must select image if you want upload them');
			return;
		}

		$.arcticmodal('close');
		$('#add_button').val('Change img');
	}
</script>
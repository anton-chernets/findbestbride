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

	function checkSupportForm()
	{
		name = $('#msg_name').val();
		email = $('#msg_email').val();
		subj = $('#msg_subject').val();
		text = $('#msg_content').val();

		if (name == '' || email == '' || subj == '0' || text == '')
		{
			alert('Feel all fields!');
			return;
		}
		else
		{
			$('#supportForm').submit();
		}
	}
</script>
<div id="maket" class="support-bg">
     <div class="line">
    <!--   
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="430" height="8px">  
        <span class="h2" style="float:left; "><?=$this->lang->line('support')?></span>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="430" height="8px">    
     -->
	 </div>
      
 <div id="clear"></div>  
   
<div id="main-content">
  
  
   <form action="" id="supportForm" method="post" class="form-support" >
   <input type="hidden" value="1" name="submitSupportForm" />
		<div id="ms-name">
           <div style="float: left;"><label class="mc-lable"><?=$this->lang->line('your_name')?>:</label></div>
           
         <input type="text" id="msg_name" name="msg_name" value="" length="20" />
                          
		</div>
        <div id="ms-email">
         <div style="float: left;"><label class="mc-lable"><?=$this->lang->line('your_mail')?>:</label></div>
         <input type="text" id="msg_email" name="msg_email" value="" length="30" />
        </div>

    
    
    <div style="clear:both;"></div>

			
   <label class="mc-lable"><?=$this->lang->line('subject')?>:</label>        
        
	<div><select name="msg_subject" id="msg_subject" class="select1">
          
            <option value="0"> </option>
<option value="1"><?=$this->lang->line('subj1')?></option>
<option value="2"><?=$this->lang->line('subj2')?></option>
<option value="3"><?=$this->lang->line('subj3')?></option>
<option value="4"><?=$this->lang->line('subj4')?></option>
<option value="5"><?=$this->lang->line('subj5')?></option>
<option value="6"><?=$this->lang->line('subj6')?></option>
<option value="7"><?=$this->lang->line('subj7')?></option>
<option value="8"><?=$this->lang->line('subj8')?></option>
<option value="9"><?=$this->lang->line('subj9')?></option>
<option value="10"><?=$this->lang->line('subj10')?></option>
<option value="11"><?=$this->lang->line('subj11')?></option>
<option value="12"><?=$this->lang->line('subj12')?></option>
</select>
</div>
		

		<label class="mc-lable"><?=$this->lang->line('message')?>:</label>
		<div>
       <textarea id="msg_content" name="msg_content"></textarea>
        </div>

	<div class="send-btn">
		
		<input type="button" onClick="javascript:checkSupportForm();" class="btn-support" value="<?=$this->lang->line('ok_button')?>" />
	</div>
</form>
</div>

</div>
<!--end div content-->  
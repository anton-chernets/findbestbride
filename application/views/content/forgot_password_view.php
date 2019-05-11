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
		email = $('#msg_email').val();

		if (email == '')
		{
			alert('Feel all fields!');
			return;
		}
		else
		{
			$('#pwdForm').submit();
		}
	}
</script>
<div id="maket">
     <div class="line">
       
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="370" height="8px">  
        <span class="h2" style="float:left; "><?=$this->lang->line('pwd_title')?></span>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="370" height="8px">    
     </div>
      
 <div id="clear"></div>  
   
<div id="main-content">
  
  
   <form action="" id="pwdForm" method="post" class="form forgot-pass" >
   <input type="hidden" value="1" name="sendPassword" />


			
   <label class="mc-lable"><?=$this->lang->line('pwd_email')?>:</label>        
        
	<div> <input type="text" id="msg_email" name="msg_email" value="" length="30" />
</div>
		<div id="clear"></div>
	<div class="send-btn">
		
		<input type="button" onClick="javascript:checkSupportForm();" class="btn-send-forgot" value="<?=$this->lang->line('pwd_button')?>" />
	</div>
</form>


   
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; " width="1000" height="8px"> 

</div>
</div>
<!--end div content-->  

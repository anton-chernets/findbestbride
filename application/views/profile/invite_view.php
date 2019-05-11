<? if ($resInfo): ?>
<script type="text/javascript">                      
showNotification({
    type : "<?=$resInfo['type']?>",
    message: "<?=$resInfo['message']?>",
    autoClose: true,
    duration: "6"
});    
</script>
<? endif; ?>

<div id="maket-account-045">

 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="360" height="8px">
        <div class="h2" style="float:left;" align="center">Invite your friend</div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="390" height="8px">
     </div> 

<div class="edit-content">

<div align="center">
<form action="" method="post" id="inviteForm">
<input type="hidden" value="1" name="sent" />
<br/><br/><br/>
Your friend name:<br/>
<input type="text" id="input260" style="margin-left: 375px;" name="name" />
<br/><br/><br/>
Your friend e-mail:<br/>
<input type="text" id="input260" style="margin-left:375px;" name="email"/><br/><br/><br/>
<button type="button" onClick="checkInvitedUser()" class="bt-save">Send invite</button>
</form>
</div>


</div>

 </div>
<div id="clear"></div>

<script>
	function checkInvitedUser()
	{
		name = $('input[name="name"]').val();
		email = $('input[name="email"]').val();

		if (name == '' || email == '')
		{
			alert('Please, provide the name and e-mail');
			return;
		}

		$('#inviteForm').submit();
	}
</script>
<div id="popup-container">
	<div class="GPFN54SCMW" id="invites_container">


	</div>
</div>

	<div class="txt">
	<p></p>
     	</div>
<?=$this->load->view('general/user_scroll_bottom')?>
</div>
<div id="clear"></div>
<div id="footer">
	<?=$this->load->view('general/bottom_menu_view')?>
    &copy; findbestbride.com
</div>
</div>

<!--the end-->
<?php if (!$this->isAuth) { ?>
<div class="modal-register-overlay">
	<div class="modal-register">
		<div id="close-modal">x</div>
			<?php $p = $this->mainModel->oneProfile(); ?>
			<div class="modal-photo">
				<img src="<?php echo base_url(); ?>profiles/photo/user_<?=$p['id'];?>/<?=$p['photo_link']?>_342.jpg" style="height:383px;">
				<?php echo $p['name']; ?> ID: <?php echo $p['id']; ?>
			</div>
		<div class="modal-form">
			<p>
				Fill in registration form, if you do not<br>
				have personal ID, and get<br>
				free membership on findbestbride.com, or login
			</p>
			<form action="/main" method="POST">
					<input value="1" name="registerMe" type="hidden">
					<input type="hidden" name="user_sex" value="1">
					Your e-mail &nbsp; <input type="email" name="user_email" value="" required><br>
					Your password &nbsp; <input type="password" name="user_password" value="" required><br>
					Your name &nbsp; <input type="text" name="user_real_name" maxlength="12" value="" required><br>
					Your lastname &nbsp; <input type="text" name="user_lastname" value="" required><br>
					Country &nbsp;&nbsp; <select name="user_country"><?php foreach(userCountry() as $c => $v) {
							if ($c == '') $v = 'Country';
						?>
						<option value="<?php echo $c; ?>"><?php echo $v; ?></option>
						<?php } ?></select>
			<p class="t-center">
				By submitting this form I agree to the terms<br>
				of use and certify that I am at least<br>
				18 years of age
			</p>
			<input type="submit" name="m-register" value="Join now" class="modal-submit">
			</form>
		</div>
		<div id="return-info"></div>
	</div>
</div>

<script type="text/javascript">
	var openModalBlock = '.open-modal';

	$(openModalBlock).click(function(){
		$('.modal-register-overlay').show();
		$('.modal-register').show();
	})

	$('#close-modal').click(function(){
		$('.modal-register-overlay').fadeOut();
		$('.modal-register').fadeOut();
	})

	$('.modal-register-overlay').click( function(event){
		if($(event.target).closest('.modal-register').length)
		return;
		$('.modal-register-overlay').fadeOut();
		$('.modal-register').fadeOut();
		event.stopPropagation();
	});
</script>
<?php } ?>
</body>
</html>

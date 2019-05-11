<? if($this->isAuth != false): ?>
<div id="header-top">
    <div id="logo2"><a href="<?=base_url()?>"><img src="<?=base_url()?>content/img/testc4l_logo.png"></a></div>
		<?//=$this->load->view('general/user_scroll_top')?>
		<!-- <div  style="width:41.9%; float:left; margin-top:5px"></div> -->
		<div class="p-info" style="width:50%; float:right;">
   <?if ($this->userInfo['sex'] == '1'):?> <div class="cr"><b>credits:</b> <?=$this->userInfo['credits']?></div>
   <? else: ?>
   <div class="cr"></div>
   <? endif; ?>
<div id="m-account2">
 <ul id="menu-up">
<li><img src="<?=base_url()?>content/img/ac.png"><a href="<?=base_url()?>my/profile/">account</a> <span>|</span></li>
<li><img src="<?=base_url()?>content/img/hlet.png"><a href="<?=base_url()?>my/letters/">letters<?=$this->mainModel->newUserMessages($this->selfId)?></a><div style="float: left;"> </div>  <span>|</span></li>
<li><img src="<?=base_url()?>content/img/chat.png"><a href="<?=base_url()?>my/chat/">chat</a> <span>|</span></li>
<li><a href="<?=base_url()?>main/logout/">logout</a></li>
</ul>
</div>
</div>
</div>
<? else: ?>
<div id="header-top">
    <div id="logo2"><a href="<?=base_url()?>"><img src="<?=base_url()?>content/img/testc4l_logo.png"></a></div>
   <!--<a href="#" target="_blank"><img src="<?=base_url()?>content/img/but1.png" class="btn1"></a>-->
    <!--<a href="#" ><img src="<?=base_url()?>content/img/but2.png" class="btn2"></a>-->
	<div class="block-login">
	<!--<div id="click-me-reg" class="open-popup-reg">
			<img src="<?=base_url()?>content/img/but1.png" >
		</div>
		<div id="click-me" class="open-popup">
			<img src="<?=base_url()?>content/img/but2.png" >
		</div> -->

<form action="<?=base_url()?>login/" method="post" class="login-form-top">
<input type="hidden" value="1" name="loginMe" />
<p style="display:none"><?=$this->lang->line('l_text')?></p>
<p></p>
<p></p>
	<div class="row2">
		<input type="text" id="inputt-top" name="u_email" placeholder="<?=$this->lang->line('l_email')?>" value="" />
	</div>
	<div class="row2">
		<input type="password" id="inputt-top" name="u_password" placeholder="<?=$this->lang->line('l_pwd')?>" value="" />
	</div>
	<button type="submit" name="submit" class="btn-enter"><?=$this->lang->line('l_button')?></button>
	<div style="">
		<div class="row-checkbox">
			<input type="checkbox" id="rem" name="rem" />
			<label class="checkbox"><?=$this->lang->line('l_remember')?></label>
		</div>
		<div class="forgot-block">
			<a href="<?=base_url()?>password/" id="link"><?=$this->lang->line('l_password')?></a>
		</div>
	</div>


</form>

	</div>
</div>
<? endif; ?>

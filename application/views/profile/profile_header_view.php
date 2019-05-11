<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/plain; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<link href="/content/img/favicon.png" rel="shortcut icon">
<title><?=$title?></title>
<link href="<?=base_url()?>content/css/style-account.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>content/css/effects.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>content/css/jquery.arcticmodal.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>content/css/media.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>content/css/jquery.lightbox.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>content/css/css-chat.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>content/css/dialog.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>content/css/jquery_notification.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/notifications.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/jquery.arcticmodal-0.3.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/select.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/menu.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/modal.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/jquery.blockui.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/jquery.lightbox.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/ion.sound.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>content/js/jquery.scrollbox.js"></script>
<script type="text/javascript" src="<?=base_url()?>content/js/chat.js"></script>


<? if($this->isAuth != false): ?>
<script type="text/javascript">
	<? if ($this->userInfo['sex'] == 2) { ?>
	ion.sound({
	    sounds: [
	        {
	            name: "call",
	            volume: 0.9
	        },
	    ],
	    path: "/content/sound/",
	    preload: true
	});
	<? } ?>


	var timeid = setInterval(checkChat, 15000);

	function checkChat()
	{
		$.ajax({
			url: '<?=base_url()?>my/chat/ajax/check_chat',
			type: 'post',
			dataType: 'json',
			data: { id: <?=$this->selfId; ?> },
			success: function(e) {
				if (e.count > 0) {
					$('#invites_container').append(e.text);

					<?php if ($this->userInfo['sex'] == 2) { ?>
					ion.sound.play('call');
					<?php } ?>
				}
			}
		})
	}

	function declineInvite(room) {
		$.post('<?=base_url()?>my/chat/ajax/decline', { room: room });
		$('#invite_' + room).fadeOut(500);
	}

	function acceptInvite(room) {
		$.ajax({
			url: '<?=base_url()?>my/chat/ajax/accept',
			type: 'post',
			dataType: 'json',
			data: { chat: room },
			success: function(e) {
				if (e.result == 'success') {
					$('#invite_' + room).fadeOut(500);
					window.location.href = '<?=base_url()?>my/chat/index/' + room;
				}
			}
		});
	}
</script>
	<? endif; ?>
</head>

<body >
<!--glavnui div-->
<div id="container">

<!--- header--->
<div id="header-top">
<div id="logo2"><a href="<?=base_url()?>"><img src="<?=base_url()?>content/img/testc4l_logo.png"></a></div>
    <a href="<?=base_url()?>"><div id="m-logo"></div></a>
	<?//=$this->load->view('general/user_scroll_top')?>

	<div class="p-info" style="width:31%; float:right;">
     <? if($this->userInfo['sex'] == 1): ?><div class="cr"><b>credits:</b> <?=$this->userInfo['credits']?></div>
	 <? else: ?>
   <div class="cr"></div>
   <? endif; ?>
<div id="m-account">
 <ul id="menu-up">
<li><img src="<?=base_url()?>content/img/ac.png"><a href="<?=base_url()?>my/profile/">account</a> <span>|</span></li>
<li><img src="<?=base_url()?>content/img/hlet.png"><a href="<?=base_url()?>my/letters/">letters<?=$this->mainModel->newUserMessages($this->selfId)?></a><div style="float: left;"> </div>  <span>|</span></li>
<li><img src="<?=base_url()?>content/img/chat.png"><a href="<?=base_url()?>my/chat/">chat</a> <span>|</span></li>
<li><a href="<?=base_url()?>main/logout/">logout</a></li>
</ul>


</div>
</div>

    </div>

</div>
<!--div top menu -->
<?=$this->load->view('general/head_profile_menu_view')?>
 <div id="container">

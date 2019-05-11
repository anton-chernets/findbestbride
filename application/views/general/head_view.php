<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="telderi" content="23fcd9c2b9d3db8d47674e43f568386a" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">

<meta name="keywords" content="<?=$keywords?>">
<meta name="description" content="<?=$description?>">

<meta name="Robots" http-equiv="robots" content="index, all, follow">
<link href="/content/img/favicon.png" rel="shortcut icon">
<title><?=$title?></title>

<link href="<?= base_url(); ?>content/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>content/css/flickerplate.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>content/css/jquery_notification.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>content/css/jquery.arcticmodal.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>content/css/css-chat.css" rel="stylesheet" type="text/css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/jquery.arcticmodal-0.3.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/notifications.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/menu.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/select.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/modal.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/ion.sound.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/flickerplate.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/modernizr-custom-v2.7.1.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/jquery-finger-v0.1.0.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>content/js/jquery.scrollbox.js"></script>

<script>
	var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>


<script type="text/javascript">
//$(document).ready(function(){
//	$('.select4').ageStyle1();
//	$('.select3').countryStyle1();
//	$('.select5').countryStyle1();

//	});

	$(function() {
		$('#popup').hide();
		$('#hide-layout').css({opacity: .5});
		alignCenter($('#popup'));

		$('#popup-reg').hide();
		$('#hide-layout').css({opacity: .5});
		alignCenter($('#popup-reg'));

		$(window).resize(function() {
			alignCenter($('#popup'));
		});

		$(window).resize(function() {
			alignCenter($('#popup-reg'));
		});

		$('#click-me').click(function() {
			$('#hide-layout, #popup').fadeIn(300);
		});

		$('#click-me-reg').click(function() {
			$('#hide-layout, #popup-reg').fadeIn(300);
		});

		$('#needToLogin').click(function() {
			$('#hide-layout, #popup').fadeIn(300);
		});

		$('.btn-close, #hide-layout').click(function() {
			$('#hide-layout, #popup').fadeOut(300);

		});

		$('.btn-close, #hide-layout').click(function() {
			$('#hide-layout, #popup-reg').fadeOut(300);

		});

		function alignCenter(elem) {
			elem.css({
				left: ($(window).width() - elem.width()) / 2 + 'px',
				top: ($(window).height() - elem.height()) / 2 + 'px'
			});
		}
	});


	<? if($this->isAuth != false): ?>

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
	<? endif; ?>
</script>
<script type="text/javascript">
function hide_show()
{
    var div=document.getElementById("div").style.display;
    var link=document.getElementById("link").innerHTML;


    if(div=="")div="none";

    if(div=="none")
    {
        div="block";
        link="Forgot password?";
    }

    else
    {
        div="none";
        link="Forgot password?";
    }

    document.getElementById("div").style.display=div;
    document.getElementById("link").innerHTML=link;
}
</script>
</head>

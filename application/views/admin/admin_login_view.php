<!DOCTYPE html>
<html>
  <head>
    <title>Admin Login</title>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <link href="<?=base_url()?>content/boot/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?=base_url()?>content/boot/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<?=base_url()?>content/boot/assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?=base_url()?>content/boot/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
		<div id="panel-error" class="alert alert-error alert-block" style="display:none;">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<h4 class="alert-heading">Ошибка</h4>
			<span id="error"></span>
		</div>
      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input id="admin_login" type="text" class="input-block-level" placeholder="Логин">
        <input id="admin_pwd" type="password" class="input-block-level" placeholder="Пароль">
        <button class="btn btn-large btn-primary" type="button" onClick="checkForm();">Войти</button>
      </form>

    </div> <!-- /container -->
    <script src="<?=base_url()?>content/boot/vendors/jquery-1.9.1.min.js"></script>
    <script src="<?=base_url()?>content/js/jquery.blockui.js"></script>
    <script src="<?=base_url()?>content/boot/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
		
		function checkForm()
		{
			login = $('#admin_login').val();
			pwd = $('#admin_pwd').val();

			if (login == '' || pwd == '')
			{
				return;
			}

			$.ajax({
				url: '<?=base_url()?>login/ad/',
				type: 'POST',
				dataType: 'json',
				data: { login: login, password: pwd },
				success: function(obj) {
					if (obj.result == 'success') {
						window.location.href = '<?=base_url()?>admin/first/';
					}
					else {
						$('#error').html(obj.message);
						$('#panel-error').show();
					}
				}
			});
		}	
    </script>
  </body>
</html>
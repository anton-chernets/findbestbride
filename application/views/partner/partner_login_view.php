<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$this->lang->line('partner_login_title')?></title>

    <!-- Core CSS - Include with every page -->
    <link href="<?=base_url()?>content/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>content/bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?=base_url()?>content/bootstrap/css/sb-admin.css" rel="stylesheet">

</head>

<body>
    <div class="container">
                                <div id="error" class="alert alert-danger alert-dismissable" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span id="msg"></span>
                            </div>
        <? if($this->engine['engine_is_partner'] == 1): ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post" id="l_form" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="p_login" id="p_login" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="p_password" id="p_pwd" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="#." onClick="checkPartnerForm()"; class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? else: ?>
        <div id="error" class="alert alert-danger alert-dismissable" >
                                
                                <span id="msg">Панель управления партнеров временно недоступна. Приносим свои извенения за неудобства.</span>
                            </div>
        <? endif; ?>
    </div>
    <!-- Core Scripts - Include with every page -->
    <script src="<?=base_url()?>content/bootstrap/js/jquery-1.10.2.js"></script>
    <script src="<?=base_url()?>content/js/jquery.blockui.js"></script>
    <script src="<?=base_url()?>content/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>content/bootstrap/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?=base_url()?>content/bootstrap/js/sb-admin.js"></script>
	<script type="text/javascript">
		$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
		
		function checkPartnerForm()
		{
			login = $('#p_login').val();
			pwd = $('#p_pwd').val();

			if (login == '' || pwd == '')
			{
				return;
			}

			$.ajax({
				url: '<?=base_url()?>login/partner/',
				type: 'POST',
				dataType: 'json',
				data: { login: login, password: pwd },
				success: function(obj) {
					if (obj.result == 'success') {
						window.location.href = '<?=base_url()?>partner/first/';
					}
					else {
						$('#msg').html(obj.message);
						$('#error').show();
					}
				}
			});
		}	
	</script>
</body>

</html>


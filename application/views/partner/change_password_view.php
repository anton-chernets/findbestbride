<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Смена пароля</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
          <? if($resInfo != ''): ?>
             <div class="alert alert-<?if($resInfo['result'] == 'success'):?>success<?else:?>danger<?endif;?> alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <?=$resInfo['text']?>
             </div>
            <? endif; ?>
                        <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                        <form role="form" id="savePassword" action="" method="POST">
                        <input type="hidden" value="1" name="save" />
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Старый пароль</label>
                                            <input class="form-control" type="password" name="old_pwd" id="old_pwd">
                                           
                                        </div>
           
                                  
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    
                               
                                        <div class="form-group">
                                            <label>Новый пароль</label>
                                            <input class="form-control" type="password" name="new_pwd" id="new_pwd">
                                           
                                        </div>                                       
                                         <div class="form-group">
                                            <label>Повторите новый пароль</label>
                                            <input class="form-control" type="password" name="r_pwd" id="r_pwd">
                                           
                                        </div>
                                
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                             <div align="center">
                             	<button type="button" onClick="sendThisForm()" class="btn btn-outline btn-primary btn-lg btn-block">Сохранить пароль</button>
                             </div>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
        </div>
        <!-- /#page-wrapper -->
<script type="text/javascript">
	function sendThisForm()
	{
		old = $('#old_pwd').val();
		n_pw = $('#new_pwd').val();
		r_pw = $('#r_pwd').val();

		if (old == '')
		{
			alert('Укажите старый пароль');
			return;
		}

		if (n_pw == '')
		{
			alert('Укажите новый пароль');
			return;
		}

		if (r_pwd == '')
		{
			alert('Повторите новый пароль');
			return;
		}

		if (old == n_pw)
		{
			alert('Старый и новый пароли не должны совпадать');
			return;
		}

		if (n_pw != r_pw)
		{
			alert('Указанные вами пароли не совпали');
			return;
		}

		$('#savePassword').submit();
	}
</script>
      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Добавление анкеты</h1>
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

                           <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Все поля данной формы обязательны для заполнения. Также вы обязаны загрузить сканированную копию паспорта.
                            </div>

                        <form role="form" id="newProfile" action="" enctype="multipart/form-data" method="POST">
                        <input type="hidden" value="1" name="add_profile" />
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Имя девушки</label>
                                            <input class="form-control" type="text" name="name" id="name">
                                           
                                        </div>
                                        <div class="form-group">
                                            <label>Фамилия девушки</label>
                                            <input class="form-control" type="text" name="lastname" id="lastname">
                                        </div>
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input class="form-control" type="text" name="email" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Пароль</label>
                                            <input class="form-control" type="text" name="pwd" id="pwd">
                                        </div>
           
                                  
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                 <div class="form-group">
                                      <label>Моб. телефон девушки</label>
                                      <input class="form-control" type="text" name="mobile" id="mobile">
                                  </div>
                               
                                  <div class="form-group">
                                       <label>Страна</label>
                                      <?=$country?>
                                  </div>         
                                  
                                  <div class="form-group">
                                        <label>Копии паспорта (только формат .jpg)</label>
                                        <input type="file" name="passport_1" id="passport_1" accept="image/*">
                    
                                  </div>                        
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                             <div align="center">
                             	<button type="button" onClick="sendThisForm()" class="btn btn-outline btn-primary btn-lg btn-block">Добавить анкету</button>
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
		name = $('#name').val();
		lastname = $('#lastname').val();
		mobile = $('#mobile').val();
		email = $('#email').val();
		file = $('#passport_1').val();
		file2 = $('#passport_2').val();
		file3 = $('#passport_3').val();
		pwd = $('#pwd').val();

		if (name == '')
		{
			alert('Укажите имя девушки');
			return;
		}

		if (lastname == '')
		{
			alert('Укажите фамилию девушки');
			return;
		}

		if (mobile == '')
		{
			alert('Укажите контактный телефон девушки');
			return;
		}

		if (email == '')
		{
			alert('Укажите e-mail');
			return;
		}

		if (pwd == '')
		{
			alert('Укажите пароль');
			return;
		}

		if (file == '' || file2 == '' || file3 == '')
		{
			alert('Добавьте копии паспорта');
			return;
		}

		$('#newProfile').submit();
	}

</script>
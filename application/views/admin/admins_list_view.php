             <div class="span9" id="content">
             <? if($resInfo != ''): ?>
				<div class="alert alert-<?=$resInfo['type']?> alert-block">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<h4 class="alert-heading"></h4>
						<?=$resInfo['text']?>
				</div>
			<? endif; ?>
                    <div class="row-fluid">
                        <!-- block -->
                      <? if($list != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список администраторов</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                <div align="right"><a href="#newForm" data-toggle="modal" class="btn btn-success"><i class="icon-plus icon-white"></i> Добавить нового администратора</a></div>
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>ID</th>
						                  <th>Логин</th>
						                  <th>Уровень прав</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($list as $row): ?>
						                <tr id="a_<?=$row['id']?>" <? if($row['id'] == $this->adminInfo['id']):?>class="success"<?endif;?>>
						                  <td><?=$row['id']?></td>
						                  <td><?=$row['a_login']?></td>
						                  <td>FULL</td>
						                  <td><? if($row['id'] != $this->adminInfo['id']):?><a href="#" onClick="deleteAdmin('<?=$row['id']?>');" class="btn btn-danger"><i class="icon-remove icon-white"></i> Удалить</a><?else:?><a href="/admin/first/password" class="btn btn-primary">Изменить пароль</a><?endif;?></td>
						                </tr>
						            <? endforeach; ?>
						              </tbody>
						            </table>
						            
						            
						            <div id="newForm" class="modal hide">
										<div class="modal-header">
											<button data-dismiss="modal" class="close" type="button">&times;</button>
											<h3>Новая учетная запись</h3>
										</div>
										<div class="modal-body">
											<form action="" method="post" id="newAdminForm" class="form-horizontal">
											<input type="hidden" value="1" name="add">
											     <fieldset>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Логин</label>
                                                      <div class="controls">
                                                        <input class="input-xlarge focused" name="n_a_login" id="focusedInput" type="text" value="">
                                                      </div>
                                                    </div>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Пароль</label>
                                                      <div class="controls">
                                                        <input class="input-xlarge focused" name="n_a_pwd" id="focusedInput" type="text" value="">
                                                      </div>
                                                    </div>
													<div align="center">
  														<button type="button" onClick="checkThisForm()" class="btn btn-primary">Добавить</button>
  														<button type="button" data-dismiss="modal" class="btn">Отмена</button>
  													</div>
                                                  </fieldset>
											</form>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /block -->
                    <? else: ?>
                    	<div class="alert alert-block">
							<a class="close" data-dismiss="alert" href="#">&times;</a>
							<h4 class="alert-heading">Ошибка</h4>
							Список администраторов пуст. Внимание! Если вы видите это сообщение, значит вы удалили всех администраторов. Если вы выйдете из админ-панели, у вас больше не будет возможности зайти.
							Обрабитесь к разработчику.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
  <script type="text/javascript">
   	function deleteAdmin(id)
   	{
		$.ajax({
			url: '<?=base_url()?>admin/first/ajax/delete_admin/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#a_'+id).html('');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
   	}

   	function checkThisForm()
   	{
   	   	login = $('input[name="n_a_login"]').val();
   	   	pwd   = $('input[name="n_a_pwd"]').val();

   	   	if (login == '' || pwd == '')
   	   	{
   	   	   	alert('Укажите логин и пароль');
   	   	   	return;
   	   	}

   	   	$('#newAdminForm').submit();
   	}
   </script>
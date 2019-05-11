             <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($list != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Запросы контактных данных</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>От кого</th>
						                  <th>Кому</th>
						                  <th>E-mail мужчины</th>
						                  <th>Конт. данные</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? $c = userCountry(); 
						              	foreach($list as $row): 
						              	$man = $this->mainModel->getUserProfile($row['id']);
						              	$women = $this->mainModel->getUserProfile($row['req_id']);
						              ?>
						                <tr <? if($row['status'] == '0'):?>class="info"<?else:?>class="success"<?endif;?> id="p_<?=$row['hash']?>">
						                  <td>[<?=$row['id']?>]<br/><?=$man['name']?></td>
						                  <td>[<?=$row['req_id']?>]<br/><?=$women['name']?></td>
						                  <td><?=$man['email']?></td>
						                  <td><a href="#modal_<?=$row['id']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['id']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Информация учетной записи</h3>
											</div>
											<div class="modal-body">
												<p><b>Страна</b>: <?=$c[$women['country']]?></p>
												<p><b>E-mail</b>: <?=$women['email']?></p>
												<p><b>Телефон</b>: <? if($women['w_phone'] != ''): echo $women['w_phone']; else:?>не указан<?endif;?></p>
												
											</div>
										</div></td>
						                  <td><? if($row['status'] == '0'): ?><button class="btn btn-success btn-mini" onClick="approve('<?=$row['hash']?>')">Отправить</button>&nbsp;<button onClick="cancel('<?=$row['hash']?>')" class="btn btn-danger btn-mini">Отказать</button>
						                  <br/>
						                  <button onClick="check_c('<?=$row['hash']?>');" class="btn btn-info btn-mini">Отметить как выполненное</button>
						                  <? else: ?>
						                  <button onClick="delete_c('<?=$row['hash']?>')" class="btn btn-danger btn-mini">Удалить</button>
						                  <? endif; ?>
						                  </td>
						                </tr>
						            <? endforeach; ?>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /block -->
                    <? else: ?>
                    	<div class="alert alert-block">
							<a class="close" data-dismiss="alert" href="#">&times;</a>
							<h4 class="alert-heading">Ошибка</h4>
							Список запросов контактов пуст.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(hash)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/req/ajax/c_approve/',
        			type: 'POST',
        			dataType: 'json',
        			data: { hash: hash },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#p_'+hash).removeClass('info');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }

            function cancel(hash)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/req/ajax/c_cancel/',
        			type: 'POST',
        			dataType: 'json',
        			data: { hash: hash },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#p_'+hash).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }

            function check_c(hash)
            {
                $.ajax({
					url: '<?=base_url()?>admin/req/ajax/c_check/',
					type: 'POST',
					dataType: 'json',
					data: { hash: hash },
					success: function(obj) {
						if (obj.result == 'success') {
							$('#p_'+hash).removeClass('info');
						}
						else
						{
							alert(obj.message);
						}
					}
                });
            }

            function delete_c(hash)
            {
                $.ajax({
					url: '<?=base_url()?>admin/req/ajax/c_delete/',
					type: 'POST',
					dataType: 'json',
					data: { hash: hash },
					success: function(obj) {
						if (obj.result == 'success') {
							$('#p_'+hash).html('');
						}
						else
						{
							alert(obj.message);
						}
					}
                });
            }
      </script>

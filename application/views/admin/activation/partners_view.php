             <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($partners != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Партнеры, ожидающие активации</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>ID</th>
						                  <th>Логин</th>
						                  <th>Название</th>
						                  <th>Информация</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($partners as $row): 
						              ?>
						                <tr id="p_<?=$row['id']?>">
						                  <td><?=$row['id']?></td>
						                  <td><?=$row['p_login']?></td>
						                  <td><?=$row['p_name']?></td>
						                  <td><a href="#modal_<?=$row['id']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['id']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Информация учетной записи партнера</h3>
											</div>
											<div class="modal-body">
												<p><b>Название</b>: <?=$row['p_name']?></p>
												<p><b>Директор</b>: <?=$row['p_director']?></p>
												<p><b>Адрес</b>: <?=$row['p_address']?></p>
												<p><b>Телефон</b>: <?=$row['p_telephone']?></p>
												<p><b>Моб. телефон</b>: <?=$row['p_mobile']?></p>
												<p><b>E-mail</b>: <?=$row['p_email']?></p>
												<p><b>Страна</b>: <? if($row['p_country'] == 1):?>Украина<?else:?>Россия<?endif;?></p>
												<? if($row['p_country'] == 1):?>
												<p><b>Банк</b>: <?=$row['p_bank']?></p>
												<p><b>Тип счета</b>: <? if($row['p_bank_type'] == 1):?>Счет<?else:?>Карта<?endif;?></p>
												<p><b>Владелец</b>: <?=$row['p_bank_name']?></p>
												<p><b>Номер счета</b>: <?=$row['p_bank_number']?></p>
												<? elseif ($row['p_country'] == 2):?>
												<p><b>Кошелек WM</b>: <?=$row['p_bank_number']?></p>
												<? endif; ?>
											</div>
										</div></td>
						                  <td><button class="btn btn-success btn-mini" onClick="approve('<?=$row['id']?>')">Подтвердить</button>&nbsp;<button onClick="cancel('<?=$row['id']?>')" class="btn btn-danger btn-mini">Отказать</button></td>
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
							Нет учетных записей партнеров, которые необходимо активировать.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(id)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/partner_approve/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#p_'+id).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }

            function cancel(id)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/partner_cancel/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#p_'+id).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }
      </script>
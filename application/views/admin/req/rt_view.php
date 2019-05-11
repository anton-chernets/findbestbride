           <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($list != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Запросы романтических туров</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>От кого</th>
						                  <th>Кому</th>
						                  <th>Email мужчины</th>
						                  <th>ID тура</th>
						                  <th>Про тур</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <?
						              	foreach($list as $row): 
						              	$man = $this->mainModel->getUserProfile($row['id']);
						              	$women = $this->mainModel->getUserProfile($row['req_id']);
						              	
						              	$info = $this->aModel->getRtInfo($row['tour_id']);
						              ?>
						                <tr <? if($row['status'] == '0'):?>class="info"<?else:?>class="success"<?endif;?> id="p_<?=$row['hash']?>">
						                  <td>[<?=$row['id']?>]<br/><?=$man['name']?></td>
						                  <td>[<?=$row['req_id']?>]<br/><?=$women['name']?></td>
						                  <td><?=$man['email']?></td>
						                  <td><?=$row['tour_id']?></td>
						                  <td><a href="#modal_<?=$row['hash']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['hash']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Информация ром. тура</h3>
											</div>
											<div class="modal-body">
												<p><b>Услуги переводчика</b>:</p>
												<ul>
													<li>$<?=$info['perevod_1']?> за 1 час</li>
													<li>$<?=$info['perevod_8']?> за 8 часов</li>
													<li>$<?=$info['perevod_16']?> за 16 часов</li>
												</ul>
												<p><b>Услуги водителя</b>:</p>
												<ul>
													<li>$<?=$info['driver_1']?> за 1 час</li>
													<li>$<?=$info['driver_8']?> за 8 часов</li>
													<li>$<?=$info['driver_16']?> за 16 часов</li>
												</ul>
												<p><b>Стоимость завтрака</b>: $<?=$info['morning']?></p>
												<p><b>Стоимость обеда</b>: $<?=$info['afternoon']?></p>
												<p><b>Стоимость ужина</b>: $<?=$info['evening']?></p>

                        						<p><b>Стоимость квартиры</b>: $<?=$info['house_price']?></p>
                        						<p><b>Сведения о квартире</b>: <?=$info['house_info']?></p>
                        						<p><b>Стоимость мини-бара</b>: $<?=$info['minibar_price']?></p>
                        						<p><b>Содержимое мини-бара</b>: <?=$info['minibar_items']?></p>

                        						<p><b>Экскурсии</b>: <?=$info['eks']?></p>
                       							 <p><b>Услуги</b>: <?=$info['uslugi']?></p>
                        						<p><b>Стоимость услуг</b>: $<?=$info['uslugi_price']?></p>

                        						<p><b>Ближайший аэропорт (город)</b>: <?=$info['airport']?></p>
                        						<p><b>Город прибытия</b>: <?=$info['city']?></p>
                        						<p><b>Расстояние трансфера</b>: <?=$info['transfer_km']?> km</p>
                        						<p><b>Стоимость трансфера</b>: $<?=$info['transfer_price']?></p>
											</div>
										</div></td>
						                  <td><? if($row['status'] == '0'): ?>
						                  
						                  <button onClick="check_c('<?=$row['hash']?>');" class="btn btn-info btn-mini">Отметить как выполненное</button>
						                  <? else: ?>
						                  
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
							Список запросов романтических туров пуст.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function check_c(hash)
            {
                $.ajax({
					url: '<?=base_url()?>admin/req/ajax/c_rt/',
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

      </script>

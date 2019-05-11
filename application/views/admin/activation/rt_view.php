             <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($rt != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Романтические туры, ожидающие активации</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Агенство</th>
						                  <th>ID тура</th>
						                  <th>Информация</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($rt as $row): 
						              	$agency_name = $this->aModel->getAgencyName($row['p_id']);
										$ephoto = $this->aModel->getTourPhoto($row['photo_id'], 1);
										$hphoto = $this->aModel->getTourPhoto($row['photo_id'], 2);
										$uphoto = $this->aModel->getTourPhoto($row['photo_id'], 3);
						              ?>
						                <tr id="a_<?=$row['tour_id']?>">
						                  <td>[<?=$row['p_id']?>]<br/><?=$agency_name?></td>
						                  <td><?=$row['tour_id']?></td>
						                  <td><a href="#modal_<?=$row['tour_id']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>	
						                  <div id="modal_<?=$row['tour_id']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Информация романтического тура</h3>
											</div>
											<div class="modal-body">
												<p><b>Услуги переводчика</b>:</p>
												<ul>
													<li>$<?=$row['perevod_1']?> за 1 час</li>
													<li>$<?=$row['perevod_8']?> за 8 часов</li>
													<li>$<?=$row['perevod_16']?> за 16 часов</li>
												</ul>
												<p><b>Услуги водителя</b>:</p>
												<ul>
													<li>$<?=$row['driver_1']?> за 1 час</li>
													<li>$<?=$row['driver_8']?> за 8 часов</li>
													<li>$<?=$row['driver_16']?> за 16 часов</li>
												</ul>
												<p><b>Стоимость завтрака</b>: $<?=$row['morning']?></p>
												<p><b>Стоимость обеда</b>: $<?=$row['afternoon']?></p>
												<p><b>Стоимость ужина</b>: $<?=$row['evening']?></p>
												<p><? foreach ($ephoto as $photo): ?>
                        						<img src="<?=base_url()?>profiles/partner/p_<?=$photo['p_id']?>/<?=$photo['photo_name']?>" height="300" width="300">
                        						<? endforeach; ?></p>
                        						<p><b>Стоимость квартиры</b>: $<?=$row['house_price']?></p>
                        						<p><b>Сведения о квартире</b>: <?=$row['house_info']?></p>
                        						<p><b>Стоимость мини-бара</b>: $<?=$row['minibar_price']?></p>
                        						<p><b>Содержимое мини-бара</b>: <?=$row['minibar_items']?></p>
                        						<p><? foreach ($hphoto as $ph): ?>
                        							<img src="<?=base_url()?>profiles/partner/p_<?=$ph['p_id']?>/<?=$ph['photo_name']?>" height="300" width="300">
                       							 <? endforeach; ?></p>
                        						<p><b>Экскурсии</b>: <?=$row['eks']?></p>
                       							 <p><b>Услуги</b>: <?=$row['uslugi']?></p>
                        						<p><b>Стоимость услуг</b>: $<?=$row['uslugi_price']?></p>
                        						<p><? foreach ($uphoto as $p): ?>
                        							<img src="<?=base_url()?>profiles/partner/p_<?=$p['p_id']?>/<?=$p['photo_name']?>" height="300" width="300">
                        						<? endforeach;?></p>
                        						<p><b>Ближайший аэропорт (город)</b>: <?=$row['airport']?></p>
                        						<p><b>Город прибытия</b>: <?=$row['city']?></p>
                        						<p><b>Расстояние трансфера</b>: <?=$row['transfer_km']?> km</p>
                        						<p><b>Стоимость трансфера</b>: $<?=$row['transfer_price']?></p>
											</div>
										</div></td>
						                  <td><button class="btn btn-success btn-mini" onClick="approve('<?=$row['tour_id']?>')">Подтвердить</button>&nbsp;<button onClick="cancel('<?=$row['tour_id']?>')" class="btn btn-danger btn-mini">Отказать</button></td>
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
							Нет романтических туров, ожидающих активацию
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(id)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/rt_approve/',
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

            function cancel(id)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/rt_cancel/',
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
      </script>
            
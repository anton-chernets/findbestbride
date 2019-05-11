             <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($ankets != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Анкеты, ожидающие активации</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Агенство</th>
						                  <th>Имя/Фамилия</th>
						                  <th>Страна</th>
						                  <th>Телефон</th>
						                  <th>Копия паспорта</th>
						                  <th>Профиль</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($ankets as $row): 
						              	$agency_name = $this->aModel->getAgencyName($row['is_agency']);
						              	$c = userCountry();
										$whatJpg = (file_exists('./profiles/partner/p_'.$row['is_agency'].'/'.$row['is_passport'].'.jpg')) ? '.jpg' : '.JPG';
										$profile = $this->activation_model->getAnketDetails($row['id']);
						              ?>
						                <tr id="a_<?=$row['id']?>">
						                  	<td>[<?=$row['is_agency']?>]<br/><?=$agency_name?></td>
						                  	
						                 	<td><?=$row['name']?><br/><?=$row['lastname']?></td>
						                 	
						                  	<td><?=$c[$row['country']]?></td>
						                  	
						                  	<td><?=$row['w_phone']?></td>
						                  	
						                  	<td><a href="#modal_<?=$row['id']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  		<div id="modal_<?=$row['id']?>" class="modal hide">
													<div class="modal-header">
														<button data-dismiss="modal" class="close" type="button">&times;</button>
														<h3>Фотография</h3>
													</div>
													<div class="modal-body">
														<?php foreach ($this->activation_model->getPassportPhotos($row['id']) as $passport) { ?>
														<p><img src="<?=base_url()?>profiles/partner/p_<?=$row['is_agency']?>/<?=$passport['passport']?>"></p>
														<?php } ?>
													</div>
												</div>
											</td>
											
											<td>
												<?php if (empty($profile['city']) && empty($profile['occupation']) && empty($profile['about_me']) && empty($profile['about_partner'])) { ?>
													Профиль не заполнен.
												<?php } else { ?>
													<a href="#modal_profile_<?=$row['id']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>
													<div id="modal_profile_<?=$row['id']?>" class="modal hide">
														<div class="modal-header">
															<button data-dismiss="modal" class="close" type="button">&times;</button>
															<h3>Профиль</h3>
														</div>
														<div class="modal-body">
															<ul>
																<li>Город: <strong><?=$profile['city'];?></strong></li>
																<li>Профессия: <strong><?=$profile['occupation'];?></strong></li>
																<li>Дата рождения: <strong><?=$row['b_day']?>.<?=$row['b_month']?>.<?=$row['b_year']?></strong>, возраст: <strong><?=$row['age']?></strong></li>
																<li>Семейное положение: <strong><?=$this->profile->createMarriage($profile['marriage']);?></strong></li>
																<li>Дети: <strong><?=$this->profile->createChildren($profile['children']);?></strong></li>
																<li>Цвет волос: <strong><?=$this->profile->createHairColor($profile['hair']);?></strong></li>
																<li>Цвет глаз: <strong><?=$this->profile->createEyesColor($profile['eyes']); ?></strong></li>
																<li>Религия: <strong><?=$this->profile->createReligion($profile['religion']);?></strong></li>
																<li>Образование: <strong><?=$this->profile->createEducationLevel($profile['education']);?></strong></li>
																<li>Владение английским: <strong><?=$this->profile->createEnglish($profile['english']);?></strong></li>
																<li>Курение: <strong><?=$this->profile->createSmokingDrinking($profile['smoke']);?></strong></li>
																<li>Алкоголь: <strong><?=$this->profile->createSmokingDrinking($profile['drink']);?></strong></li>
																<li>Рост: <strong><?=$this->profile->createHeight($profile['height']);?></strong></li>
																<li>Вес: <strong><?=$this->profile->createWeight($profile['weight']);?></strong></li>
																<li>Хоби: <strong><?=$profile['hobbies'];?></strong></li>
																<li>Возраст поиска: от <strong><?=$profile['age_from']?> до <?=$profile['age_to'];?></strong></li>
																<li>Цель знакомства: <strong><?=$profile['aoa'];?></strong></li>
																<li>О себе: <strong><?=$profile['about_me'];?></strong></li>
																<li>О партнере: <strong><?=$profile['about_partner'];?></strong></li>
															</ul>
														</div>
													</div>
												<?php } ?>
											</td>
										
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
							Нет анкет, ожидающих активацию
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(id)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/anket_approve/',
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
        			url: '<?=base_url()?>admin/activation/ajax/anket_cancel/',
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
            

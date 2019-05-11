   <div class="span9" id="content">
   <? if($resInfo != ''): ?>
		<div class="alert alert-<?=$resInfo['type']?> alert-block">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
				<h4 class="alert-heading"></h4>
					<?=$resInfo['text']?>
		</div>
	<? endif; ?>
      <div class="row-fluid">
   				<div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Аватар</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
							
										<div align="center" id="avatar">
											<? if($info['photo_link'] != ''): ?>
											<img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$info['photo_link']?>_220.jpg" />
											<br/><br/>
											<button class="btn btn-danger" onClick="deleteAvatar('<?=$info['id']?>');">Удалить</button>&nbsp;<a href="<?=base_url()?>admin/image/edit/<?=base64_encode(json_encode(array('type' => 'avatar', 'id' => $info['id'])));?>/back/<?=base64_encode($this->uri->uri_string())?>" class="btn btn-primary">Изменить</a>
											&nbsp;<a href="/admin/ank/download_avatar/<?php echo $info['id']; ?>" class="btn">Загрузить</a>
											<? else: ?>
											<img src="<?=base_url()?>content/img/no-foto.png" />
											<? endif; ?>
											<br><br>
											<form action="<?=base_url()?>admin/ank/avatar" method="POST" enctype="multipart/form-data">
												<input type="hidden" name="new" value="1">
												<input type="hidden" name="u_id" value="<?=$info['id']?>">
												<input type="file" name="userfile" accept="image/*">
												<br>
												<input type="submit" class="btn btn-success" value="Загрузить">
											</form>
										</div>
                                    </div>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        
                          <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Фотографии</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
										<? if($photo != false): ?>
											<table border="0" align="center">
												<? foreach ($photo as $row): ?>
												<tr id="p_<?=$row['photo_name']?>">
													<td><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_name']?>_105.jpg"/></td>
													<td>&nbsp;&nbsp;&nbsp;</td>
													<td><button class="btn btn-danger" onClick="deletePhoto('<?=$row['id']?>', '<?=$row['photo_name']?>');">Удалить</button>
														&nbsp;<a class="btn btn-primary" href="<?=base_url()?>admin/image/edit/<?=base64_encode(json_encode(array('type' => 'image', 'id' => $row['id'], 'photo' => $row['photo_name'])));?>/back/<?=base64_encode($this->uri->uri_string());?>">Изменить</a>
														&nbsp;<a class="btn" href="/admin/ank/download_photo/<?php echo $row['photo_id']; ?>">Загрузить</a>
													</td>
												</tr>
												<?endforeach;?>
											</table>
										<? else: ?>
										<div class="alert alert-warning">
										
										В данную анкету фотографии не загружались.
										</div>
										<? endif; ?>
										</div>
                                    </div>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                   
                        <?php 
                        if ($passport != false) {  ?>
                        <div class="row-fluid">
                        	<div class="block">
                            	<div class="navbar navbar-inner block-header">
                               		<div class="muted pull-left">Документы профиля <b><?=$info['name']?> <?=$info['lastname']?>, id: <?=$info['id']?></b></div>
                            	</div>
                            <div class="block-content collapse in">
                                <div class="span12">
                       <?php 
                        	if (!is_array($passport))
                        	{
                        ?>
                        	<img src="<?=base_url()?>profiles/partner/p_<?=$info['is_agency']?>/<?=$passport?>.jpg">
                        <?php			
                        	}
                        	elseif (is_array($passport))
                        	{
                        		foreach ($passport as $row)
                        		{	
                        ?>	<div id="passport_<?php echo $row['passportId']; ?>">
                    			<img src="<?=base_url()?>profiles/partner/p_<?=$info['is_agency']?>/<?=$row['passport']?>">
								<br><br>
								<button class="btn btn-danger" onClick="deletePassport(<?php echo $row['passportId']; ?>);">Удалить документ</button>
								&nbsp;&nbsp;
								<a href="/admin/ank/download_passport/<?php echo $row['passportId']; ?>" class="btn btn-primary">Загрузить документ</a>
								<br><br><br><br>
							</div>
                    	<?php	}
                        	}
                        
                        ?>
                        </div></div></div></div>
                        <?php } ?>
                        
                        <div class="row-fluid">
                         <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Данные профиля <b><?=$info['name']?> <?=$info['lastname']?>, id: <?=$info['id']?></b></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="saveProfile" class="form-horizontal">
					<input type="hidden" value="1" name="save">
					<input type="hidden" value="<?=$info['id']?>" name="profile">
						<fieldset>
						<?php if ($info['sex'] == 2) { ?>
							<div class="control-group">
  								<label class="control-label">Партнер</label>
  								<div class="controls">
  									<?=$this->aModel->createPartnersList($info['is_agency']); ?>
  								</div>
  							</div>
  						<?php } else {?><input type="hidden" name="p_id" value="0"/><?php } ?>
  							<div class="control-group">
  								<label class="control-label">Имя</label>
  								<div class="controls">
  									<input name="u_name" value="<?=$info['name']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>

  							<div class="control-group">
  								<label class="control-label">Фамилия</label>
  								<div class="controls">
  									<input name="u_lastname" value="<?=$info['lastname']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">E-mail</label>
  								<div class="controls">
  									<input name="u_email" value="<?=$info['email']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<?php if (!empty($info['pw'])) { ?>
  							<div class="control-group">
  								<label class="control-label">Пароль</label>
  								<div class="controls">
  									<input value="<?=$info['pw']?>" type="text" disabled="disabled" class="span6 m-wrap"/>
  								</div>
  							</div>
  							<?php } ?>
  							
  							<div class="control-group">
  								<label class="control-label">Новый пароль</label>
  								<div class="controls">
  									<input name="u_pwd" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Телефон</label>
  								<div class="controls">
  									<input name="u_phone" value="<?=$info['w_phone']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Дата рождения</label>
  								<div class="controls">
  									<?=$form['bday'] .' '. $form['bmonth'] .' '. $form['byear'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Страна</label>
  								<div class="controls">
  									<?=$form['country'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Город</label>
  								<div class="controls">
  									<input name="u_city" value="<?=$details['city']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Профессия</label>
  								<div class="controls">
  									<input name="u_occup" value="<?=$details['occupation']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Хобби</label>
  								<div class="controls">
  									<input name="u_hobbie" value="<?=$details['hobbies']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Цвет волос</label>
  								<div class="controls">
  									<?=$form['hair'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Цвет глаз</label>
  								<div class="controls">
  									<?=$form['eyes'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Рост</label>
  								<div class="controls">
  									<?=$form['height'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Вес</label>
  								<div class="controls">
  									<?=$form['weight'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Семейное положение</label>
  								<div class="controls">
  									<?=$form['marital'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Дети</label>
  								<div class="controls">
  									<?=$form['children'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Образование</label>
  								<div class="controls">
  									<?=$form['edu'];?>
  								</div>
  							</div>
  							
  							<?php if (!empty($form['english'])) { ?>
  							<div class="control-group">
  								<label class="control-label">Владение английским</label>
  								<div class="controls">
  									<?=$form['english'];?>
  								</div>
  							</div>
  							<?php } ?>
  							
  							<div class="control-group">
  								<label class="control-label">Религия</label>
  								<div class="controls">
  									<?=$form['religion'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Курение</label>
  								<div class="controls">
  									<?=$form['smoking'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Алкоголь</label>
  								<div class="controls">
  									<?=$form['drinking'];?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Возраст для знакомства</label>
  								<div class="controls">
  									от <?=$form['age_from']?> до <?=$form['age_to']?>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Цель знакомства</label>
  								<div class="controls">
  									<input name="u_aoa" value="<?=$details['aoa']?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">О себе</label>
  								<div class="controls">
  									<textarea name="u_self" class="input-xlarge textarea" style="width: 610px; height: 200px"><?=$details['about_me']?></textarea>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">О партнере</label>
  								<div class="controls">
  									<textarea name="u_partner" class="input-xlarge textarea" style="width: 610px; height: 200px"><?=$details['about_partner']?></textarea>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" class="btn btn-large btn-block btn-primary" onClick="$('#saveProfile').submit();">Сохранить профиль</button>
  							
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
				</div>
			    </div>
			</div>
                     	<!-- /block -->
		    </div>
                    </div>
                 </div>
                 
	<script>
		function deleteAvatar(id)
		{
			if (confirm('Вы уверены, что хотите удалить аватар у анкеты #'+id+'?') == true)
			{
				$.ajax({
	    			url: '<?=base_url()?>admin/ank/ajax/avatar_delete/',
	    			type: 'POST',
	    			dataType: 'json',
	    			data: { id: id },
	    			success: function(obj) {
	    				if (obj.result == 'success') {
	        				alert('Аватар удален');
	    					$('#avatar').html('');
	    				}
	    				else
	    				{
	    					alert(obj.message);
	    				}
	    			}	
	    		});
			}
		}

		function deletePhoto(id, photo)
		{
			if (confirm('Вы уверены, что хотите удалить эту фотографию у анкеты #'+id+'?') == true)
			{
				$.ajax({
	    			url: '<?=base_url()?>admin/ank/ajax/photo_delete/',
	    			type: 'POST',
	    			dataType: 'json',
	    			data: { id: id, photo: photo },
	    			success: function(obj) {
	    				if (obj.result == 'success') {
	        				alert('Фотография удалена');
	    					$('#p_'+photo).html('');
	    				}
	    				else
	    				{
	    					alert(obj.message);
	    				}
	    			}	
	    		});
			}
		}
		
		function deletePassport(passportId) {
			$.ajax({
				url: '/admin/ank/ajax/delete_passport/',
				type: 'post',
				data:  { id: passportId },
				success: function() {
					$('#passport_' + passportId).remove();
				}
			});
		}

   	</script>
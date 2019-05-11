   
      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Изменение профиля <?=$info['name']?> <?=$info['lastname']?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <? if($resInfo != ''): ?>
             <div class="alert alert-<?if($resInfo['type'] == 'success'):?>success<?else:?>danger<?endif;?> alert-dismissable">
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

                        <form role="form" action="" method="POST">
                        <input type="hidden" value="1" name="change_profile" />
                        <input type="hidden" value="<?=$info['id']?>" name="u_id" />
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Имя</label>
                                            <input class="form-control" type="text" name="u_name" value="<?=$info['name']?>">
                                            
                                        </div>
                                        <div class="form-group">
                                           	<label>Фамилия</label>
                                            <input class="form-control" type="text" name="u_lastname" value="<?=$info['lastname']?>">
                                        	 
                                        </div>
                                        <?php if (!empty($info['pw'])) {?>
                                        <div class="form-group">
                                           	<label>Пароль</label>
                                            <input class="form-control" type="text" disabled="disabled" value="<?=$info['pw']?>">
                                        	 
                                        </div>
                                        <?php } ?>
                                        
                                        <div class="form-group">
                                           	<label>Новый пароль</label>
                                            <input class="form-control" type="text" value="" name="newpw">
                                        	 
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Страна</label>
                                            <?=$other['country']?>
                                             
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Уровень образования</label>
                                            <?=$other['edu']?>
                                        </div>
                                        <div class="form-group">
                                            <label>Семейное положение</label>
                                            <?=$other['marry']?>
                                        </div>
                                        <div class="form-group">
                                            <label>Рост</label>
                                            <?=$other['height']?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Вес</label>
                                            <?=$other['weight']?>
                                            
                                        </div>
           								<div class="form-group">
                                            <label>Цвет глаз</label>
                                            <?=$other['eyes']?>
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Цвет волос</label>
                                            <?=$other['hair']?>
                                            
                                        </div>
                                  
                                        <div class="form-group">
                                        	<label>Курение</label>
                                        	<?=$other['smoking']?>
                                 		 </div> 
                                 		 
                                 		 <div class="form-group">
                                            <label>Алкоголь</label>
                                            <?=$other['drinking']?> 
                                        </div> 
                                        
                                        <div class="form-group">
                                           	<label>Телефон</label>
                                            <input class="form-control" type="text" name="u_phone" value="<?=$info['w_phone']?>">
                                        	 
                                        </div>
                                        
                                        <div class="form-group">
                                        <label>О себе</label>
                                        <textarea class="form-control" rows="3" name="u_about"><?=$details['about_me']?></textarea>
                                        
                                  </div>
                                   		
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                 <div class="form-group">
                                      <label>День рождения</label>
                                      <?=$other['day']?>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Месяц рождения</label>
                                      <?=$other['month']?>
                                      
                                  </div>
                               
                                  <div class="form-group">
                                      <label>Год рождения</label>
                                      <?=$other['year']?>
                                      
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Город</label>
                                      <input class="form-control" type="text" name="u_city" value="<?=$details['city']?>">
                                      
                                  </div>
                                  
                                  <div class="form-group">
                                        <label>Профессия</label>
                                        <input class="form-control" type="text" name="u_occupation" value="<?=$details['occupation']?>">
                                  </div> 
                                  
                                  <div class="form-group">
                                       <label>Религия</label>
                                     	<?=$other['religion']?>
                                  </div>         
                                  
                                  <div class="form-group">
                                       <label>Дети</label>
                                     	<?=$other['child']?>
                                  </div>  
                                  
                                  <div class="form-group">
                                       <label>Уровень английского</label>
                                     	<?=$other['english']?>
                                  </div>  
                                  <div class="form-group">
                                       <label>Хобби</label>
                                     	<input class="form-control" type="text" name="u_hobbies" value="<?=$details['hobbies']?>">
                                  </div>  
                                  <div class="form-group">
                                        <label>Цель знакомства</label>
                                        <input class="form-control" type="text" name="u_aoa" value="<?=$details['aoa']?>">
                                  </div> 
                                  <div class="form-group">
                                       <label>Возрастной критерий от</label>
                                     	<?=$other['age_from']?>
                                  </div> 
                                  <div class="form-group">
                                       <label>До</label>
                                     	<?=$other['age_to']?>
                                  </div>       
                                  
                                  <div class="form-group">
                                        <label>О партнере</label>
                                        <textarea class="form-control" rows="3" name="u_partner"><?=$details['about_partner']?></textarea>
                                        
                                  </div>
                                                   
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                             <div align="center">
                             	<button type="submit" class="btn btn-outline btn-primary btn-lg btn-block">Сохранить профиль</button>
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
        
        <script>
        
        	function sendThisForm()
        	{
            	// переводчик
            	tr_o = $('input[name="tr_o"]').val();
            	tr_t = $('input[name="tr_t"]').val();
            	tr_th = $('input[name="tr_th"]').val();

            	// водитель
            	dr_o = $('input[name="dr_o"]').val();
            	dr_t = $('input[name="dr_t"]').val();
            	dr_th = $('input[name="dr_th"]').val();

            	// завтрак + обед
            	m_price = $('input[name="m_price"]').val();
            	a_price = $('input[name="a_price"]').val();

            	// ужин
            	e_price = $('input[name="e_price"]').val();
            	e_photo = $('#e_photo').val();

            	// квартира
            	house = $('input[name="house"]').val();
            	house_info = $('input[name="house_info"]').val();
            	h_photo = $('#h_photo').val();

            	// минибар
            	bar = $('input[name="bar"]').val();
            	bar_price = $('input[name="bar_price"]').val();

            	// услуги
				uslugi = $('input[name="uslugi"]').val();
				uslugi_price = $('input[name="uslugi_price"]').val();
				u_photo = $('#u_photo').val();

				// прочее
				airport = $('input[name="airport"]').val();
				city = $('input[name="city"]').val();
				tr_km = $('input[name="tr_km"]').val();
				tr_price = $('input[name="tr_price"]').val();

				// экскурсии
				eks = $('input[name="eks"]').val();

            	if (tr_o == '' || tr_t == '' || tr_th == '')
            	{
                	alert('Укажите стоимость услуг переводчика');
                	return;
            	}

            	if (dr_o == '' || dr_t == '' || dr_th == '')
            	{
                	alert('Укажите стоимость услуг водителя');
                	return;
            	}

            	if (m_price == '' || a_price == '')
            	{
                	alert('Укажите стоимость завтрака и обеда');
                	return;
            	}

            	if (e_price == '' || e_photo == '')
            	{
                	alert('Укажите стоимость ужина и прикрепите фотографии');
                	return;
            	}

            	if (house == '' || house_info == '' || h_photo == '')
            	{
                	alert('Укажите информацию о квартире');
                	return;
            	}

            	if (bar == '' || bar_price == '')
            	{
                	alert('Укажите информацию по мини-бару');
                	return;
            	}

            	if (uslugi == '' || uslugi_price == '' || u_photo == '')
            	{
                	alert('Вам необходимо указать хотя бы одну услугу / развлечение');
                	return;
            	}

            	if (eks == '')
            	{
                	alert('Укажите доступные экскурсии');
                	return;
            	}

            	if (airport == '' || city == '' || tr_km == '' || tr_price == '')
            	{
                	alert('Укажите всю информацию по трансферу');
                	return;
            	}

            	$('#newTour').submit();
        	}
        </script>



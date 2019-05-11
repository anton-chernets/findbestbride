    
      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Изменение романтического тура</h1>
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

                           <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Все поля данной формы обязательны для заполнения. Форму необходимо заполнять только на АНГЛИЙСКОМ языке.
                            </div>

                        <form role="form" id="newTour" action="" enctype="multipart/form-data" method="POST">
                        <input type="hidden" value="1" name="c_tour" />
                        <input type="hidden" value="<?=$info['tour_id']?>" name="p_id" />
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Услуги переводчика</label>
                                            <input class="form-control" type="text" name="tr_o" value="<?=$info['perevod_1']?>">
                                            <p class="help-block">$ за 1 час</p>
                                        </div>
                                        <div class="form-group">
                                           
                                            <input class="form-control" type="text" name="tr_t" value="<?=$info['perevod_8']?>">
                                        	 <p class="help-block">$ за 8 часов</p>
                                        </div>
                                        <div class="form-group">
                                            
                                            <input class="form-control" type="text" name="tr_th" value="<?=$info['perevod_16']?>">
                                             <p class="help-block">$ за 16 часов</p>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Услуги водителя</label>
                                            <input class="form-control" type="text" name="dr_o" value="<?=$info['driver_1']?>">
                                            <p class="help-block">$ за 1 час</p>
                                        </div>
                                        <div class="form-group">
                                           
                                            <input class="form-control" type="text" name="dr_t" value="<?=$info['driver_8']?>">
                                        	 <p class="help-block">$ за 8 часов</p>
                                        </div>
                                        <div class="form-group">
                                            
                                            <input class="form-control" type="text" name="dr_th" value="<?=$info['driver_16']?>">
                                             <p class="help-block">$ за 16 часов</p>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Стоимость завтрака ($)</label>
                                            <input class="form-control" type="text" name="m_price" value="<?=$info['morning']?>">
                                            
                                        </div>
           								<div class="form-group">
                                            <label>Стоимость обеда ($)</label>
                                            <input class="form-control" type="text" name="a_price" value="<?=$info['afternoon']?>">
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Стоимость романтического ужина ($)</label>
                                            <input class="form-control" type="text" name="e_price" value="<?=$info['evening']?>">
                                            
                                        </div> 
                                 		 
                                 		 <div class="form-group">
                                            <label>Стоимость аренды квартиры ($)</label>
                                            <input class="form-control" type="text" name="house" value="<?=$info['house_price']?>">   
                                        </div> 
                                        
                                        <div class="form-group">
                                        <label>Краткие сведения о квартире</label>
                                        <textarea class="form-control" rows="3" name="house_info"><?=$info['house_info']?></textarea>
                                        
                                  	</div>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                 <div class="form-group">
                                      <label>Мини-бар в квартире</label>
                                      <input class="form-control" type="text" name="bar" value="<?=$info['minibar_items']?>">
                                      <p class="help-block">содержимое мини-бара</p>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Стоимость мини-бара ($)</label>
                                      <input class="form-control" type="text" name="bar_price" value="<?=$info['minibar_price']?>">
                                      
                                  </div>
                               
                                  <div class="form-group">
                                      <label>Услуги / развлечения</label>
                                      <input class="form-control" type="text" name="uslugi" value="<?=$info['uslugi']?>">
                                      
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Стоимость услуг / развлечений ($)</label>
                                      <input class="form-control" type="text" name="uslugi_price" value="<?=$info['uslugi_price']?>">
                                      
                                  </div>
                                  
                                  <div class="form-group">
                                       <label>Ближайший аэропорт (город)</label>
                                     	<input class="form-control" type="text" name="airport" value="<?=$info['airport']?>">
                                  </div>         
                                  
                                  <div class="form-group">
                                       <label>Город прибытыя</label>
                                     	<input class="form-control" type="text" name="city" value="<?=$info['city']?>">
                                  </div>  
                                  
                                  <div class="form-group">
                                       <label>Расстояние трансфера (км)</label>
                                     	<input class="form-control" type="text" name="tr_km" value="<?=$info['transfer_km']?>">
                                  </div>  
                                  <div class="form-group">
                                       <label>Стоимость трансфера ($)</label>
                                     	<input class="form-control" type="text" name="tr_price" value="<?=$info['transfer_price']?>">
                                  </div>  
                                  <div class="form-group">
                                        <label>Экскурсии</label>
                                        <textarea class="form-control" rows="3" name="eks"><?=$info['eks']?></textarea>
                                        <p class="help-block">Перечислите доступные экскурсии</p>
                                  </div>                        
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                             <div align="center">
                             	<button type="button" onClick="sendThisForm()" class="btn btn-outline btn-primary btn-lg btn-block">Сохранить романтический тур</button>
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

            	// квартира
            	house = $('input[name="house"]').val();
            	house_info = $('input[name="house_info"]').val();

            	// минибар
            	bar = $('input[name="bar"]').val();
            	bar_price = $('input[name="bar_price"]').val();

            	// услуги
				uslugi = $('input[name="uslugi"]').val();
				uslugi_price = $('input[name="uslugi_price"]').val();

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

            	if (e_price == '')
            	{
                	alert('Укажите стоимость ужина и прикрепите фотографии');
                	return;
            	}

            	if (house == '' || house_info == '')
            	{
                	alert('Укажите информацию о квартире');
                	return;
            	}

            	if (bar == '' || bar_price == '')
            	{
                	alert('Укажите информацию по мини-бару');
                	return;
            	}

            	if (uslugi == '' || uslugi_price == '')
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


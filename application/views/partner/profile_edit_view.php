       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Мой профиль</h1>
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
                        <? if($this->partInfo['p_status'] == '0'):?>
                           <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Все поля данной формы обязательны для заполнения.
                            </div>
                        <? endif; ?>
						
						<div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Все поля данной формы обязательны для заполнения. Форму необходимо заполнять только на АНГЛИЙСКОМ языке.
                        </div>
                        <form role="form" id="saveProfileForm" action="" method="POST">
                        <input type="hidden" value="1" name="save" />
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Название агенства</label>
                                            <input class="form-control" type="text" name="p_name" id="p_name" value="<?=$this->partInfo['p_name']?>">
                                           
                                        </div>
                                        <div class="form-group">
                                            <label>ФИО директора</label>
                                            <input class="form-control" type="text" name="director" id="director" value="<?=$this->partInfo['p_director']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Адрес агенства</label>
                                            <input class="form-control" type="text" name="address" id="address" value="<?=$this->partInfo['p_address']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Телефон</label>
                                            <input class="form-control" type="text" name="phone" id="phone" value="<?=$this->partInfo['p_telephone']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Моб. телефон</label>
                                            <input class="form-control" type="text" name="mobile" id="mobile" value="<?=$this->partInfo['p_mobile']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Контактный e-mail</label>
                                            <input class="form-control" type="text" name="email" id="email" value="<?=$this->partInfo['p_email']?>">
                                        </div>
           
                                  
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    
                               
                                  <div class="form-group">
                                       <label>Страна</label>
                                       <select class="form-control" onChange="selectCountry()" name="country" id="country">
                                       		<option value="-1">Выберите страну</option>
                                       		<option value="1" <? if($this->partInfo['p_country'] == 1):?>selected="selected"<?endif;?>>Украина</option>
                                       		<option value="2" <? if($this->partInfo['p_country'] == 2):?>selected="selected"<?endif;?>>Россия</option>
                                       </select>
                                  </div>
                             <!--  UKRAINE -->     
                                  <div id="country_1" <? if($this->partInfo['p_country'] != 1):?>style="display:none;" <?endif;?>>
                                  
                                     <div class="form-group">
                                            <label>Банк</label>
                                            <input class="form-control" type="text" name="bank" id="bank" value="<?=$this->partInfo['p_bank']?>">
                                     </div>
                                     <div class="form-group">
                                            <label>Тип счета</label>
                                       		<select class="form-control" name="bank_type" id="bank_type">
                                       			<option value="-1">Выберите тип счета</option>
                                       			<option value="1" <? if($this->partInfo['p_bank_type'] == 1):?>selected="selected"<?endif;?>>Счет</option>
                                       			<option value="2" <? if($this->partInfo['p_bank_type'] == 2):?>selected="selected"<?endif;?>>Карта</option>
                                       		</select>                                     
                                     </div>
                      				 <div class="form-group">
                                            <label>ФИО владельца</label>
                                            <input class="form-control" type="text" name="bank_name" id="bank_name" value="<?=$this->partInfo['p_bank_name']?>">
                                     </div> 
                      				 <div class="form-group">
                                            <label>Номер карты/счета</label>
                                            <input class="form-control" type="text" name="bank_number_ukr" id="bank_number_1" value="<?=$this->partInfo['p_bank_number']?>">
                                     </div>                   
                                  </div>
                                  
							<!--  RUSSIA -->
                                  <div id="country_2" <? if($this->partInfo['p_country'] != 2): ?>style="display:none;"<?endif;?>>
                                  
                                     <div class="form-group">
                                            <label>Номер счета WebMoney WMZ</label>
                                            <input class="form-control" type="text" name="bank_number_rus" id="bank_number_2" value="<?=$this->partInfo['p_bank_number']?>">
                                     </div>                  
                                  </div>                                  
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                             <div align="center">
                             	<button type="button" onClick="sendThisForm()" class="btn btn-outline btn-primary btn-lg btn-block">Сохранить информацию</button>
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

	function selectCountry()
	{
		country = $('#country').val();

		if (country == 1)
		{
			$('#country_2').hide();
			$('#country_1').show();
		}
		else if (country == 2)
		{
			$('#country_1').hide();
			$('#country_2').show();
		}
		else
		{
			$('#country_1').hide();
			$('#country_2').hide();
		}
	}

	function sendThisForm()
	{
		name = $('#p_name').val();
		director = $('#director').val();
		addr = $('#address').val();
		phone = $('#phone').val();
		mobile = $('#mobile').val();
		email = $('#email').val();
		country = $('#country').val();
		// bank
		// ukraine
		bank = $('#bank').val();
		type = $('#bank_type').val();
		b_name = $('#bank_name').val();
		// ukraine and russia
		b_numb = $('#bank_number_1').val();
		b_numb2 = $('#bank_number_2').val();

		if (name == '')
		{
			alert('Укажите название агенства');
			return;
		}

		if (director == '')
		{
			alert('Укажите ФИО директора агенства');
			return;
		}

		if (addr == '')
		{
			alert('Укажите адрес агенства');
			return;
		}

		if (phone == '')
		{
			alert('Укажите телефон агенства');
			return;
		}

		if (mobile == '')
		{
			alert('Укажите контактный мобильный телефон');
			return;
		}

		if (email == '')
		{
			alert('Укажите контактный e-mail');
			return;
		}

		if (country < 0)
		{
			alert('Выберите страну');
			return;
		}

		if (country == 1)
		{
			if (bank == '')
			{
				alert('Укажите название банка');
				return;
			}
			if (type < 0)
			{
				alert('Укажите тип счета');
				return;
			}
			if (b_name == '')
			{
				alert('Укажите владельца счета');
				return;
			}
			if (b_numb == '')
			{
				alert('Укажите номер карты/счета');
				return
			}
		}

		if (country == 2)
		{
			if (b_numb2 == '')
			{
				alert('Укажите номер карты/счета');
				return;
			}
		}

		$('#saveProfileForm').submit();
	}

</script>
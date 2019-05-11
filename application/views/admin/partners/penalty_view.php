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
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Новое штраф для партнера</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newPenalty" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">ID партера</label>
  								<div class="controls">
  									<?=$this->aModel->createPartnersList();?>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Сумма штрафа</label>
  								<div class="controls">
  									<input name="p_price" placeholder="Введите сумму штрафа" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
                                  <label class="control-label" for="optionsCheckbox">Сообщение</label>
                                   <div class="controls">
                                      <label class="uniform">
                                            <input class="uniform_on" type="checkbox" id="optionsCheckbox" value="1" name="p_is_msg">
                                              Прикрепить сообщение с пояснением штрафа?
                                      </label>
                                    </div>
                             </div>
  							
  							<div class="control-group">
  								<label class="control-label">Пояснение</label>
  								<div class="controls">
  									<textarea name="p_message" class="input-xlarge textarea" placeholder="Начните вводить сообщение..." style="width: 610px; height: 200px"></textarea>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addMessage();" class="btn btn-primary">Отправить</button>
  							
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
            
<script type="text/javascript">
	function addMessage()
	{
		if ($('select[name="p_id"]').val() == '-1')
		{
			alert('Выберите партнера');
			return;
		}

		if ($('input[name="p_price"]').val() == '')
		{
			alert('Введите сумму штрафа');
			return;
		}

		$('#newPenalty').submit();
	}
</script>

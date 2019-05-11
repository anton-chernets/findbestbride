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
                                <div class="muted pull-left">Добавление кредитов</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                <p class="alert alert-info">Чтобы снять кредиты, укажите нужное кол-во с минусом. Например, чтобы снять 10 кредитов, укажите -10.</p>
					<!-- BEGIN FORM-->
					<form action="" method="post" id="addCredits" class="form-horizontal">
					<input type="hidden" value="1" name="add">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">ID пользователя</label>
  								<div class="controls">
  									<?=$this->aModel->createMenList();?>
  								</div>
  							</div>

  							<div class="control-group">
  								<label class="control-label">Количество кредитов</label>
  								<div class="controls">
  									<input name="u_credits" placeholder="От -10 000 до 10 000" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addCredits();" class="btn btn-primary">Добавить / Снять</button>
  							
  							</div>
						</fieldset>
					</form>
					<div style="padding-bottom: 300px;"></div>
					<!-- END FORM-->
				</div>
			    </div>
			</div>
                     	<!-- /block -->
		    </div>

                </div>
            </div>
            
<script type="text/javascript">
	function addCredits()
	{
		if ($('select[name="u_id"]').val() == '-1')
		{
			alert('Выберите пользователя');
			return;
		}

		if ($('input[name="u_credits"]').val() == '')
		{
			alert('Укажите количество кредитов');
			return;
		}

		$('#addCredits').submit();
	}
</script>
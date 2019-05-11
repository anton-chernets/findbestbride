<div class="span9" id="content">
	<div class="row-fluid">
		<div class="block">
        	<div class="navbar navbar-inner block-header">
            	<div class="muted pull-left">Отчет по мужчине</div>
            </div>
            
            <div class="block-content collapse in">
            	<div class="span12">
					<form action="" method="post" id="newReport" class="form-horizontal">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Имя мужчины</label>
  								<div class="controls">
  									<?=$this->aModel->createMenList();?>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addReport();" class="btn btn-primary">Показать</button>
  								<div style="padding-bottom:300px;"></div>
  							</div>
						</fieldset>
					</form>
				</div><div style="height:150px;">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
</div>
            
<script type="text/javascript">
	function addReport()
	{
		if ($('select[name="u_id"]').val() == '-1')
		{
			alert('Выберите мужчину');
			return;
		}

		$('#newReport').submit();
	}
</script>
                <div class="span9" id="content">
                    <div class="row-fluid">
                         <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Формирование отчета по финансам партнера</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newReport" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">ID партнера</label>
  								<div class="controls">
  									<?=$this->aModel->createPartnersList();?>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Период с</label>
  								<div class="controls">
  									<input type="text" name="date_01" class="input-xlarge datepicker" id="date01" value="<?=date('m')?>/01/<?=date('Y')?>">
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">По</label>
  								<div class="controls">
  									<input name="date_02" type="text" class="input-xlarge datepicker" id="date01" value="01/01/<?=(date('Y') + 5)?>">
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addReport();" class="btn btn-primary">Сформировать</button>
  							
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
	function addReport()
	{
		if ($('select[name="p_id"]').val() == '-1')
		{
			alert('Выберите партнера');
			return;
		}

		$('#newReport').submit();
	}
</script>

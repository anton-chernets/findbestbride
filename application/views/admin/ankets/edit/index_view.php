                <div class="span9" id="content">

                    <div class="row-fluid">
                         <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Редактирование анкет</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="addCredits" class="form-horizontal">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">ID пользователя</label>
  								<div class="controls">
  									<?=$this->aModel->createUserList();?>
  								</div>
  							</div>


  						
  							<div align="center">
  								<button type="button" onClick="goToEdit();" class="btn btn-primary">Редактировать</button>
  							
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
					<br/><br/><br/><br/><br/><br/><br/>
					<div style="padding-bottom:200px;">&nbsp;</div>
				</div>
			    </div>
			</div>
                     	<!-- /block -->
		    </div>

                </div>
            </div>
            
<script type="text/javascript">
	function goToEdit()
	{
		user_id = $('select[name="u_id"]').val();
		
		if (user_id == '-1')
		{
			alert('Выберите пользователя');
			return;
		}

		window.location.href = '<?=base_url()?>admin/ank/edit/' + user_id;
	}
</script>

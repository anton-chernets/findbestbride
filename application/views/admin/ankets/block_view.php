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
                                <div class="muted pull-left">Заблокировать пользователя</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newBlock" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Пользователь</label>
  								<div class="controls">
  									<?=$this->aModel->createUserList();?>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="blockUser();" class="btn btn-primary">Заблокировать</button>
  							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
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
            	function blockUser()
            	{
					login = $('select[name="u_id"]').val();

					if (login == '-1')
					{
						alert('Выберите пользователя');
						return;
					}

					$('#newBlock').submit();
                }
            </script>

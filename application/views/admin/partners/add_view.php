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
                                <div class="muted pull-left">Новая учетная запись</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newPartner" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Логин</label>
  								<div class="controls">
  									<input type="text" name="n_p_login" class="span6 m-wrap"/>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Пароль</label>
  								<div class="controls">
  									<input name="n_p_pwd" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addPartner();" class="btn btn-primary">Добавить</button>
  							
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
            	function addPartner()
            	{
					login = $('input[name="n_p_login"]').val();
					pwd   = $('input[name="n_p_pwd"]').val();

					if (login == '' || pwd == '')
					{
						alert('Укажите логин и пароль');
						return;
					}

					$('#newPartner').submit();
                }
            </script>
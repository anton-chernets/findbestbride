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
                                <div class="muted pull-left">Новое сообщение для партнера</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newMessage" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Партнер</label>
  								<div class="controls">
  									<?=$this->aModel->createPartnersList();?>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Тема сообщения</label>
  								<div class="controls">
  									<input name="e_subject" placeholder="Введите тему" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Сообщение</label>
  								<div class="controls">
  									<textarea name="e_message" id="bootstrap-editor" placeholder="Начните вводить сообщение..." style="width:98%;height:200px;"></textarea>
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
		if ($('select[name="u_id"]').val() == '-1')
		{
			alert('Выберите пользователя');
			return;
		}

		if ($('input[name="e_subject"]').val() == '')
		{
			alert('Введите тему сообщения');
			return;
		}

		if ($('#bootstrap-editor').val() == '')
		{
			alert('Введите сообщение');
			return;
		}

		$('#newMessage').submit();
	}
</script>

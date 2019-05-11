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
                                <div class="muted pull-left">Новая рассылка</div>
                                <div align="right">
                                            <a href="<?=base_url()?>admin/email/mailing/old/" class="btn btn-warning">Архив рассылок</a>
                                            <p></p>                                                                                  
                               </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newMailing" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Кому отправляем</label>
  								<div class="controls">
  									<select name="email_to">
  										<option value="-1">Выберите...</option>
  										<option value="1">ВСЕМ пользователям</option>
  										<option value="2">Только ДЕВУШКАМ</option>
  										<option value="3">Только МУЖЧИНАМ</option>
  									</select>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Тема рассылки</label>
  								<div class="controls">
  									<input name="e_subject" placeholder="Введите тему" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Сообщение для рассылки</label>
  								<div class="controls">
  									<textarea name="e_message" id="bootstrap-editor" placeholder="Начните вводить сообщение..." style="width:98%;height:200px;"></textarea>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addMessage();" class="btn btn-primary">Отправить</button>
  								<a href="#myModal" onClick="showMe();" data-toggle="modal" class="btn btn-info">Предпросмотр</a>
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
					<div id="myModal" class="modal hide">
						<div class="modal-header">
							<button data-dismiss="modal" class="close" type="button">&times;</button>
							<h3>Сообщение для рассылки</h3>
						</div>
						<div class="modal-body" id="show">
							
						</div>
					</div>
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
		if ($('select[name="email_to"]').val() == '-1')
		{
			alert('Выберите адресатов');
			return;
		}

		if ($('input[name="e_subject"]').val() == '')
		{
			alert('Введите тему рассылок');
			return;
		}

		if ($('#bootstrap-editor').val() == '')
		{
			alert('Введите сообщение');
			return;
		}

		$('#newMailing').submit();
	}

	function showMe()
	{
		html = $('#bootstrap-editor').val();
		$('#show').html(html);
	}
</script>

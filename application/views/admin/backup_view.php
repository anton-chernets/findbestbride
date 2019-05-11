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
                                <div class="muted pull-left">Создание резервной копии</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" class="form-horizontal">
					<input type="hidden" value="1" name="back_up">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Куда копируем</label>
  								<div class="controls">
  									<select name="copy">
  										<option value="1">Сохранить на сервере</option>
  										<option value="2">Скачать на локальный компьютер</option>
  										<option value="3">Отправить на e-mail</option>
  									</select>
  								</div>
  							</div>
  								
  								<div class="control-group">
  								<label class="control-label"><i class="icon-info-sign tooltip-bottom" data-original-title="E-mail необходимо указывать, когда вы собираетесь отправлять резервную копию себе на e-mail."></i> E-mail</label>
  								<div class="controls">
  									<input name="email" placeholder="E-mail, куда отправлять" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="submit" class="btn btn-primary">Создать резервную копию</button>
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

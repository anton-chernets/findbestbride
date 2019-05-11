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
                                <div class="muted pull-left">Редактор страниц</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" class="form-horizontal">
					<input type="hidden" value="1" name="save">
						<fieldset>
  				
  							<div class="control-group">
  								<label class="control-label">Текст страницы</label>
  								<div class="controls">
  									<textarea name="page_text" id="bootstrap-editor" style="width:98%;height:400px;"><?=$page?></textarea>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="submit" class="btn btn-primary">Сохранить страницу</button>
  							
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


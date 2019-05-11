                <div class="span9" id="content">
           <? if(!empty($resInfo)): ?>
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
                                <div class="muted pull-left">Редактирование цен</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="sSettings" class="form-horizontal" enctype="multipart/form-data">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Название</label>
  								<div class="controls">
  									<strong><?php echo $info['name']; ?></strong>
  								</div>
  							</div>
							
							<div class="control-group">
  								<label class="control-label">Цена</label>
  								<div class="controls">
  									<input type="text" name="price[]" class="form-control" value="<?php echo $info['prices']; ?>">
  								</div>
  							</div>

  						
  							<div align="center">
  								<button type="submit" class="btn btn-primary">Сохранить настройки</button>
  							
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
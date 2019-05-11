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
                                <div class="muted pull-left">Основные настройки</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="sSettings" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" value="1" name="update">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Заголовок сайта</label>
  								<div class="controls">
  									<input type="text" value="<?=$this->engine['engine_title']?>" name="s_title" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Заголовок моб. версии</label>
  								<div class="controls">
  									<input type="text" value="<?=$this->engine['engine_mobile_title']?>" name="s_mob_title" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">E-mail поддержки</label>
  								<div class="controls">
  									<input name="s_email" value="<?=$this->engine['engine_email'];?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label"><i class="icon-info-sign tooltip-right" data-original-title="Максимальный размер фотографий и изображений, которые загружают на сайт пользователи и партнеры."></i> Максимальный размер фото (МБ)</label>
  								<div class="controls">
  									<input name="s_image" value="<?=$this->engine['engine_max_image'];?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Ключевые слова (meta keywords)</label>
  								<div class="controls">
  									<textarea name="s_keywords" id="s_keywords" class="input-xlarge textarea" style="width: 333px; height: 100px"><?=$this->engine['engine_keywords']?></textarea>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Описание (meta description)</label>
  								<div class="controls">
  									<input name="s_desc" value="<?=$this->engine['engine_description'];?>" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Запись логов</label>
  								<div class="controls">
  									<input name="s_logs" <? if($this->engine['engine_is_logs'] == 1):?>checked="checked"<?endif;?> type="checkbox" value="1" class="uniform_on"/>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label"><a href="<?=base_url()?>admin/first/backup/"><i class="icon-info-sign tooltip-right" data-original-title="Автоматическое создание резервных копий. В автоматическом режиме копия создается 1 раз в 3 дня. Нажав на эту ссылку вы можете создать копию немедленно."></i> Резервная копия сайта</a></label>
  								<div class="controls">
  									<input name="s_backup" <? if($this->engine['engine_is_backup'] == 1):?>checked="checked"<?endif;?> type="checkbox" value="1" class="uniform_on"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label"><i class="icon-info-sign tooltip-right" data-original-title="Этим переключателем вы можете включать и отключать панель управления для партнеров. Если она выключена - партнеры не смогут авторизироваться в ней."></i> Панель партнеров включена</label>
  								<div class="controls">
  									<input name="s_partner" <? if($this->engine['engine_is_partner'] == 1):?>checked="checked"<?endif;?> type="checkbox" value="1" class="uniform_on"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label"><i class="icon-info-sign tooltip-right" data-original-title="Будет накладываться на все новые загруженные фотографии."></i> Водянок знак</label>
  								<div class="controls">
  									<?php if(!empty($this->engine['engine_watermark'])) {?><img src="<?=base_url()?>content/img/<?=$this->engine['engine_watermark']?>"><br><br><?php } ?>
  									<input type="file" class="form-control" name="watermark" accept="image/*">
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="saveSettings();" class="btn btn-primary">Сохранить настройки</button>
  							
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
            	function saveSettings()
            	{
					title = $('input[name="s_title"]').val();
					mob_t = $('input[name="s_mob_title"]').val();
					email = $('input[name="s_email"]').val();
					image = $('input[name="s_image"]').val();
					desc  = $('input[name="s_desc"]').val();
					keyw  = $('#s_keywords').val();
					

					if (title == '' || email == '' || mob_t == '')
					{
						alert('Укажите заголовок сайта, мобильной версии и e-mail администратора');
						return;
					}

					if (image == '')
					{
						alert('Укажите максимальный размер загружаемых фотографий. Рекомендовано 12 МБ');
						return;
					}

					if (desc == '' || keyw == '')
					{
						alert('Укажите ключевые слова и описание сайта (meta tags)');
						return;
					}

					$('#sSettings').submit();
                }
            </script>
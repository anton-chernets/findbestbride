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
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->
					<form action="" method="post" id="newNews" class="form-horizontal">
					<input type="hidden" value="1" name="new">
						<fieldset>
  							<div class="control-group">
  								<label class="control-label">Тема рассылки</label>
  								<div class="controls">
  									<input name="p_subject" placeholder="Введите тему" type="text" class="span6 m-wrap"/>
  								</div>
  							</div>
  							
  							<div class="control-group">
  								<label class="control-label">Сообщение</label>
  								<div class="controls">
  									<textarea name="p_message" class="input-xlarge textarea" placeholder="Начните вводить сообщение..." style="width: 610px; height: 200px"></textarea>
  								</div>
  							</div>
  						
  							<div align="center">
  								<button type="button" onClick="addMessage();" class="btn btn-primary">Разослать</button>
  							
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
				</div>
			    </div>
			</div>
                     	<!-- /block -->
		    </div>
		    
		    
		    <div class="row-fluid">
                        <!-- block -->
                      <? if($list != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Архив рассылок</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Дата</th>
						                  <th>Тема</th>
						                  <th>Текст</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($list as $row): 
						              ?>
						                <tr id="n_<?=$row['news_id']?>">
						                  <td><?=date('d.m.Y', $row['news_date'])?></td>
						                  <td><?=$row['subject']?></td>
						                  <td><a href="#modal_<?=$row['news_id']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['news_id']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Текст рассылки</h3>
											</div>
											<div class="modal-body">
												<p><?=$row['message']?></p>
											</div>
										</div></td>
						                  <td><button onClick="deleteNews('<?=$row['news_id']?>');" class="btn btn-danger"><i class="icon-remove icon-white"></i> Удалить</button></td>
						                </tr>
						            <? endforeach; ?>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /block -->
                    <? else: ?>
                    	<div class="alert alert-block">
							<a class="close" data-dismiss="alert" href="#">&times;</a>
							<h4 class="alert-heading">Ошибка</h4>
							Нет подарков, которые необходимо проверить.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
<script type="text/javascript">

	function deleteNews(id)
	{
		$.ajax({
			url: '<?=base_url()?>admin/partners/news/',
			type: 'POST',
			dataType: 'json',
			data: { is_del: '1', id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#n_'+id).html('');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
	}
	function addMessage()
	{
		if ($('select[name="p_subject"]').val() == '-1')
		{
			alert('Введите тему рассылки');
			return;
		}

		if ($('input[name="p_message"]').val() == '')
		{
			alert('Введите сообщение');
			return;
		}

		$('#newNews').submit();
	}
</script>

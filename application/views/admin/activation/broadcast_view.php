          <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($broadcast != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Массовые рассылки, ожидающие активации</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Имя отправителя</th>
						                  <th>Сообщение</th>
						                  <th>Прикрепления</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($broadcast as $row): 
						              ?>
						                <tr id="b_<?=$row['user_id'].time();?>">
						                  <td><? $name = $this->mainModel->getUserProfile($row['user_id']); echo $name['name'] . ' ' . $name['lastname'] . '<br>' . '[' . $row['user_id'].']'; ?></td>
						                  <td><?=$row['message']?></td>
						                  <td><?php if ($row['attach'] != '') { ?><a href="<?=base_url()?>profiles/attachments/<?=$row['attach']?>_orig.jpg"><img src="<?=base_url()?>profiles/attachments/<?=$row['attach']?>_prev.jpg"></a><?php } ?>
						                  <td><button class="btn btn-success btn-mini" onClick="approve('<?=$row['user_id']?>', '<?=$row['user_id'].time()?>')">Подтвердить</button>&nbsp;<button onClick="cancel('<?=$row['user_id']?>', '<?=$row['user_id'].time()?>')" class="btn btn-danger btn-mini">Отказать</button></td>
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
							Нет массовых рассылок, ожидающих активацию.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(id, div)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/broadcast_approve/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#b_'+div).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }

            function cancel(id, div)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/broadcast_cancel/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#b_'+div).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }
      </script>

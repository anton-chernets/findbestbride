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
                      <? if($list != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Вопросы в техподдержку</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>E-mail</th>
						                  <th>Дата</th>
						                  <th>IP</th>
						                  <th>Тема</th>
						                  <th>Сообщение</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <?
						              	foreach($list as $row): 
						              ?>
						                <tr id="p_<?=$row['hash']?>">
						                  <td><?=$row['userMail']?></td>
						                  <td><?=date('d.m.Y', $row['date'])?></td>
						                  <td><?=$row['user_ip']?></td>
						                  <td><?=returnSupport($row['subject'])?></td>
						                  <td><?=$row['message']?></td>
						                  <td><? if($row['status'] == '0'): ?>
						                  
						                  <button onClick="check_c('<?=$row['hash']?>');" class="btn btn-info btn-mini">Отметить как выполненное</button>
						                  <? if($row['is_answer'] == 0):?><button class="btn btn-success btn-mini" onClick="answer('<?=$row['hash']?>');">Написать ответ</button><?endif;?>
						                  <? else: ?>
						                  
						                  <? endif; ?>
						                  </td>
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
							Запросов в техподдержку не поступало.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function check_c(hash)
            {
                $.ajax({
					url: '<?=base_url()?>admin/support/ajax/',
					type: 'POST',
					dataType: 'json',
					data: { hash: hash },
					success: function(obj) {
						if (obj.result == 'success') {
							$('#p_'+hash).html('');
						}
						else
						{
							alert(obj.message);
						}
					}
                });
            }

            function answer(hash)
            {
                window.location.href = '<?=base_url()?>admin/support/answer/'+hash;
            }
      </script>


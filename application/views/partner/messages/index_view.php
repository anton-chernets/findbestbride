        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Сообщения</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
       <? if ($msg != false): ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Тема сообщения</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? foreach ($msg as $row): ?>
                                        <tr id="id_<?=$row['hash']?>" <? if($row['is_read'] == 0):?>class="info"<?endif;?> title="Прочесть сообщение" style="cursor:pointer;">
                                            <td onClick="goReadMessage('<?=$row['hash']?>');"><?=date('d/m/Y', $row['msg_date'])?></td>
                                            <td onClick="goReadMessage('<?=$row['hash']?>');"><?=$row['subject']?></td>
                                            <td> <button type="button" onClick="goReadMessage('<?=$row['hash']?>');" title="Прочесть сообщение" class="btn btn-primary btn-circle"><i class="fa fa-check"></i>
                            				</button>
                            				<? if($row['is_read'] == 0): ?>
                            				<span id="r_b_<?=$row['hash']?>"><button type="button" onClick="markAsRead('<?=$row['hash']?>');" title="Отметить как прочитанное" class="btn btn-info btn-circle"><i class="fa fa-check"></i>
                           					</button></span>
                           					<? endif; ?>
                            				<button type="button" onClick="deleteMessage('<?=$row['hash']?>');" title="Удалить сообщение" class="btn btn-warning btn-circle"><i class="fa fa-times"></i>
                            				</button>
                            				</td>
                                        </tr>
                                    <? endforeach; ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
      <? else: ?>
      	     <div class="alert alert-warning">
               У вас нет сообщений.
             </div>
      <? endif; ?>
        </div>
        <!-- /#page-wrapper -->
        
        <script type="text/javascript">
        	function goReadMessage(hash)
        	{
            	window.location.href = "<?=base_url()?>partner/messages/read/" + hash;
        	}

        	function deleteMessage(hash)
        	{
        		$.ajax({
        			url: '<?=base_url()?>partner/messages/ajax/delete/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: hash },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#id_'+hash).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
        	}

        	function markAsRead(hash)
        	{
        		$.ajax({
        			url: '<?=base_url()?>partner/messages/ajax/mark_as_read/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: hash },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#r_b_'+hash).html('');
        					$('#id_'+hash).removeClass('info');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
        	}
        </script>
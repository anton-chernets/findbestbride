      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Акивные романтические туры</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
       <? if ($tour != false): ?>
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
                                            <th>ID тура</th>
                                            <th>Дата добавления</th>
                                            <th>Кол-во фото</th>
                                            <th>Статус</th>
                                            <th>Информация</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? foreach ($tour as $row):
 									$photo = $this->pModel->tourPhotoCount($row['photo_id']); 
 									?>
                                        <tr id="id_<?=$row['tour_id']?>" class="success">
                                            <td align="center"><?=$row['tour_id']?></td>
                                            <td align="center"><?=date('d.m.Y', $row['add_date'])?></td>
											<td align="center"><?=$photo?></td>
											<td align="center">Активен</td>
						                	<td align="center"><button type="button" onClick="window.location.href='<?=base_url()?>partner/tour/more/<?=$row['tour_id']?>';" class="btn btn-default">Просмотр</button></td>
						                	<td align="center"><button type="button" onClick="de_active('<?=$row['tour_id']?>');" title="Деактивировать" class="btn btn-danger btn-circle"><i class="fa fa-check"></i>
                            				</button>
                            				<button type="button" title="Изменить тур" onClick="window.location.href='<?=base_url()?>partner/tour/change/<?=$row['tour_id']?>';" class="btn btn-primary btn-circle"><i class="fa fa-list"></i>
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
               Романтических туров нет.
             </div>
      <? endif; ?>
        </div>
        <!-- /#page-wrapper -->
        
        <script>

        	function de_active(id)
        	{
        		$.ajax({
        			url: '<?=base_url()?>partner/tour/ajax/make_deactive/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#id_'+id).removeClass('success');
        					$('#id_'+id).addClass('danger');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
        	}
        </script>
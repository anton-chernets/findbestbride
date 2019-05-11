          <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($videos != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Видеопрезентации, ожидающие активации</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Агенство</th>
						                  <th>Имя/Фамилия</th>
						                  <th>Видео</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($videos as $row): 
						              		$agency_name = ($row['is_agency'] != 0) ? $this->aModel->getAgencyName($row['is_agency']) : '';
						              ?>
						                <tr id="v_<?=$row['id'].$row['add_date']?>">
						                  <td><? if (!empty($agency_name)) { ?>[<?=$row['is_agency']?>]<br/><?=$agency_name?><?php } ?></td>
						                  <td><?=$row['name']?><br/><?=$row['lastname']?></td>
						                  <td><a href="#modal_<?=$row['id'].$row['add_date']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['id'].$row['add_date']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Видео</h3>
											</div>
											<div class="modal-body">
												<div id="video_<?=str_replace('.mp4', '', $row['video_name']);?>">
													<video width="480" height="270" controls="controls">
														<source src="<?=base_url()?>profiles/video/user_<?=$row['id']?>/<?=$row['video_name']?>" type="<?=$row['mime_type']?>">
													</video> 
												</div>
											</div>
										</div></td>
						                  <td><button class="btn btn-success btn-mini" onClick="approve('<?=$row['video_name']?>', '<?=$row['id'].$row['add_date']?>')">Подтвердить</button>&nbsp;<button onClick="cancel('<?=$row['video_name']?>', '<?=$row['id'].$row['add_date']?>')" class="btn btn-danger btn-mini">Отказать</button></td>
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
							Нет видеопрезентаций, ожидающих активацию.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(id, div)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/video_approve/',
        			type: 'POST',
        			dataType: 'json',
        			data: { name: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#v_'+div).html('');
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
        			url: '<?=base_url()?>admin/activation/ajax/video_cancel/',
        			type: 'POST',
        			dataType: 'json',
        			data: { name: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#v_'+div).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }
      </script>

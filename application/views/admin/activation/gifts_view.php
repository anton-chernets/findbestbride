             <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                      <? if($gifts != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Подарки, ожидающие проверки</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Дата</th>
						                  <th>Подарок</th>
						                  <th>Агенство</th>
						                  <th>Фото</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($gifts as $row): 
						              	$agency_name = $this->aModel->getAgencyName($row['p_id']);
						              ?>
						                <tr id="g_<?=$row['gift_hash']?>">
						                  <td><?=date('d.m.Y', $row['add_date'])?></td>
						                  <td><?=$this->all_gifts->returnGiftName($row['gift']).$this->all_gifts->returnGiftCount($row['gift'], $row['count'])?></td>
						                  <td>[<?=$row['p_id']?>]<br/><?=$agency_name?></td>
						                  <td><a href="#modal_<?=$row['gift_hash']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['gift_hash']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Фотография</h3>
											</div>
											<div class="modal-body">
												<p><img src="<?=base_url()?>profiles/partner/p_<?=$row['p_id']?>/<?=$row['gift_image']?>.jpg"></p>
											</div>
										</div></td>
						                  <td><button class="btn btn-success btn-mini" onClick="approveGift('<?=$row['gift_hash']?>')">Подтвердить</button>&nbsp;<button onClick="cancelGift('<?=$row['gift_hash']?>')" class="btn btn-danger btn-mini">Отказать</button></td>
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
            function approveGift(hash)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/gift_approve/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: hash },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#g_'+hash).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }

            function cancelGift(hash)
            {
        		$.ajax({
        			url: '<?=base_url()?>admin/activation/ajax/gift_cancel/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: hash },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#g_'+hash).html('');
        				}
        				else
        				{
        					alert(obj.message);
        				}
        			}	
        		});
            }
      </script>
            
            
            
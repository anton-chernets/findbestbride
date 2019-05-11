 <div class="span9" id="content">
 <form action="" method="post">
 <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Штрафы партнеров</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                     
                                         Показывать с <input type="text" name="date_01" class="input-xlarge datepicker" id="date01" value="<?=date('m')?>/01/<?=date('Y')?>"> по <input name="date_02" type="text" class="input-xlarge datepicker" id="date01" value="01/01/<?=(date('Y') + 5)?>">
                                         <br/>Партнер <?=$this->aModel->createPartnersList();?>
                                      
                                      <div class="btn-group pull-right">
                                         <button type="submit" class="btn btn-primary">Показать</button>
                                      </div>
                                   </div>
                                  </form>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table table-striped">
						              <thead>
						                <tr>
						                  <th>Партнер</th>
						                  <th>Дата начисления</th>
						                  <th>Сумма</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? $amount = 0; 
						              foreach ($list as $row): 
						              	$amount += $row['count'];
						              ?>
						                <tr id="i_<?=$row['add_date']?>">
						                  <td>[<?=$row['p_id']?>] <?=$row['p_name']?></td>
						                  <td><?=date('d.m.Y', $row['add_date'])?></td>
						                  <td>$<?=$row['count']?></td>
						                  <td><button type="button" onClick="delete_penalty('<?=$row['p_id']?>', '<?=$row['add_date']?>');" class="btn btn-danger"><i class="icon-remove icon-white"></i> Удалить</button></td>
						                </tr>
						                <? endforeach; ?>
						              </tbody>
						            </table>
						            <div align="right">Итого: $<?=$amount?></div>
                                </div>
                            </div>
							<div style="margin-bottom: 300px;"></div>
                        </div>
                        <!-- /block -->
                    </div></div></div>
                    
                    <script>
                    	function delete_penalty(p_id, m_date)
                    	{
                    		$.ajax({
                    			url: '<?=base_url()?>admin/fin/ajax/delete_penalty/',
                    			type: 'POST',
                    			dataType: 'json',
                    			data: { id: p_id, m_date: m_date },
                    			success: function(obj) {
                    				if (obj.result == 'success') {
                    					$('#i_'+m_date).html('');
                    				}
                    				else
                    				{
                    					alert(obj.message);
                    				}
                    			}
                            });
                    	}
                    
                    </script>

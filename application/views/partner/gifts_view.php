      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Подарки</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
       <? if($resInfo != ''): ?>
          <div class="alert alert-<?if($resInfo['result'] == 'success'):?>success<?else:?>danger<?endif;?> alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?=$resInfo['text']?>
          </div>
       <? endif; ?>
       <? if ($gifts != false): ?>
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
                                            <th>От кого</th>
                                            <th>Кому</th>
                                            <th>Подарок</th>
                                            <th>Дата заказа</th>
                                            <th>Цена (кредиты)</th>
                                            <th>Статус</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? foreach ($gifts as $row): 
 										$from_info = $this->mainModel->getUserProfile($row['from_id']);
 										$to_info = $this->mainModel->getUserProfile($row['to_id']);
 									?>
                                        <tr id="id_<?=$row['gift_hash']?>" <? if($row['status'] == 0):?>class="danger"<?elseif($row['status'] == 2):?>class="warning"<?else:?>class="success"<?endif;?>>
                                            <td align="center">[<?=$row['from_id']?>]<br/><?=$from_info['name']?></td>
                                            <td align="center">[<?=$row['to_id']?>]<br/><?=$to_info['name']?></td>
											<td align="center"><?=$this->all_gifts->returnGiftName($row['gift']).$this->all_gifts->returnGiftCount($row['gift'], $row['count'])?></td>
											<td align="center"><?=date('d.m.Y H:i', $row['add_date'])?></td>
											<td align="center"><?=$row['price']?></td>
											<td align="center"><? if($row['status'] == 1):?>Доставлено<?elseif($row['status'] == 2):?>На проверке<?else:?>Не доставлено<?endif;?></td>
                                        	<td align="center"><? if($row['status'] == 0):?><button type="button" onClick="window.location.href='<?=base_url()?>partner/gifts/approve/<?=$row['gift_hash']?>';" title="Сообщить о доставке" class="btn btn-primary btn-circle"><i class="fa fa-check"></i>
                            				</button><?endif;?></td>
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
               	Нет подарков для отображения.
             </div>
      <? endif; ?>
        </div>
        <!-- /#page-wrapper -->
 
 <div class="span9" id="content">
 <form action="" method="post">
 <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Покупка кредитов мужчинами</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                     
                                         Показывать с <input type="text" name="date_01" class="input-xlarge datepicker" id="date01" value="<?=date('m')?>/01/<?=date('Y')?>"> по <input name="date_02" type="text" class="input-xlarge datepicker" id="date01" value="01/01/<?=(date('Y') + 5)?>">
                                      
                                      <div class="btn-group pull-right">
                                         <button type="submit" class="btn btn-primary">Показать</button>
                                      </div>
                                   </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table table-striped">
						              <thead>
						                <tr>
						                  <th># заказа</th>
						                  <th>Дата заказа</th>
						                  <th>Заказчик</th>
						                  <th>Статус</th>
						                  <th>Стоимость</th>
						                  <th>Кол-во кредитов</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? $amount = 0; 
						              foreach ($list as $row): 
						              	$amount += $row['amount'];
						              ?>
						                <tr class="<? if($row['order_status'] == 1):?>success<?else:?>error<?endif;?>">
						                  <td><?=$row['order_id']?></td>
						                  <td><?=date('d.m.Y', $row['order_date'])?></td>
						                  <td>[<?=$row['id']?>] <?=$row['name']?></td>
						                  <td><? if($row['order_status'] == 1):?>выполнено<?else:?>не выполнено<?endif;?></td>
						                  <td>$<?=$row['amount']?></td>
						                  <td><?=$row['credits']?></td>
						                </tr>
						                <? endforeach; ?>
						              </tbody>
						            </table>
						            <div align="right">Итого: $<?=$amount?></div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div></div></div></form></div></div>

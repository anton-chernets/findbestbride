<div class="span9" id="content">
 	<div class="alert alert-info">
		<button class="close" data-dismiss="alert">&times;</button>
		В верхней таблице показаны покупки кредитов мужчиной, в нижней - траты кредитов.
	</div>
 	<div class="row-fluid">
		 <div class="block">
			<div class="navbar navbar-inner block-header">
            	<div class="muted pull-left">Сформированный отчет</div>
            </div>
            <div class="block-content collapse in">
            	<div class="span12">
	                <div class="block-content collapse in">
                    	<div class="span12">
  							<table class="table table-striped">
						    	<thead>
						        	<tr>
						                <th>Дата</th>
						                <th>Сумма</th>
						                <th>Кредиты</th>
						            </tr>
						         </thead>
						         <tbody>
						         <? 
						         	$amount = 0;
						            $sell = 0; 
						            if (!empty($buy_list)) {
						            foreach ($buy_list as $row)
						            {
						              	$amount += $row['credits'];
						          
						          ?>
						          	<tr class="success">
						                <td><?=date('d.m.Y', $row['order_date']);?></td>
						                <td>$<?=$row['amount']?></td>
						                <td><?=$row['credits'];?></td>
						            </tr>
						          <? } ?>
						          <?php } else {?>
						          <tr>
						          	<td colspan="3"><span class="alert alert-warning">Еще не было куплено ни одного кредита</span></td>
						          </tr>
						          <?php } ?>
						          </tbody>
						       </table>
						       <br/><br/>
						       <table class="table table-striped">
						       	 <thead>
						                <tr>
						                  <th>Дата</th>
						                  <th>Кредиты</th>
						                  <th>Пояснение</th>
						                </tr>
						              </thead>
						              <tbody>
						              <?
						              if (!empty($sell_list)) {
						              	foreach ($sell_list as $row): 
						              		$sell += $row['count'];
						              	
					              	   ?>
						                <tr>
						                  <td><?=$row['date'];?></td>
						                  <td><?=$row['count']?></td>
						                  <td><?=$row['type']?></td>
						                </tr>
						                <? endforeach;
						                } else { ?>
						                <tr>
						                	<td colspan="3"><span class="alert alert-warning">Еще не было потрачено ни одного кредита</span></td>
						                </tr>
						                <?php } ?>
						              </tbody>
						            </table>
						            <div align="right">Итого куплено: <?=$amount?><br/>
						            	Итого потрачено: <?=$sell;?><br/>
						            	ИТОГО: <?=($amount - $sell)?>
						            </div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div></div></div></div></div>
 <div class="span9" id="content">
 <div class="alert alert-info">
	<button class="close" data-dismiss="alert">&times;</button>
	В верхней таблице показаны начисления, в нижней таблице показаны штрафы за указанный вами период. Под таблицами вы можете видеть общий итог заработанных денег партнером (начисления - штрафы).
</div>
 <div class="row-fluid">
 
                        <!-- block -->
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
						                  <th>Партнер</th>
						                  <th>Дата</th>
						                  <th>Тип</th>
						                  <th>Сумма</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? $amount = 0;
						              	$penalty = 0; 
						              foreach ($list as $row): 
						              	$amount += $row['m_price'];
						              	
						              	$p_name = $this->db->get_where('user_partner', array('id' => $row['partner_id']))->row_array();
						              ?>
						                <tr class="success">
						                  <td>[<?=$row['partner_id']?>] <?=$p_name['p_name']?></td>
						                  <td><?=date('d.m.Y', $row['m_date']);?></td>
						                  <td>начисление</td>
						                  <td>$<?=$row['m_price'];?></td>
						                </tr>
						                <? endforeach; ?>
						              </tbody>
						            </table>
						            <br/><br/>
						            <table class="table table-striped">
						              <thead>
						                <tr>
						                  <th>Партнер</th>
						                  <th>Дата</th>
						                  <th>Тип</th>
						                  <th>Сумма</th>
						                </tr>
						              </thead>
						              <tbody>
						              <?
						              foreach ($pen as $row): 
						              	$penalty += $row['count'];
						              	
						              	$p_name = $this->db->get_where('user_partner', array('id' => $row['p_id']))->row_array();
						              ?>
						                <tr class="error">
						                  <td>[<?=$row['p_id']?>] <?=$p_name['p_name']?></td>
						                  <td><?=date('d.m.Y', $row['add_date']);?></td>
						                  <td>штраф</td>
						                  <td>$<?=$row['count'];?></td>
						                </tr>
						                <? endforeach; ?>
						              </tbody>
						            </table>
						            <div align="right">Итого начислений: $<?=$amount?><br/>
						            	Итого штрафов: $<?=$penalty;?><br/>
						            	ИТОГО: $<?=($amount - $penalty)?>
						            </div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div></div></div>
                  

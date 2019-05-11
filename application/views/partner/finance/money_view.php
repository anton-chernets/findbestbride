      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Начисления</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
       <? if ($money != false): ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Начисления за текущий месяц
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Мужчина</th>
                                            <th>Девушка</th>
                                            <th>Название</th>
                                            <th>Комментарий</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? $sum = 0;
 									foreach ($money as $row): 
 										$sum += $row['m_price'];
 										$man = $this->mainModel->getUserProfile($row['from_man']);
 										$women = $this->mainModel->getUserProfile($row['from_girl']);
 									?>
                                        <tr>
                                            <td align="center"><?=date('d.m.Y H:i', $row['m_date'])?></td>
                                            <td align="center">[<?=$row['from_man']?>]<br/><?=$man['name']?></td>
                                            <td align="center">[<?=$row['from_girl']?>]<br/><?=$women['name']?></td>
                                            <td align="center"><?=$row['m_name']?></td>
                                            <td align="center"><?=$row['m_message']?></td>
											<td align="center">$<?=$row['m_price']?></td>
							            </tr>
                                    <? endforeach; ?>
                                    </tbody>
                                </table>
                                <div align="right"><b>Итого:</b> $<?=$sum?><br/>Данные обновляются один раз в час</div>
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
               	За текущий месяц начислений нет.
             </div>
      <? endif; ?>
      
      
             <? if ($old != false): ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Начисления за предыдущие месяцы (архив)
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Мужчина</th>
                                            <th>Девушка</th>
                                            <th>Название</th>
                                            <th>Комментарий</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? $sum = 0;
 									foreach ($old as $row): 
 										$sum += $row['m_price'];
 										$man = $this->mainModel->getUserProfile($row['from_man']);
 										$women = $this->mainModel->getUserProfile($row['from_girl']);
 									?>
                                        <tr>
                                            <td align="center"><?=date('d.m.Y H:i', $row['m_date'])?></td>
                                            <td align="center">[<?=$row['from_man']?>]<br/><?=$man['name']?></td>
                                            <td align="center">[<?=$row['from_girl']?>]<br/><?=$women['name']?></td>
                                            <td align="center"><?=$row['m_name']?></td>
                                            <td align="center"><?=$row['m_message']?></td>
											<td align="center">$<?=$row['m_price']?></td>
							            </tr>
                                    <? endforeach; ?>
                                    </tbody>
                                </table>
                                <div align="right"><b>Итого:</b> $<?=$sum?></div>
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
               	Ваш архив начислений пуст.
             </div>
      <? endif; ?>
        </div>
        <!-- /#page-wrapper -->

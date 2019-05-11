      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Начисленные штрафы</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
       <? if ($penalty != false): ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Штрафы за текущий месяц
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? $sum = 0;
 									foreach ($penalty as $row): 
 										$sum += $row['count'];
 									?>
                                        <tr>
                                            <td align="center"><?=date('d.m.Y H:i', $row['add_date'])?></td>
                                            <td align="center"><?=$row['comment']?></td>
											<td align="center">$<?=$row['count']?></td>
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
               	За текущий месяц штрафов нет.
             </div>
      <? endif; ?>
      
      
      
             <? if ($old != false): ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Штрафы за предыдущие месяцы (архив)
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 									<? $sum = 0;
 									foreach ($old as $row): 
 										$sum += $row['count'];
 									?>
                                        <tr>
                                            <td align="center"><?=date('d.m.Y H:i', $row['add_date'])?></td>
                                            <td align="center"><?=$row['comment']?></td>
											<td align="center">$<?=$row['count']?></td>
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
               	За текущий месяц штрафов нет.
             </div>
      <? endif; ?>
        </div>
        <!-- /#page-wrapper -->
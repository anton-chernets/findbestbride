               <div class="span9" id="content">

                    <div class="row-fluid">
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Последние пользователи</div>
                                    <div class="pull-right"><span class="badge badge-info"><?=$uCount?></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Имя</th>
                                                <th>Агенство</th>
                                                <th>Статус</th>
                                            </tr>
                                        </thead>
                                        <? if($lastUser != false): ?>
                                        <tbody>
                                        <? foreach ($lastUser as $row): ?>
                                            <tr>
                                                <td><?=$row['id']?></td>
                                                <td><?=$row['name']?> <?=$row['lastname']?></td>
                                                <td><? if($row['is_agency'] != 0): echo $row['is_agency']; else:?>Нет<?endif;?></td>
												<td><span class="label label-<?if($row['user_status'] == 0):?>success<?else:?>important<?endif;?>"><?if($row['user_status'] == 0):?>активир.<?else:?>не активир.<?endif;?></span></td>
											</tr>
                                        <? endforeach; ?>
                                        </tbody>
                                       <? endif; ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Последние пополнения</div>
                                    <div class="pull-right"><!--<span class="badge badge-info">$<?=$fCount?>--></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                            	<th>Мужчина</th>
                                                <th>#</th>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Статус</th>
                                            </tr>
                                        </thead>
                                        <? if($lastPays != false): ?>
                                        <tbody>
                                        <? foreach ($lastPays as $row): ?>
                                            <tr>
                                            	<td><?=$row['id'];?></td>
                                                <td><?=$row['order_id']?></td>
                                                <td><?=date('d.m.Y H:i', $row['order_date'])?></td>
                                                <td><?=$row['amount'];?></td>
                                                <td><span class="label label-<?if($row['order_status'] == 1):?>success<?else:?>important<?endif;?>"><?if($row['order_status'] == 1):?>проведен<?else:?>отказ<?endif;?></span></td>
                                            </tr>
                                        <? endforeach; ?>
                                        </tbody>
                                        <? endif; ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        
                        
                    </div>
                    
                    <div class="row-fluid">
                        <!--<div class="span6">
                            
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Журнал событий</div>
                                    <div class="pull-right"><span class="badge badge-info"><?=$lCount?></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Тип</th>
                                                <th>Дата</th>
                                                <th>Комментарий</th>
                                            </tr>
                                        </thead>
                                        <? if($lastLogs != false): ?>
                                        <tbody>
                                        <? foreach ($lastLogs as $row): ?>
                                            <tr>
                                                <td><?=$row['user_id']?></td>
                                                <td><? if($row['log_type'] == 1):?>анкета<?else:?>партнер<?endif;?></td>
                                                <td><?=$row['log_date']?></td>
                                                <td><?=$row['comment']?></td>
                                            </tr>
                                        <? endforeach; ?>
                                        </tbody>
                                        <? endif; ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        <!-- <div class="span6">
                            
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Последние пополнения</div>
                                   

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>№ заказа</th>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Статус</th>
                                            </tr>
                                        </thead>
                                        <? if($lastPays != false): ?>
                                        <tbody>
                                        <? foreach ($lastPays as $row): ?>
                                            <tr>
                                                <td><?=$row['id']?></td>
                                                <td><?=$row['order_id']?></td>
                                                <td><?=date('d.m.Y H:i', $row['order_date'])?></td>
                                                <td>$<?=$row['amount']?></td>
                                                <td><span class="label label-<?if($row['order_status'] == 1):?>success<?else:?>important<?endif;?>"><?if($row['order_status'] == 1):?>проведен<?else:?>отказ<?endif;?></span></td>
                                            </tr>
                                        <? endforeach; ?>
                                        </tbody>
                                        <? endif; ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                    </div>
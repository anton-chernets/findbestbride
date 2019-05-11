 <div class="span9" id="content">
 <? if($list == false): ?>
 <div class="alert">
	<button class="close" data-dismiss="alert">&times;</button>
	Нет логов для отображения.
</div>
<? else: ?>
 	<div class="row-fluid">
 	
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список логов</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                      
                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>ID анкеты</th>
                                                <th>Партнер</th>
                                                <th>Комментарий</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): 
                                      
													$name = $this->mainModel->getUserProfile($row['user_id']);
												
                                        	?>
                                            <tr class="odd gradeA">
                                  
                                                <td><?=$row['log_date']?></td>
                                                <td><?=$row['user_id']?><br/>[<?=$name['name']?> <?=$name['lastname']?>]</td>
                                                <td><? if($name['is_agency'] > 0): echo $name['is_agency'] . ' [' . $this->aModel->getPartnerName($name['is_agency']) . ']';  endif; ?>
                                                <td><?=$row['comment']?></td>
                                                
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div><? endif; ?></div></div>

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
                                                <th>ID партнера</th>
                                                <th>Комментарий</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): 
                                      
												$name = $this->aModel->getPartnerName($row['user_id']);
												
                                        	?>
                                            <tr class="odd gradeA">
                                  
                                                <td><?=$row['log_date']?></td>
                                                <td><?=$row['user_id']?><br/>[<?=$name?>]</td>
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


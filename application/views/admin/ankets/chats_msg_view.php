 
 <div class="span9" id="content">
	<form action="" method="POST">
		<div class="row-fluid">
 	
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список анкет</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>Отправитель</th>
                                                <th>Сообщение</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): 
                                        		$user = $this->mainModel->getUserProfile($row['from_id']);
                                        	?>
                                            <tr class="odd gradeA">
                                                <td>[<?=$row['from_id']?>]<br><?=$user['name']?></td>
                                                <td><?=$row['message']?></td>
                                              </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div></form></div></div>

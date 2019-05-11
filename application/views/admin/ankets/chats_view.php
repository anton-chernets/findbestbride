<div class="span9" id="content">
		<div class="row-fluid">
 	
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список чатов</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">

                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>Создатель</th>
                                                <th>Второй участник</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): 
                                        		$user1 = $this->mainModel->getUserProfile($row['user_1']);
                                        		$user2 = $this->mainModel->getUserProfile($row['user_2']);
                                        	?>
                                            <tr class="odd gradeA">
                                                <td>[<?=$row['user_1']?>]<br><?=$user1['name']?></td>
                                                <td>[<?=$row['user_2']?>]<br><?=$user2['name']?></td>
                                                <td> <a href="<?=base_url()?>admin/ank/chat_msg/<?=$row['chat_name']?>" class="btn btn-primary">Читать сообщения</a></td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div></div></div>

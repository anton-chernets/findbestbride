 
 <div class="span9" id="content">
		<div class="row-fluid">
 	
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список заблокированных анкет</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">

                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Имя</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): ?>
                                            <tr class="odd gradeA">
                                                <td><?=$row['id']?></td>
                                                <td><?=$row['name']?> <?=$row['lastname']?></td>
                                                <td> <a href="/admin/ank/b_un/<?=$row['id']?>" class="btn btn-success"><i class="icon-ok icon-white"></i> Разблокировать</a></td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div></div></div>
            </div>

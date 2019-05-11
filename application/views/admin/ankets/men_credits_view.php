<div class="span9" id="content">
	<form action="" method="POST">
		<div class="row-fluid">
 	
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Кредиты у мужчин</div>
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
                                                <th>E-mail</th>
                                                <th>Кредиты</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): ?>
                                            <tr class="odd gradeA">
                                                <td><?=$row['id']?></td>
                                                <td><?=$row['name']?></td>
                                                <td><?=$row['email']?></td>
                                                <td><strong><?=$row['credits']?></strong></td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div></form></div></div>

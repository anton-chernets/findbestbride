 <script type="text/javascript">
	$(document).ready(function() {
		$('#sort').change(function() {
			window.location.href = '/admin/ank/all/' + $('#sort_sex').val() + '/' + $('#sort').val();
		});
		
		$('#sort_sex').change(function() {
			window.location.href = '/admin/ank/all/' + $('#sort_sex').val() + '/' + $('#sort').val();
		});
	});
</script>
 
 
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
                                  	 Партнер <?=$this->aModel->createPartnersList();?>
                                      
                                      <div class="btn-group pull-right">
                                         <button type="submit" class="btn btn-primary">Показать</button>
                                      </div>
									  <br><br>
									  <select class="form-control" id="sort_sex">
										<option value="0" <?php if($this->uri->segment(4) == 0) { ?>selected="selected"<?php } ?>>Мужчины и девушки</option>
										<option value="1" <?php if($this->uri->segment(4) == 1) { ?>selected="selected"<?php } ?>>Только мужчины</option>
										<option value="2" <?php if($this->uri->segment(4) == 2) { ?>selected="selected"<?php } ?>>Только девушки</option>
									  </select>
									  &nbsp;&nbsp;
									  <select class="form-control" id="sort">
										<option value="">Сортировка</option>
										<option value="1" <?php if($this->uri->segment(5) == 1) { ?>selected="selected"<?php } ?>>Активные</option>
										<option value="2" <?php if($this->uri->segment(5) == 2) { ?>selected="selected"<?php } ?>>Не активные</option>s
										<option value="5" <?php if($this->uri->segment(5) == 5) { ?>selected="selected"<?php } ?>>Онлайн</option>
										<option value="6" <?php if($this->uri->segment(5) == 6) { ?>selected="selected"<?php } ?>>Оффлайн</option>
									</select>
                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Имя</th>
                                                <th>Партнер</th>
                                                <!--<th>Дата регистрации</th>-->
                                                <th>E-mail</th>
                                                <th>Редактировать</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): ?>
                                            <tr class="odd gradeA" id="a_<?=$row['id'];?>">
                                                <td><?=$row['id']?></td>
                                                <td><?=$row['name']?> <?=$row['lastname']?></td>
                                                <td><? if($row['is_agency'] > 0): echo $row['is_agency'] . ' [' . $this->aModel->getPartnerName($row['is_agency']) . ']'; endif; ?>
                                                
                                                <td><?=$row['email']?></td>
                                                <td> <a href="<?=base_url()?>admin/ank/edit/<?=$row['id']?>" class="btn btn-warning"><i class="icon-edit icon-white"></i> Редактировать</a>
													<br><br>
													<a href="javascript:;" onClick="deleteFromList(<?=$row['id']?>);" class="btn btn-danger"><i class="icon-trash icon-white"></i> Скрыть</a>
												</td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div></form></div></div>

<script type="text/javascript">
	function deleteFromList(id)
	{
		$.post('/admin/ank/unlist', { id: id });
		$('#a_' + id).remove();
	}
</script>	

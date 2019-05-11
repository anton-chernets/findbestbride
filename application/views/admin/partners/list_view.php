 
 <div class="span9" id="content">
 <? if($list == false): ?>
 <div class="alert">
	<button class="close" data-dismiss="alert">&times;</button>
	Нет партнеров для отображения.
</div>
<? else: ?>
 	<div class="row-fluid">
 	
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список партнеров</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                      <div class="btn-group">
                                         <a href="<?=base_url()?>admin/partners/add/"><button class="btn btn-success"><i class="icon-plus icon-white"></i> Добавить нового партнера</button></a>
                                      </div>
                                      <br><br>
									  <select class="form-control" id="sorting" onChange="sort();">
										<option value="0">Сортировать по статусу</option>
										<option value="1" <?php if ($this->uri->segment(4) == 1) { ?>selected="selected"<?php } ?>>Показать активных</option>
										<option value="2" <?php if ($this->uri->segment(4) == 2) { ?>selected="selected"<?php } ?>>Показать не активных</option>
									  </select>
                                   </div>
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>ID агенства</th>
                                                <th>Название</th>
                                                <th>Логин</th>
                                                <th>Кол-во анкет</th>
                                                <th>Статус</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): ?>
                                            <tr class="odd gradeA">
                                                <td><?=$row['id']?></td>
                                                <td><? if($row['p_name'] != ''): echo $row['p_name']; else: ?>не указано<?endif;?></td>
                                                <td><?=$row['p_login']?></td>
                                                <td align="center"><?=$this->aModel->getPartnerCountProfiles($row['id'])?></td>
                                                <td class="center"><? if($row['p_status'] == 0):?><span class="label label-important">отключен</span><?elseif ($row['p_status'] == 1):?><span class="label label-warning">на проверке</span><?else:?><span class="label label-success">активен</span><?endif;?></td>
                                                <td class="center"><? if($row['p_status'] == 0): ?><button onClick="setActive('<?=$row['id']?>');" class="btn btn-success"><i class="icon-ok icon-white"></i> Включить</button>
                                                	<? elseif ($row['p_status'] == 2):?>
                                                	<button onClick="setDeactive('<?=$row['id']?>');" class="btn btn-danger"><i class="icon-remove icon-white"></i> Отключить</button>
                                                	<? endif; ?>
                                                </td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
</div><? endif; ?></div></div>
<script>
	function setDeactive(id)
	{
		$.ajax({
			url: '<?=base_url()?>admin/partners/index/',
			type: 'POST',
			dataType: 'json',
			data: { is_deactive: '1', id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					alert('Партнер успешно отключен');
				}
				else
				{
					alert(obj.message);
				}
			}
        });
	}

	function setActive(id)
	{
		$.ajax({
			url: '<?=base_url()?>admin/partners/index/',
			type: 'POST',
			dataType: 'json',
			data: { is_active: '1', id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					alert('Партнер успешно активирован');
				}
				else
				{
					alert(obj.message);
				}
			}
        });
	}
	
	function sort() {
		window.location.href = '/admin/partners/index/' + $('#sorting').val();
	}
</script>
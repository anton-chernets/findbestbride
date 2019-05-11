 
 <div class="span9" id="content">

 	<div class="row-fluid">
 		<? if($list != false): ?>
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Список анкет</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   
                                    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID анкеты</th>
                                                <th>Имя</th>
                                                <th>E-mail</th>
                                                <th>Дата регистрации</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach ($list as $row): ?>
                                            <tr id="a_<?=$row['id']?>">
                                                <td><?=$row['id']?></td>
                                                <td><?=$row['name']?> <?=$row['lastname']?></td>
                                                <td><?=$row['email']?></td>
                                                <td><?=date('d.m.Y H:i', $row['register_date'])?></td>
                                                <td><div class="btn-group">
										  <button class="btn">Выбрать</button>
										  <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
										  <ul class="dropdown-menu">
											<li><a href="#" onClick="activateAnket('<?=$row['id']?>')">Активировать</a></li>
											<li class="divider"></li>
											<li><a href="#" onClick="sendEmail('<?=$row['id']?>')">Отправить повторно</a></li>
											<li class="divider"></li>
											<li><a href="#" onClick="deleteAnket('<?=$row['id']?>')">Удалить анкету</a></li>
										  </ul>
										</div></td>
                                            </tr>
                                            <? endforeach; ?>
                                        
                                        </tbody>
                                        
                                    </table>
                                     <br/><br/><br/><br/><br/><br/><br/>
                                </div>
                            </div>
                           
                        </div>
                        <!-- /block -->
                        <? else: ?>
                    	<div class="alert alert-block">
							<a class="close" data-dismiss="alert" href="#">&times;</a>
							<h4 class="alert-heading">Ошибка</h4>
							Не активированных анкет нет.
						</div>
					<? endif; ?>
</div></div></div>

<script>
	function deleteAnket(id)
	{
		if (confirm('Вы уверены, что хотите удалить анкету #'+id+'?') == true)
		{
			$.ajax({
    			url: '<?=base_url()?>admin/ank/not_activated/delete/',
    			type: 'POST',
    			dataType: 'json',
    			data: { id: id },
    			success: function(obj) {
    				if (obj.result == 'success') {
        				alert('Анкета удалена.');
    					$('#a_'+id).html('');
    				}
    				else
    				{
    					alert(obj.message);
    				}
    			}	
    		});
		}
	}

	function activateAnket(id)
	{
		$.ajax({
			url: '<?=base_url()?>admin/ank/not_activated/activate/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
    				alert('Анкета активирована. Пользователь может заходить на сайт под своим именем.');
					$('#a_'+id).html('');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
	}

	function sendEmail(id)
	{
		$.ajax({
			url: '<?=base_url()?>admin/ank/not_activated/re_email/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
    				alert('Пользователю повторно отправлено сообщение с регистрационными данными на e-mail.');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
	}
</script>
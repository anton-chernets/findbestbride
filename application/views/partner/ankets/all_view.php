     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Все анкеты Вашего агенства</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
     <? if($profiles != false): 
     		$i = 0;
     		echo '<div class="row">';
     		foreach ($profiles as $row):
     		$i++;
     		
     		if ($i%3 == 1 && $i > 0)
     		{
     			echo '</div><div class="row">';
     		}
     		
     		$isOnline = '';
     		
     		if ($row['user_status'] == 0)
     		{
     			if ($row['last_online'] >= time())
     			{
     				$isOnline = '<br/><strong>Online</strong>';
     			}
     		}
     ?>
     			
                <div class="col-lg-4" id="women_<?=$row['id']?>">
                    <div id="w_<?=$row['id']?>" class="panel panel-<?if($row['user_status'] == 0):?>success<?elseif($row['user_status']==1):?>danger<?elseif($row['user_status']==3):?>warning<?endif;?>">
                        <div class="panel-heading">
                            <?=$row['name']?> <?=$row['lastname']?> (<? if($row['user_status'] == 0):?>активна<?elseif ($row['user_status'] == 3):?>на рассмотрении<?elseif ($row['user_status'] == 1):?>отключена<?endif;?>)
                        	<?=$isOnline?>
							<br>Login: <?=$row['email'];?>
							<br>Password: <?=$row['pw'];?>
							<br>ID: <?=$row['id'];?>
                        </div>
                        <div class="panel-body">
                            <p align="center"><? if($row['photo_link'] == ''): ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><?else:?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><?endif;?></p>
                        </div>
                        <div class="panel-footer">
                            <? if($row['user_status'] == 0):?><a href="#." onClick="disable('<?=$row['id']?>');">Отключить анкету</a>
							 <? elseif($row['user_status'] == 3):?><a href="#." onClick="cancel('<?=$row['id']?>');">Отменить заявку</a>
                            <? elseif ($row['user_status'] == 1):?><a href="#." onClick="approve('<?=$row['id']?>');">Активировать анкету</a>
                            <? endif; ?>
                            <br/><a href="/partner/ankets/profile/<?=$row['id']?>">Изменить профиль</a><br>
                            <a href="/partner/ankets/avatar/<?=$row['id']?>">Изменить аватар</a><br/>
                            <a href="/partner/ankets/photos/<?=$row['id']?>">Фотографии</a><br/>
                            <a href="/partner/ankets/video/<?=$row['id']?>">Видеопрезентация</a> 
							<br><a href="javascript:;" onClick="if(confirm('Вы уверены, что хотите удалить этот профиль? Он будет полностью удален без возможности возвращения')) window.location.href='/partner/ankets/delete/<?=$row['id']?>';"><strong>Удалить профиль</strong></a>

                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
     <? 
     endforeach; echo "</div>";
     else: ?>
          <div class="alert alert-warning">
               	Анкет нет.
         </div>
      <? endif; ?>
   </div>
   
   <script type="text/javascript">
   	function disable(id)
   	{
		$.ajax({
			url: '<?=base_url()?>partner/ankets/ajax/disable/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#w_'+id).removeClass('panel panel-success');
					$('#w_'+id).addClass('panel panel-danger');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
   	}

   	function cancel(id)
   	{
		$.ajax({
			url: '<?=base_url()?>partner/ankets/ajax/cancel_approve/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#w_'+id).removeClass('panel panel-warning');
					$('#w_'+id).addClass('panel panel-danger');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
   	}

   	function approve(id)
   	{
		$.ajax({
			url: '<?=base_url()?>partner/ankets/ajax/add_to_active/',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#w_'+id).removeClass('panel panel-danger');
					$('#w_'+id).addClass('panel panel-warning');
					alert(obj.message);
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
   	}
   </script>
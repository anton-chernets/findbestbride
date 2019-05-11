     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Анкеты онлайн</h1>
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
     		 
     		
     		if ($row['last_online'] >= time())
     		{
     			$isOnline = '<br/><strong>Online</strong>';
     		}
     ?>
     			
                <div class="col-lg-4" id="women_<?=$row['id']?>">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <?=$row['name']?> <?=$row['lastname']?>
                            <?=$isOnline?>
							<br>Login: <?=$row['email'];?>
							<br>Password: <?=$row['pw'];?>
							<br>ID: <?=$row['id'];?>
                        </div>
                        <div class="panel-body">
                            <p align="center"><? if($row['photo_link'] == ''): ?><img src="<?=base_url()?>content/img/nophoto-mini.png"><?else:?><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_100.jpg"><?endif;?></p>
                        </div>
                        <div class="panel-footer">
                             <a href="#." onClick="disable('<?=$row['id']?>');">Отключить анкету</a>
                            <br/><a href="/partner/ankets/profile/<?=$row['id']?>">Изменить профиль</a><br>
                            <a href="/partner/ankets/avatar/<?=$row['id']?>">Изменить аватар</a><br/>
                            <a href="/partner/ankets/photos/<?=$row['id']?>">Фотографии</a><br/>
                            <a href="/partner/ankets/video/<?=$row['id']?>">Видеопрезентация</a>
							<br><a href="javascript:;" onClick="if(confirm('Вы уверены, что хотите удалить этот профиль? Он будет полностью удален без возможности возвращения')) window.location.href='<?=base_url()?>partner/ankets/delete/<?=$row['id']?>';"><strong>Удалить профиль</strong></a>

                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
     <? 
     endforeach; echo "</div>";
     else: ?>
          <div class="alert alert-warning">
               	Нет анкет, которые находятся онлайн.
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
					$('#women_'+id).html('');
				}
				else
				{
					alert(obj.message);
				}
			}	
		});
   	}
   </script>

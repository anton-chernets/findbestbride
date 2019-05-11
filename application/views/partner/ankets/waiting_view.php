     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Анкеты в ожидании активации</h1>
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
     ?>
     			
                <div class="col-lg-4" id="women_<?=$row['id']?>">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <?=$row['name']?> <?=$row['lastname']?>\
							<br>Login: <?=$row['email'];?>
							<br>Password: <?=$row['pw'];?>
							<br>ID: <?=$row['id']?>
                        </div>
                        <div class="panel-body">
                            <p align="center"><img src="<?=base_url()?>content/img/nophoto-mini.png"></p>
                        </div>
                        <div class="panel-footer">
                            <a href="#." onClick="cancel('<?=$row['id']?>');">Отменить заявку</a>
							<br><a href="javascript:;" onClick="if(confirm('Вы уверены, что хотите удалить этот профиль? Он будет полностью удален без возможности возвращения')) window.location.href='<?=base_url()?>partner/ankets/delete/<?=$row['id']?>';"><strong>Удалить профиль</strong></a>

                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
     <? 
     endforeach; echo "</div>";
     else: ?>
          <div class="alert alert-warning">
               	Анкет, ожидающих активации, нет.
         </div>
      <? endif; ?>
   </div>
   
   <script type="text/javascript">
   	function cancel(id)
   	{
		$.ajax({
			url: '<?=base_url()?>partner/ankets/ajax/cancel_approve/',
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
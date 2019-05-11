     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Загрузка фотографий</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
     <? if($photo != false): 
     		$i = 0;
     		echo '<div class="row">';
     		foreach ($photo as $row):
     		$i++;
     		
     		if ($i%4 == 0 && $i > 0)
     		{
     			echo '</div><div class="row">';
     		}
     ?>
     			
                <div class="col-lg-4" id="p_<?=$row['photo_name']?>">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                           Фотография
                        </div>
                        <div class="panel-body">
                            <p align="center"><img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$row['photo_name']?>_170.jpg"></p>
                        </div>
                        <div class="panel-footer">
                            <a href="#." onClick="deletePhoto('<?=$row['photo_name']?>', '<?=$info['id']?>');">Удалить фотографию</a>
                            
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
     <? 
     endforeach; echo "</div>";
     else: ?>
          <div class="alert alert-warning">
               	Фотографий еще нет.
         </div>
      <? endif; ?>
      
                  <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">

                <div class="col-lg-6">
                <form action="" method="post" id="new_photo" enctype="multipart/form-data">
                <input type="hidden" value="1" name="new"/>
                <input type="hidden" value="<?=$info['id']?>" name="u_id"/>
                    		<div class="form-group">
                                        <label>Новая фотография (только формат .jpg, размер до 10 Мб)</label>
                                        <input type="file" name="userfile" id="userfile" accept="image/*">
                                  </div>  
                                  
                          <div class="form-group">
                                        <label></label>
                                        <button type="button" onClick="newPhoto();" class="btn btn-primary btn-lg">Загрузить</button>
                                  </div> 
                </form>
                </div>
                <!-- /.col-lg-6 -->
                	
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
   </div>
   
   <script type="text/javascript">
   function newPhoto()
	{
  	file = $('#userfile').val();

  	if (file == '')
  	{
      	alert('Выберите файл, чтобы начать загрузку');
      	return;
  	}

  	$('#new_photo').submit();
	}
	
   	function deletePhoto(name, id)
   	{
		$.ajax({
			url: '<?=base_url()?>partner/ankets/ajax/delete_photo/',
			type: 'POST',
			dataType: 'json',
			data: { name: name, id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#p_'+name).html('');
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

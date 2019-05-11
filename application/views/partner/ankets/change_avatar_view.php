 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Мой профиль</h1>
                </div>
                <!-- /.col-lg-12 -->
                
            </div>
            <? if($resInfo != ''): ?>
             <div class="alert alert-<?if($resInfo['type'] == 'success'):?>success<?else:?>danger<?endif;?> alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <?=$resInfo['text']?>
             </div>
            <? endif; ?>
                        <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                        	
                        	<div class="col-lg-6">
                    		<div class="panel panel-default">
                        	<div class="panel-heading">
                          	  Текущий аватар
                        	</div>
                        	<div class="panel-body">
                            	<p id="deleted"><? if($info['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$info['photo_link']?>_240.jpg">
                            	<? else:?>
                            	<img width="240" height="360" src="<?=base_url()?>content/img/no-foto.png"><?endif;?></p>
                        	</div>
                        	<div class="panel-footer">
                            	<? if($info['photo_link'] != ''):?><a href="#." onClick="deleteAvatar('<?=$info['id']?>');">Удалить аватар</a><?endif;?>
                        	</div>
                        
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-6">
                <form action="" method="post" id="avatar" enctype="multipart/form-data">
                <input type="hidden" value="1" name="new"/>
                <input type="hidden" value="<?=$info['id']?>" name="u_id"/>
                    		<div class="form-group">
                                        <label>Новый аватар (только формат .jpg, размер до 10 Мб)</label>
                                        <input type="file" name="userfile" id="userfile" accept="image/*">
                                  </div>  
                                  
                          <div class="form-group">
                                        <label></label>
                                        <button type="button" onClick="newAvatar();" class="btn btn-primary btn-lg">Загрузить</button>
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
        <!-- /#page-wrapper -->
        <script>
        	function newAvatar()
        	{
            	file = $('#userfile').val();

            	if (file == '')
            	{
                	alert('Выберите файл, чтобы начать загрузку');
                	return;
            	}

            	$('#avatar').submit();
        	}

        	function deleteAvatar(id)
        	{
        		$.ajax({
        			url: '<?=base_url()?>partner/ankets/ajax/delete_avatar/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#deleted').html('');
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

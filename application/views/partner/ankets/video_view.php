 <script type="text/javascript" src="<?=base_url()?>content/js/mediaelement-and-player.min.js"></script>
 <link href="<?=base_url()?>content/css/media.css" rel="stylesheet" type="text/css">
 
<div id="page-wrapper">
	<div class="row">
    	<div class="col-lg-12">
        	<h1 class="page-header">Загрузка видеопрезентации</h1>
        </div>
	</div>
    
    <? if($resInfo != ''): ?>
	    <div class="alert alert-<?if($resInfo['type'] == 'success'):?>success<?else:?>danger<?endif;?> alert-dismissable">
	    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <?=$resInfo['text']?>
	    </div>
    <? endif; ?>

        <div class="row">
        	<div class="col-lg-12">
            	<div class="panel panel-default">
                        <div class="panel-heading"></div>
                        
                        <div class="panel-body">
         
	                    	<div align="center" id="player">
                        	<? if($isExist == false) { ?>
                        		<div class="alert alert-warning">Видеопрезентаций нет.</div>
                        	<? } ?>
                        	
                        	<?php foreach ($info as $video) { ?>
                        		<div id="video_<?=str_replace('.mp4', '', $video['video_name']); ?>">
                        			<?php if ($video['approved'] != 1) { ?><div class="alert alert-danger" style="width:640px;">Это видео еще не проверено администрацией.</div><?php } ?>
                        			<video width="640" height="267" controls="true">
										<source src="<?=base_url()?>profiles/video/user_<?=$user['id']?>/<?=$video['video_name']?>" type="<?=$video['mime_type']?>">
									</video>
									<br>
									<a href="javascript:;" onClick="deleteVideo('<?=str_replace('.mp4', '', $video['video_name']);?>', '<?=$user['id']?>');" class="btn btn-danger">Удалить видео</a>
									<br><br><br>
									<hr>
                        		</div>
                        	<?php } ?>
							
							</div>
							<div align="center">
							<br><br>
							<form action="" method="post" enctype="multipart/form-data">
               				 <input type="hidden" value="1" name="new"/>
                			<input type="hidden" value="<?=$user['id']?>" name="u_id"/>
                    		<div class="form-group">
                                 <label>Добавить видеопрезентацию (только формат .mp4, размер до 500 Мб)</label>
                                 <input type="file" name="userfile" id="userfile" accept="video/*">
                            </div>
                              
                                  
                          <div class="form-group">
                                        <label></label>
                                        <button type="submit" class="btn btn-primary btn-lg">Загрузить</button>
                                  </div> 
                </form>
                        	</div>
                	
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
	$(document).ready(function() {
		$('video').mediaelementplayer({
			alwaysShowControls: false,
			videoVolume: 'horizontal',
			features: ['playpause','progress','volume','fullscreen']
		});
	});

	function deleteVideo(id, user)
	{
		$.ajax({
			url: '<?=base_url()?>partner/ankets/ajax/delete_video/',
			type: 'POST',
			dataType: 'json',
			data: { id: id, user: user },
			success: function(obj) {
				if (obj.result == 'success') {
					$('#video_'+id).html('');
				}
				else {
					alert(obj.message);
				}
			}
		});
	}	
</script>

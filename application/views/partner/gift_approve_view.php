     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Сообщение о доставке подарка</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">

                           <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Для того, чтобы администрация убедилась, что подарок доставлен, Вам необходимо загрузить фотографию девушки с подарком.
                            </div>

                        <form role="form" id="approveGift" action="<?=base_url()?>partner/gifts/" enctype="multipart/form-data" method="POST">
                        <input type="hidden" value="1" name="gift" />
                        <input type="hidden" value="<?=$gift['gift_hash']?>" name="hash" />
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Подарок</label>
                                           <br/><?=$this->all_gifts->returnGiftName($gift['gift'])?>
                                           <?=$this->all_gifts->returnGiftCount($gift['gift'], $gift['count'])?>
                                        </div>
                                  
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                        <label>Фотография девушки (только формат .jpg)</label>
                                        <input type="file" name="userfile" id="userfile" accept="image/*">
                                  </div>                        
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                             <div align="center">
                             	<button type="button" onClick="sendThisForm()" class="btn btn-outline btn-primary btn-lg btn-block">Отправить на рассмотрение</button>
                             </div>
                            </form>
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
        
        <script type="text/javascript">
        	function sendThisForm()
        	{
            	image = $('#userfile').val();

            	if (image == '')
            	{
                	alert('Прикрепите фотографию');
                	return;
            	}

            	$('#approveGift').submit();
        	}
        </script>
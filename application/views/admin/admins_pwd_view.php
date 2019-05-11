             <div class="span9" id="content">
             <?PHP if(!empty($resInfo)) { ?>
				<div class="alert alert-<?=$resInfo['type']?> alert-block">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<h4 class="alert-heading"></h4>
						<?=$resInfo['text']?>
				</div>
			 <?PHP } ?>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Смена пароля</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<form action="" method="POST">
										<div class="form-group">	
											<label>Текущий пароль:</label>
											<input type="password" name="now_pwd" class="form-control">
										</div>
										<div class="form-group">
											<label>Новый пароль:</label>
											<input type="password" name="new_pwd" class="form-control">
										</div>
										
										<div class="form-group">
											<button type="submit" class="btn btn-primary">Сохранить пароль</button>
										</div>
									</form>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                </div>
            </div>
<div class="span9" id="content">

 <div class="row-fluid">
                        <!-- block -->
                      <? if($list != false): ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Архив рассылок</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Дата</th>
						                  <th>Тема</th>
						                  <th>Текст</th>
						                  <th>Получатели</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($list as $row): 
						              ?>
						                <tr id="n_<?=$row['hash']?>">
						                  <td><?=$row['date']?></td>
						                  <td><?=$row['subject']?></td>
						                  <td><a href="#modal_<?=$row['hash']?>" data-toggle="modal" class="btn btn-primary">Просмотр</a>										
						                  <div id="modal_<?=$row['hash']?>" class="modal hide">
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">&times;</button>
												<h3>Текст рассылки</h3>
											</div>
											<div class="modal-body">
												<p><?=$row['message']?></p>
											</div>
										</div></td>
						                  <td><?if($row['type'] == 1):?>Все пользователи<?elseif($type == 2):?>Только девушки<?elseif($type == 3):?>Только мужчтны<?endif;?></td>
						                </tr>
						            <? endforeach; ?>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /block -->
                    <? else: ?>
                    	<div class="alert alert-block">
							<a class="close" data-dismiss="alert" href="#">&times;</a>
							<h4 class="alert-heading">Ошибка</h4>
							Архив рассылок пуст.
						</div>
					<? endif; ?>
                    </div>

                </div>
            </div>
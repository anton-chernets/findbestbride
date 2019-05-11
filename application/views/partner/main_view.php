     <div id="page-wrapper">
     
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$this->lang->line('partner_first_title')?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
         <? if($this->partInfo['p_status'] == 0):?>
           <div class="alert alert-danger">
            В данный момент Вы не можете пользоваться функциями панели управления для партнеров. Для активации Вашего аккаунта, вам необходимо заполнить Ваш профиль и дождаться активации администрацией. Активация проходит в течении 24 часов с момента заполнения профиля. <a href="<?=base_url()?>partner/profile/" class="alert-link">Нажмите здесь, чтобы перейти к заполнению своего профиля</a>.  
          	</div>
         <? elseif ($this->partInfo['p_status'] == 1): ?>
             <div class="alert alert-warning">
                Ваш профиль находится на активации. Пожалуйста, дождитесь активации вашего профиля, чтобы начать пользоваться панелью управления для партнеров.
             </div>
         <? endif; ?>
<? if ($news != false): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <b><?=$this->lang->line('partner_first_news')?></b>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                            <? $i = 0;
                            	foreach ($news as $row): 
                            	$i++;
                            ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?=$i?>"><?=$row['subject']?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse_<?=$i?>" class="panel-collapse collapse<?if($i==1):?> in<?endif;?>">
                                        <div class="panel-body">
                                           <?=$row['message']?>
                                        </div>
                                    </div>
                                </div>
                              <? endforeach; ?>
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
   		<? endif; ?>
        </div>
        <!-- /#page-wrapper -->
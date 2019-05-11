<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Личные сообщения анкет</h1>
        </div>
    </div>
    <div class="col-lg-12">
		<ul class="nav nav-tabs">
       		<li class="active"><a href="#in" data-toggle="tab">Входящие (<?=count($in)?>)</a></li>
            <li><a href="#out" data-toggle="tab">Исходящие (<?=count($out)?>)</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
             <div class="tab-pane fade in active" id="in">
                  <?php if (empty($in)) { ?>
                  <br><p class="alert alert-danger">Входящих сообщений нет.</p>
                  <?php } else {?>
                  <ul class="timeline">
                  <?php foreach ($in as $msg) { 
                  	$from_info = $this->mainModel->getUserProfile($msg['from_user_id']);
                  	$server = ($msg['attach_server'] == 1) ? base_url() : 'm.'.str_replace('http://', '', base_url());
                  	?>
                  		<li>
                  			<?php if (!empty($msg['attachment'])) { ?><div class="timeline-badge success"><a href="javascript:;" data-toggle="modal" data-target="#attach_<?=$msg['attachment']?>"><i class="fa fa-save" style="color:#fff;"></i></a></div>
                  			 <!-- Modal -->
                            <div class="modal fade" id="attach_<?=$msg['attachment']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <br>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?=$server?>profiles/attachments/<?=$msg['attachment']?>_orig.jpg" class="img-responsive">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                  			<?php } ?>
                        	<div class="timeline-panel"  <?php if($msg['is_read'] == 0) { ?>style="background-color:#FFE4E1;"<?php } ?>>
                                	<div class="timeline-heading">
                                    	<h4 class="timeline-title"><?=$msg['subject']?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?=date('d.m.Y H:i', $msg['msg_date'])?>, прислал <a href="<?=base_url()?>user<?=$msg['from_user_id']?>" target="_blank"><?=$from_info['name'] .' '. $from_info['lastname'];?></a></small>
                                            </p>
                                    </div>
                                    <div class="timeline-body">
                                    	<p><?=$msg['message'];?></p>
                                    </div>
                             </div>
                         </li>
                 	<?php } ?>
                 	</ul>
                  <?php } ?>         		
             </div>
                                
             <div class="tab-pane fade" id="out">
                   <?php if (empty($out)) { ?><br><p class="alert alert-danger">Исходящих сообщений нет.</p>
                   <?php } else { ?>
                   <ul class="timeline">
                   <?php foreach ($out as $out) { 
                   	$to_info = $this->mainModel->getUserProfile($out['to_user_id']);
                   	$server = ($out['attach_server'] == 1) ? base_url() : 'm.'.str_replace('http://', '', base_url());
                   	?>
                   <li class="timeline-inverted">
                  			<?php if (!empty($out['attachment'])) { ?><div class="timeline-badge success"><a href="javascript:;" data-toggle="modal" data-target="#attach_<?=$out['attachment']?>"><i class="fa fa-save" style="color:#fff;"></i></a></div>
                  			 <!-- Modal -->
                            <div class="modal fade" id="attach_<?=$out['attachment']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                           <br>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?=$server?>profiles/attachments/<?=$out['attachment']?>_orig.jpg" class="img-responsive">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                  			<?php } ?>
                        	<div class="timeline-panel">
                                	<div class="timeline-heading">
                                    	<h4 class="timeline-title"><?=$out['subject']?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?=date('d.m.Y H:i', $out['msg_date'])?>, получатель <a href="<?=base_url()?>user<?=$out['to_user_id']?>" target="_blank"><?=$to_info['name'] .' '. $to_info['lastname'];?></a></small>
                                            </p>
                                    </div>
                                    <div class="timeline-body">
                                    	<p><?=$out['message'];?></p>
                                    </div>
                             </div>
                         </li>
                   <?php } ?>
                   </ul> 
                   <?php } ?>            
             </div>
        </div>
    </div>
</div>
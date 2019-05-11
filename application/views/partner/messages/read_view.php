
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$this->lang->line('partner_msg_title')?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="jumbotron">
                        <h2><?=$msg['subject']?></h2>
                        <p><?=$msg['message']?></p>
                        <p><a href="<?=base_url()?>partner/messages/" class="btn btn-primary btn-lg" role="button">Назад</a>
                        </p>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
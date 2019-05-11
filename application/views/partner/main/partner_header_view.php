<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$title?></title>

    <!-- Core CSS - Include with every page -->
    <link href="<?=base_url()?>content/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>content/bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="<?=base_url()?>content/bootstrap/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="<?=base_url()?>content/bootstrap/css/plugins/timeline/timeline.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?=base_url()?>content/bootstrap/css/sb-admin.css" rel="stylesheet">
    <script src="<?=base_url()?>content/bootstrap/js/jquery-1.10.2.js"></script>
    <script src="<?=base_url()?>content/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>content/js/ion.sound.min.js"></script>
</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=base_url()?>partner/first/">Partner Panel</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <? $msg = $this->mainModel->getPartnerBlockMessages($this->partId);
                    	if ($msg == false):
                    ?>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a class="text-center" href="#">
                                <strong>Сообщений нет</strong>
                               
                            </a>
                        </li>
                    </ul>
                    <? else: ?>
                    <ul class="dropdown-menu dropdown-messages">
                        <? foreach ($msg as $row): ?>
                        <li>
                            <a href="#">
                                <div>
                                   
                                    <span class="pull-right text-muted">
                                        <em><?=date('d.m.Y', $row['msg_date'])?></em>
                                    </span>
                                </div>
                                <div><?=$row['subject']?></div>
                            </a>
                        </li>
                        <? endforeach; ?>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="<?=base_url()?>partner/messages/">
                                <strong>Перейти к сообщениям</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <? endif; ?>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?=base_url()?>partner/profile/"><i class="fa fa-user fa-fw"></i> Мой профиль</a>
                        </li>
                        <li><a href="<?=base_url()?>partner/password/"><i class="fa fa-wrench fa-fw"></i> Сменить пароль</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?=base_url()?>partner/first/logout/"><i class="fa fa-sign-out fa-fw"></i> Выход</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?=base_url()?>partner/first/"><i class="fa fa-fw"></i> Новости</a>
                        </li>
                        <li <?php if ($this->uri->segment(2) == 'ankets') {?>class="active"<?php }?>>
                            <a href="#"><i class="fa fa-fw"></i> Анкеты<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?=base_url()?>partner/ankets/"><i class="fa fa-chevron-right"></i> Все анкеты</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>partner/ankets/active/"><i class="fa fa-chevron-right"></i> Активные</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/ankets/inactive/"><i class="fa fa-chevron-right"></i> Не активные</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/ankets/waiting/"><i class="fa fa-chevron-right"></i> На рассмотрении</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/ankets/online/"><i class="fa fa-chevron-right"></i> Анкеты онлайн</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/ankets/messages/"><i class="fa fa-chevron-right"></i> Личные сообщения</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/ankets/add/"><i class="fa fa-chevron-right"></i> <b>Добавить анкету</b></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li <?php if ($this->uri->segment(2) == 'finance') {?>class="active"<?php }?>>
                            <a href="#"><i class="fa fa-fw"></i> Финансы<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?=base_url()?>partner/finance/"><i class="fa fa-chevron-right"></i> Начисления</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>partner/finance/penalty/"><i class="fa fa-chevron-right"></i> Штрафы</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?=base_url()?>partner/messages/"><i class="fa fa-fw"></i> Сообщения <? $msg = $this->mainModel->partnerNewMessages($this->partId); if ($msg != false): ?><sup style="color:red"><b><?=$msg?></b></sup><?endif;?></a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>partner/gifts/"><i class="fa fa-fw"></i> Подарки <?php echo $this->mainModel->partnerNewGifts($this->partId); ?></a>
                        </li>
                        <li <?php if ($this->uri->segment(2) == 'tour') {?>class="active"<?php }?>>
                        	<a href="#"><i class="fa fa-fw"></i> Романтический тур<span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                                <li>
                                   <a href="<?=base_url()?>partner/tour/"><i class="fa fa-chevron-right"></i> Все туры</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>partner/tour/active/"><i class="fa fa-chevron-right"></i> Активные</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/tour/inactive/"><i class="fa fa-chevron-right"></i> Не активные</a>
                                </li>
                                <li>
                                	<a href="<?=base_url()?>partner/tour/add/"><i class="fa fa-chevron-right"></i> <b>Добавить тур</b></a>
                                </li>
                            </ul>
                        </li>
     					<li>
     						<a href="<?=base_url()?>partner/profile/"><i class="fa fa-fw"></i> Мой профиль</a>
     					</li>
                        <li>
                            <a href="<?=base_url()?>partner/page/agreement/"><i class="fa fa-fw"></i> Договор</a>
                        </li>
     					<li>
     						<a href="<?=base_url()?>partner/page/rules/"><i class="fa fa-fw"></i> Правила</a>
     					</li>     					
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
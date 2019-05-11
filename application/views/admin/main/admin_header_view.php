<!DOCTYPE html>
<html>
    
    <head>
        <title><?=$title?></title>
        <meta charset="utf-8">
        <!-- Bootstrap -->
        <link href="<?=base_url()?>content/boot/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?=base_url()?>content/boot/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?=base_url()?>content/boot/assets/styles.css" rel="stylesheet" media="screen">
        <?php if ($this->uri->segment(2) == 'image') { ?>
        <link href="<?=base_url()?>content/boot/assets/jquery.Jcrop.min.css" rel="stylesheet">
        <?php } ?>
        
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="<?=base_url()?>content/boot/vendors/jquery-1.9.1.min.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
		<script type="text/javascript">
			function logDeleteCheck()
			{
				if (confirm('Вы действительно хотите удалить все логи?') == true)
				{
					window.location='<?=base_url()?>admin/logs/delete/';
				}
			}
		</script>
    	
    </head>
    
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Admin Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> Администратор <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                	<li>
                                		<a tabindex="-1" href="<?=base_url()?>" target="_blank"> На сайт</a>
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/first/logout/">Выход</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li>
                                <a href="<?=base_url()?>admin/first/">Главная</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Партнеры <b class="caret"></b>

                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="<?=base_url()?>admin/partners/add"><b>Добавить партнера</b>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?=base_url()?>admin/activation/partner">Активация партнеров</a>
                                    </li>
                                    <li>
                                        <a href="<?=base_url()?>admin/partners/">Список партнеров</a>
                                    </li>
                                    <li>
                                        <a href="<?=base_url()?>admin/partners/message/">Сообщение партнеру</a>
                                    </li>
                                    <li>
                                    	<a href="<?=base_url()?>admin/email/partner/">E-MAIL сообщение партнеру</a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?=base_url()?>admin/partners/penalty">Наложить штраф</a>
                                    </li>
                                    <li>
                                    	<a href="<?=base_url()?>admin/partners/news/">Рассылка</a>
                                    </li>
                                    <li>
                                    	<a href="<?=base_url()?>admin/partners/text/agreement/">Текст договора</a>
                                    </li>
                                    <li>
                                    	<a href="<?=base_url()?>admin/partners/text/rules/">Текст правил</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Финансы <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/fin/">Начисления</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/fin/penalty/">Штрафы</a>
                                    </li>
                                    <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/fin/report/">Отчет по партнеру</a>
                                    </li>
                                    <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/fin/man/">Отчет по мужчине</a>
                                    </li>
                                          <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/ank/add_credits/">Добавить/Снять кредиты мужчине</a>
                                    </li>
                                      <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/ank/men_credits/">Кредиты у мужчин</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Анкеты <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                	<li>
                                		<a tabindex="-1" href="<?=base_url()?>admin/ank/all/">Полный список анкет</a>
                                	</li>
                                	<li>
                                		<a tabindex="-1" href="<?=base_url()?>admin/ank/edit/">Редактировать анкету</a>
                                	</li>
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/ank/block/">Заблокировать</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/ank/unblock/">Разблокировать</a>
                                    </li>
									<li>
										<a tabindex="-1" href="/admin/ank/blocked">Список заблокированных</a>
									</li>
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/activation/ankets/">Активация анкет</a>
                                    </li>
                                 
                         
                              
                                    <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/ank/not_activated/">Не активированные анкеты</a>
                                    </li>
                                  
									<li>
										<a tabindex="-1" href="<?=base_url()?>admin/ank/chats/">История переписок в чате</a>
									</li>
                                </ul>
                            </li>
							
							<li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Логи <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/logs/ankets/">Логи анкет</a>
                                    </li>
									<li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/logs/partners/">Логи партнеров</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#" onClick="logDeleteCheck();">Стереть ВСЕ логи</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li>
                            	<a href="<?=base_url()?>admin/settings/">Настройки</a>
                            </li>
							
							<li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Цены <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="/admin/settings/prices/">Цены на сервисы</a>
                                    </li>
									<li>
                                        <a tabindex="-1" href="/admin/settings/gifts/">Цены на подарки</a>
                                    </li>
                                </ul>
                            </li>
                             <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Сообщения <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                	   <li>
                                        <a tabindex="-1" href="<?=base_url()?>admin/ank/message/">Сообщение пользователю</a>
                                    </li>
                                    <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/email/user/">Отправить E-MAIL сообщение</a>
                                    </li>
                                    <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/email/mailing/">Создать E-MAIL рассылку</a>
                                    </li>
                                    <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/ank/man_emails/">Список e-mail мужчин</a>
                                    </li>
                                                                        <li>
                                    	<a tabindex="-1" href="<?=base_url()?>admin/ank/women_emails/">Список e-mail девушек</a>
                                    </li>
                                </ul>
                                </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li>
                            <a href="<?=base_url()?>admin/first/"><i class="icon-chevron-right"></i> Главная</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/first/admins/"><i class="icon-chevron-right"></i> Администрация</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/first/finance/"><i class="icon-chevron-right"></i> Ваши финансы</a>
                        </li>
                        <li>
                        	<a href="<?=base_url()?>admin/statistics/"><i class="icon-chevron-right"></i> Статистика</a>
                        </li>
						<li>
                            <a href="/admin/activation/avatars/"><? $ankets = $this->mainModel->getAvatarsOnActivation(); if ($ankets > 0): ?><span class="badge badge-success pull-right">+<?=$ankets?></span><? endif; ?> Активация аватаров</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/activation/ankets/"><? $ankets = $this->mainModel->getAnketsOnActivation(); if ($ankets > 0): ?><span class="badge badge-success pull-right">+<?=$ankets?></span><? endif; ?> Активация анкет</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/activation/video/"><? $video = $this->mainModel->getVideoOnActivation(); if ($video > 0): ?><span class="badge badge-success pull-right">+<?=$video?></span><? endif; ?> Активация видеопрезентаций</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/activation/gifts/"><? $gifts = $this->mainModel->getGiftsOnActivation(); if($gifts > 0):?><span class="badge badge-success pull-right">+<?=$gifts?></span><?endif;?> Проверка подарков</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/activation/partner/"><? $part = $this->mainModel->getPartnerOnActivation(); if ($part > 0): ?><span class="badge badge-success pull-right">+<?=$part?></span><?endif;?> Активация партнеров</a>
                        </li>
						<li>
							<a href="<?=base_url()?>admin/activation/broadcast/"><? $broad = $this->mainModel->getActivationBroadcast(); if ($broad > 0): ?><span class="badge badge-success pull-right">+<?=$broad?></span><?endif;?> Модерация массовой рассылки</a>
						</li>
                        <li>
                        	<a href="<?=base_url()?>admin/activation/rt/"><? $rt = $this->mainModel->getRtOnActivation(); if ($rt > 0): ?><span class="badge badge-success pull-right">+<?=$rt?></span><?endif;?> Активация ром. туров</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/support/"><? $sup = $this->mainModel->getSupportTickets(); if ($sup > 0): ?><span class="badge badge-success pull-right">+<?=$sup?></span><?endif;?> Техподдержка</a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>admin/req/rt/"><? $rt = $this->mainModel->getRtReq(); if ($rt > 0): ?><span class="badge badge-success pull-right">+<?=$rt?></span><? endif; ?> Romance Tours</a>
                        </li>
                    </ul>
                </div>
                <!--/span-->

       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="jumbotron">
                        <h2>Романтический тур #<?=$info['tour_id']?></h2>
                        <p>Услуги переводчика:</p>
                        <ul>
                        	<li>$<?=$info['perevod_1']?> за 1 час</li>
                        	<li>$<?=$info['perevod_8']?> за 8 часов</li>
                        	<li>$<?=$info['perevod_16']?> за 16 часов</li>
                        </ul>
                        <p>Услуги водителя:</p>
                        <ul>
                        	<li>$<?=$info['driver_1']?> за 1 час</li>
                        	<li>$<?=$info['driver_8']?> за 8 часов</li>
                        	<li>$<?=$info['driver_16']?> за 16 часов</li>
                        </ul>
                        <p>Стоимость завтрака: $<?=$info['morning']?></p>
                        <p>Стоимость обеда: $<?=$info['afternoon']?></p>
                        <p>Стоимость ужина: $<?=$info['evening']?></p>
                        <p><? foreach ($ephoto as $row): ?>
                        	<img src="<?=base_url()?>profiles/partner/p_<?=$this->partId?>/<?=$row['photo_name']?>" height="150" width="150">
                        <? endforeach; ?></p>
                        <p>Стоимость квартиры: $<?=$info['house_price']?></p>
                        <p>Сведения о квартире: <?=$info['house_info']?></p>
                        <p>Стоимость мини-бара: $<?=$info['minibar_price']?></p>
                        <p>Содержимое мини-бара: <?=$info['minibar_items']?></p>
                        <p><? foreach ($hphoto as $row): ?>
                        	<img src="<?=base_url()?>profiles/partner/p_<?=$this->partId?>/<?=$row['photo_name']?>" height="150" width="150">
                        <? endforeach; ?></p>
                        <p>Экскурсии: <?=$info['eks']?></p>
                        <p>Услуги: <?=$info['uslugi']?></p>
                        <p>Стоимость услуг: $<?=$info['uslugi_price']?></p>
                        <p><? foreach ($uphoto as $row): ?>
                        	<img src="<?=base_url()?>profiles/partner/p_<?=$this->partId?>/<?=$row['photo_name']?>" height="150" width="150">
                        <? endforeach;?></p>
                        <p>Ближайший аэропорт (город): <?=$info['airport']?></p>
                        <p>Город прибытия: <?=$info['city']?></p>
                        <p>Расстояние трансфера: <?=$info['transfer_km']?> km</p>
                        <p>Стоимость трансфера: $<?=$info['transfer_price']?></p>
                        <p><a class="btn btn-primary btn-lg" onClick="history.go(-1);" role="button">Назад</a>
                        </p>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
       </div>

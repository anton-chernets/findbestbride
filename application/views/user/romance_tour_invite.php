<!-- div content -->
   
<div id="maket-account">

   <div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="350" height="8px">
        <div class="h2" style="float:left;" align="center"> <?=$this->lang->line('rt_line')?> </div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="350" height="8px">
     </div>
     
 <div id="left_column">
        <div id="block-foto"> 
             <div class="big-foto"><? if($info['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$info['photo_link']?>_342.jpg"><? else: ?><img src="<?=base_url()?>content/img/no-foto.png" width="342" height="500"><?endif;?></div>
             <div class="profile-id"><?=sprintf($this->lang->line('gift_id'), $info['name'], $info['id'])?></div>
          </div>
</div>
 
 <div id="content-prof">

<? foreach ($list as $row): 
	$hphoto = $this->user->getTourPhoto($row['photo_id'], '2');
	$ephoto = $this->user->getTourPhoto($row['photo_id'], '1');
	$uphoto = $this->user->getTourPhoto($row['photo_id'], '3');
?>
 	    	<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_translate')?></div>
				<ul>
					<li>$<?=$row['perevod_1']?> <?=sprintf($this->lang->line('rt_translate_1'), '1')?></li>
					<li>$<?=$row['perevod_8']?> <?=sprintf($this->lang->line('rt_translate_2'), '8')?></li>
					<li>$<?=$row['perevod_16']?> <?=sprintf($this->lang->line('rt_translate_2'), '16')?></li>
				</ul>     
			</div>
            <div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_driver')?></div>
				<ul>
					<li>$<?=$row['driver_1']?> <?=sprintf($this->lang->line('rt_translate_1'), '1')?></li>
					<li>$<?=$row['driver_8']?> <?=sprintf($this->lang->line('rt_translate_2'), '8')?></li>
					<li>$<?=$row['driver_16']?> <?=sprintf($this->lang->line('rt_translate_2'), '16')?></li>
				</ul> 
      		</div>
            <div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_house_info')?></div>
				<?=$row['house_info']?>	
			</div>
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_house_price')?></div>
				$<?=$row['house_price']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_house_bar')?></div>
				<?=$row['minibar_items']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_house_bprice')?></div>
				$<?=$row['minibar_price']?>	
			</div>
			
		   	<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_house_photo')?></div>
				<div id="house">
					<? foreach ($hphoto as $h): ?>
					<a href="<?=base_url()?>profiles/partner/p_<?=$h['p_id']?>/<?=$h['photo_name']?>"><img src="<?=base_url()?>profiles/partner/p_<?=$h['p_id']?>/<?=$h['photo_name']?>" width="100" height="100"></a>
					<? endforeach; ?>
				</div>
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_zavtrak')?></div>
				$<?=$row['morning']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_obed')?></div>
				$<?=$row['afternoon']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_ujin')?></div>
				$<?=$row['evening']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_ujin_photo')?></div>
				<div id="supper">
					<? foreach ($ephoto as $e): ?>
					<a href="<?=base_url()?>profiles/partner/p_<?=$e['p_id']?>/<?=$e['photo_name']?>"><img src="<?=base_url()?>profiles/partner/p_<?=$e['p_id']?>/<?=$e['photo_name']?>" width="100" height="100"></a>
					<? endforeach; ?>
				</div>
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_services')?></div>
				<?=$row['uslugi']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_serv_price')?></div>
				$<?=$row['uslugi_price']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_serv_photo')?></div>
				<div id="service">
					<? foreach ($uphoto as $u): ?>
					<a href="<?=base_url()?>profiles/partner/p_<?=$u['p_id']?>/<?=$u['photo_name']?>"><img src="<?=base_url()?>profiles/partner/p_<?=$u['p_id']?>/<?=$u['photo_name']?>" width="100" height="100"></a>
					<? endforeach; ?>
				</div>
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_ekskurs')?></div>
				<?=$row['eks']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_airport')?></div>
				<?=$row['airport']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_arrival')?></div>
				<?=$row['city']?>	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_transfer')?></div>
				<?=$row['transfer_km']?> km	
			</div>
			
			<div class="profile-info">
				<div class="title"><?=$this->lang->line('rt_transfer_p')?></div>
				$<?=$row['transfer_price']?>	
			</div>
			<div id="clear"></div>
			<div class="profile_info">
				<br/><br/>
				<button type="button" onClick="chooseTour('<?=$row['tour_id']?>', '<?=$info['id']?>');" name="sent" class="bt-save" style="margin-right:190px"><?=$this->lang->line('rt_button')?></button>
			</div>
<? endforeach; ?>
 </div>
 <?=$links?>
 <div id="clear"></div>
 </div>
 
 <script>
 $(function() {
	    $('#house a').lightBox({
	        imageLoading: '<?=base_url()?>content/img/gallery/loading.gif',
	        imageBtnClose: '<?=base_url()?>content/img/gallery/close.gif',
	        imageBtnPrev: '<?=base_url()?>content/img/gallery/prev.gif',
	        imageBtnNext: '<?=base_url()?>content/img/gallery/next.gif'

	    });

	    $('#supper a').lightBox({
	        imageLoading: '<?=base_url()?>content/img/gallery/loading.gif',
	        imageBtnClose: '<?=base_url()?>content/img/gallery/close.gif',
	        imageBtnPrev: '<?=base_url()?>content/img/gallery/prev.gif',
	        imageBtnNext: '<?=base_url()?>content/img/gallery/next.gif'

	    });

	    $('#service a').lightBox({
	        imageLoading: '<?=base_url()?>content/img/gallery/loading.gif',
	        imageBtnClose: '<?=base_url()?>content/img/gallery/close.gif',
	        imageBtnPrev: '<?=base_url()?>content/img/gallery/prev.gif',
	        imageBtnNext: '<?=base_url()?>content/img/gallery/next.gif'

	    });
	});

	function chooseTour(tour, id)
	{
		$.ajax({
			url: '<?=base_url()?>tour/ajax/choose/',
			type: 'POST',
			dataType: 'json',
			data: { tour: tour, id: id },
			success: function(obj) {
				if (obj.result == 'success') {
					alert('<?=$this->lang->line('rt_ok')?>');
					window.location.href = '<?=base_url()?>user' + id;
				}
				else {
					alert(obj.message);
				}
			}
		});	
	}
 
 </script>


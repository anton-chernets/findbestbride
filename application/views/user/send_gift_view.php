<?PHP
	$red = explode(',', $this->mainModel->getGiftPrice(1));
	$pink = explode(',', $this->mainModel->getGiftPrice(2));
	$white = explode(',', $this->mainModel->getGiftPrice(3));
	$ch = explode(',', $this->mainModel->getGiftPrice(5));
	$g = explode(',', $this->mainModel->getGiftPrice(6));
	$p = explode(',', $this->mainModel->getGiftPrice(15));
	$j = explode(',', $this->mainModel->getGiftPrice(22));
?>
   
<div id="maket-account">
    
<script type="text/javascript">
function send_gift(id)
{
	count = $('#rose_'+id).val();
		
	$.ajax({
		url: '<?=base_url()?>gift/ajax/',
		type: 'POST',
		dataType: 'json',
		data: { id: id, women: '<?=$info['id']?>', count: count },
		success: function(obj) {
			if (obj.result == 'success') {
				alert(obj.message);
			}
			else {
				alert(obj.message);
			}
		}
	});	
}

function updateFlower(id)
{
	if (id == 1)
	{
		type = $('#rose_1').val();
		if (type == 3)
		{
			price = <?php echo $red[0];?>;
		}
		if (type == 5)
		{
			price = <?php echo $red[1];?>;
		}
		if (type == 7)
		{
			price = <?php echo $red[2];?>;
		}
		if (type == 11)
		{
			price = <?php echo $red[3];?>;
		}
		if (type == 15)
		{
			price = <?php echo $red[4];?>;
		}
		if (type == 23)
		{
			price = <?php echo $red[5];?>;
		}

		$('#price_1').html(price);
	}
	if (id == 2)
	{
		type = $('#rose_2').val();
		if (type == 3)
		{
			price = <?php echo $pink[0];?>;
		}
		if (type == 5)
		{
			price =  <?php echo $pink[1]; ?>;
		}
		if (type == 7)
		{
			price =  <?php echo $pink[2];?>;
		}
		if (type == 11)
		{
			price =  <?php echo $pink[3]?>;
		}
		if (type == 15)
		{
			price =  <?php echo $pink[4]?>;
		}
		if (type == 23)
		{
			price =  <?php echo $pink[5]?>;
		}

		$('#price_2').html(price);
	}
	if (id == 3)
	{
		type = $('#rose_3').val();
		if (type == 3)
		{
			price = <?php echo $white[0];?>;
		}
		if (type == 5)
		{
			price = <?php echo $white[1];?>;
		}
		if (type == 7)
		{
			price = <?php echo $white[2];?>;
		}
		if (type == 11)
		{
			price = <?php echo $white[3];?>;
		}
		if (type == 15)
		{
			price = <?php echo $white[4];?>;
		}
		if (type == 23)
		{
			price = <?php echo $white[5];?>;
		}

		$('#price_3').html(price);
	}
	if (id == 5)
	{
		type = $('#rose_5').val();
		if (type == 3)
		{
			price = <?php echo $ch[0];?>;
		}
		if (type == 5)
		{
			price = <?php echo $ch[1];?>;
		}
		if (type == 7)
		{
			price = <?php echo $ch[2];?>;
		}
		if (type == 11)
		{
			price = <?php echo $ch[3];?>;
		}
		if (type == 15)
		{
			price = <?php echo $ch[4];?>;
		}
		if (type == 23)
		{
			price = <?php echo $ch[5];?>;
		}

		$('#price_5').html(price);
	}
	if (id == 6)
	{
		type = $('#rose_6').val();
		if (type == 3)
		{
			price = <?php echo $g[0];?>;
		}
		if (type == 5)
		{
			price = <?php echo $g[1];?>;
		}
		if (type == 7)
		{
			price = <?php echo $g[2];?>;
		}
		if (type == 11)
		{
			price = <?php echo $g[3];?>;
		}
		if (type == 15)
		{
			price = <?php echo $g[4];?>;
		}
		if (type == 23)
		{
			price = <?php echo $g[5];?>;
		}

		$('#price_6').html(price);
	}

	if (id == 15)
	{
		type = $("#rose_15").val();
		if (type == 50)
		{
			price = <?php echo $p[0];?>;
		}
		if (type == 100)
		{
			price = <?php echo $p[1];?>;
		}

		$('#price_15').html(price);
	}
	if (id == 22)
	{
		type = $('#rose_22').val();
		if (type == 1)
		{
			price = <?php echo $j[0];?>;
		}
		if (type == 2)
		{
			price = <?php echo $j[1];?>;
		}
		if (type == 3)
		{
			price = <?php echo $j[2];?>;
		}
		if (type == 4)
		{
			price = <?php echo $j[3];?>;
		}

		$('#price_22').html(price);
	}
}
</script>    
    <div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="410" height="8px">
        <div class="h2" style="float:left;" align="center"> <?=$this->lang->line('gift_line')?> </div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="410" height="8px">
     </div>
     
 <div id="left_column">
        <div id="block-foto"> 
             <div class="big-foto"><? if($info['photo_link'] != ''):?><img src="<?=base_url()?>profiles/photo/user_<?=$info['id']?>/<?=$info['photo_link']?>_342.jpg"><? else: ?><img src="<?=base_url()?>content/img/no-foto.png" width="342" height="500"><?endif;?></div>
             <div class="profile-id"><?=sprintf($this->lang->line('gift_id'), $info['name'], $info['id'])?></div>
          </div>
</div>
 
 <div id="content-prof">


 <div class="profile-data">

        <div class="col-gift fix-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/rose-red.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_rose')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_1"><?php echo $red[0];?></span></div>
             <?=$this->lang->line('gift_count')?>: <select id="rose_1" onChange="updateFlower(1);"><option value="3">3</option><option value="5">5</option><option value="7">7</option><option value="11">11</option><option value="15">15</option><option value="23">23</option></select>
             </div> 
<a href="#." onClick="send_gift(1);" id="gift_1" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
           
          
          </div>   
          
         
       <div class="col-gift fix-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/rose-pink.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_rose2')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_2"><?php echo $pink[0];?></span></div>
             <?=$this->lang->line('gift_count')?>: <select id="rose_2" onChange="updateFlower(2);"><option value="3">3</option><option value="5">5</option><option value="7">7</option><option value="11">11</option><option value="15">15</option><option value="23">23</option></select>
             </div> 
<a href="#." onClick="send_gift(2);" id="gift_2" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                     
        	
         </div>
        
          <div class="col-gift fix-gift"> 
       
       <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/rose-white.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_rose3')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_3"><?php echo $white[0];?></span></div>
             <?=$this->lang->line('gift_count')?>: <select id="rose_3" onChange="updateFlower(3);"><option value="3">3</option><option value="5">5</option><option value="7">7</option><option value="11">11</option><option value="15">15</option><option value="23">23</option></select>
             </div>
<a href="#." onClick="send_gift(3);" id="gift_3" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
         </div>
    
    
          <div class="col-gift fix-gift"> 
       
       <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/rose-mini.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_rose4')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_4"><?php echo $this->mainModel->getGiftPrice(4); ?></span></div>
             <?=$this->lang->line('gift_rose4_text')?>
             </div>
<a href="#." onClick="send_gift(4);" id="gift_4" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
         </div>
 </div>        
 </div>        
          <div class="col-gift"> 
       
       <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/chry.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_chry')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_5"><?php echo $ch[0];?></span></div>
             <?=$this->lang->line('gift_count')?>: <select id="rose_5" onChange="updateFlower(5);"><option value="3">3</option><option value="5">5</option><option value="7">7</option><option value="11">11</option><option value="15">15</option><option value="23">23</option></select>
             
             </div>
<a href="#." onClick="send_gift(5);" id="gift_5" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
         </div>

          <div class="col-gift"> 
       
       <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gerbers.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_gerbera')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_6"><?php echo $g[0];?></span></div>
             <?=$this->lang->line('gift_count')?>: <select id="rose_6" onChange="updateFlower(6);"><option value="3">3</option><option value="5">5</option><option value="7">7</option><option value="11">11</option><option value="15">15</option><option value="23">23</option></select>
             
             </div>
<a href="#." onClick="send_gift(6);" id="gift_6" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
         </div>   
         
      <div class="col-gift"> 
       
       <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/orchid.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_orchi')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number" id="price_7"><?php echo $this->mainModel->getGiftPrice(7); ?></span></div>
             <?=$this->lang->line('gift_orchi_text')?>
             </div>
<a href="#." onClick="send_gift(7);" id="gift_7" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
         </div>         

        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/fruits.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_fruit')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:<span class="txt-number"><?php echo $this->mainModel->getGiftPrice(8); ?></span></div>
             <?=$this->lang->line('gift_fruit_text')?>
           </div> 
           <a href="#." onClick="send_gift(8);" id="gift_8" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
          
          </div>   
          
         
       <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/cake.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_cake')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(9); ?></span></div>
             <?=$this->lang->line('gift_cake_text')?>
             </div>
<a href="#." onClick="send_gift(9);" id="gift_9" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                     
        	
         </div>
        
       <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/coffee-tea.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_coffee')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(10); ?></span></div>
             <?=$this->lang->line('gift_coffee_text')?>
             </div>
<a href="#." onClick="send_gift(10);" id="gift_10" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                     
        	
         </div>
         
         <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/chocolate.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_candy')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(11); ?></span></div>
     
             </div>
<a href="#." onClick="send_gift(11);" id="gift_11" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                     
        	
         </div>         
  
          <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gift-cup.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_cup')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>:
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(12); ?></span></div>
             </div>
<a href="#." onClick="send_gift(12);" id="gift_12" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                     
        	
         </div>        

        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/small-toy.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_toy1')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(13); ?></span></div>
             <?=$this->lang->line('gift_toy1_text')?>
             </div>
<a href="#." onClick="send_gift(13);" id="gift_13" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
           
          
          </div>   
          
         
       <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/big-toy.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_toy2')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(14); ?></span></div>
             <?=$this->lang->line('gift_toy2_text')?>
             </div>
<a href="#." onClick="send_gift(14);" id="gift_14" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                 
         </div>
        
                   
<div id="clear"></div>
         
        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/perfume.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_perf')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number" id="price_15"><?php echo $p[0];?></span></div>
             <?=$this->lang->line('gift_count')?>: <select id="rose_15" onChange="updateFlower(15);"><option value="50">50 ml</option><option value="100">100 ml</option></select>
             <br/>
             <?=$this->lang->line('gift_perf_text')?>
             </div>
<a href="#." onClick="send_gift(15);" id="gift_15" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
           
          
          </div>   
          
         
       <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/spa.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_spa')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(16); ?></span></div>
             <?=$this->lang->line('gift_spa_text')?>
             </div>
<a href="#." onClick="send_gift(16);" id="gift_16" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                 
        	
         </div>
        
       <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/cosmetics.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_cosm')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(17); ?></span></div>
             <?=$this->lang->line('gift_cosm_text')?>
             </div>
<a href="#." onClick="send_gift(17);" id="gift_17" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                 
        	
         </div>          
            
         <div class="col-gift"> 
       
         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/underwear.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_wear')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(18); ?></span></div>
         
             </div>
<a href="#." onClick="send_gift(18);" id="gift_18" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
                 
        	
         </div>

         
        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gift-photo.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_photo')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(19); ?></span></div>
             <?=$this->lang->line('gift_photo_text')?>
             </div>
<a href="#." onClick="send_gift(19);" id="gift_19" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
     
 </div>     
      
       <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gift-phone.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_phone')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(20); ?></span></div>
             <?=$this->lang->line('gift_phone_text')?>
             </div>
<a href="#." onClick="send_gift(20);" id="gift_20" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
     
 </div>  
 
        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gift-notebook.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_note')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(21); ?></span></div>
             <?=$this->lang->line('gift_note_text')?>
             </div>
<a href="#." onClick="send_gift(21);" id="gift_21" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
     
 </div>  
 
   
        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gold.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_gold')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number" id="price_22"><?php echo $j[0];?></span></div>
             <select id="rose_22" onChange="updateFlower(22);"><option value="1">Heart shaped pendant</option><option value="2">Bracelet</option><option value="3">Chain</option><option value="4">Bracelet, Chain and heart shaped pendant</option></select>
             
             </div>
<a href="#." onClick="send_gift(22);" id="gift_22" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
     
 </div>        
                                  
    
        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/english.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_eng')?></div>
             <div class="txt"><?=$this->lang->line('gift_credits')?>: 
             <span class="txt-number"><?php echo $this->mainModel->getGiftPrice(23); ?></span></div>
             <?=$this->lang->line('gift_eng_text')?>
             </div>
<a href="#." onClick="send_gift(23);" id="gift_23" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
     
 </div>  
 

 
        <div class="col-gift">

         <div id="block-gift-foto"> <img src="<?=base_url()?>content/img/gift/gift-special.jpg"> </div>
         <div class="gift-action"><div class="txt"><?=$this->lang->line('gift_spec')?></div>
             <div class="txt"></div>
             <?=$this->lang->line('gift_spec_text')?>
             </div>
<a href="#." onClick="send_gift(24);" id="gift_24" class="gift-button"><p><?=$this->lang->line('gift_choose')?></p></a>
     
 </div> 
  <div id="clear"></div>
</div>      

 
  <div id="clear"></div>   
</div>
</div>
<!--end div content--> 
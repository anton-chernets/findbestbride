<!-- div content -->
<script type="text/javascript">
function hide_show()
{
    var div=document.getElementById("div").style.display;
    var link=document.getElementById("link").innerHTML;
 
    
    if(div=="")div="none";
 
    if(div=="none")
    {
        div="block";
        link="<?=$this->lang->line('profile_prev_photo_hide')?>";
    }
    
    else
    {
        div="none";
        link="<?=$this->lang->line('profile_prev_view_photo')?>";
    }
    
    document.getElementById("div").style.display=div;
    document.getElementById("link").innerHTML=link;
}
</script>
<div id="maket-account-045">
    
    <? if($this->pModel->isNeedAttention($this->selfId) == true):?><div class="pc"><div class="txt"><?=sprintf($this->lang->line('profile_main_need_com'), base_url() . 'my/edit/', base_url() . 'my/photo/')?></div> </div><? endif; ?>
    
    <div class="line">
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="340" height="8px">
        <div class="h2" style="float:left;" align="center"> <?=$this->userInfo['name']?><?if ($this->userInfo['age'] != ''): echo ', '.$this->userInfo['age']; endif;?></div> <div id="status-online"><p>ONLINE NOW</p></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="340" height="8px">
     </div>
     
 <div id="left_column">
        <div id="block-foto"> 
        
        
           <div class="big-foto"><? if($this->userInfo['photo_link'] == ''): ?><img width="342" height="500" src="<?=base_url()?>content/img/no-foto.png"><? else: ?><img src="<?=base_url()?>profiles/photo/user_<?=$this->selfId?>/<?=$this->userInfo['photo_link']?>_342.jpg"><? endif; ?></div>
        
                <div class="profile-id"><?=sprintf($this->lang->line('profile_prev_userid'), $this->selfId)?></div>
                             
        
       <? if ($photo != '0') :?>
		  <div class="s-link"> <a onClick="hide_show();" id="link"><?=$this->lang->line('profile_prev_view_photo')?></a></div>

            <div id="div">
            <? foreach ($photo as $row): ?>
            <div class="small-foto"><img src="<?=base_url()?>/profiles/photo/user_<?=$this->selfId?>/<?=$row['photo_name']?>_105.jpg"></div>
       
             <? endforeach; ?>
             </div>
         <? endif; ?>
          
        </div>
       
             
            
      
 </div>
 
 <div id="content-prof">
<a href="#" class="but-man-ichat"><p>Invite to chat</p></a>
<a href="#" class="but-man-vchat"><p>Invite to chat</p></a>
<a href="#" class="but-man-let"><p>Write a letter</p></a>
 

 <div class="profile-data">
         <div class="col">
          <div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_country')?>:</span><span class="h-txt"> <? $c = userCountry(); echo $c[$this->userInfo['country']]?></span></div>
		 <div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_city')?>:</span><span class="h-txt"> <? echo ($details['city'] != '') ? $details['city'] : $this->lang->line('profile_prev_no_info');?></span></div>
		 <div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_marital')?>:</span><span class="h-txt"><?=$this->assistant->userMaritalStatus($details['marriage'])?></span></div>
		 <div class="row-even"><span class="h"><?=$this->lang->line('profile_edit_children')?>:</span><span class="h-txt"><?=$this->assistant->userChildren($details['children'])?></span></div>
		<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_height')?>:</span><span class="h-txt"><? echo ($details['height'] != '' && $details['height'] != '0') ? getUserHeight($details['height']) : $this->lang->line('profile_prev_no_info');?></span></div>
		<div class="row-even"><span class="h"><?=$this->lang->line('profile_edit_weight')?>:</span><span class="h-txt"><? echo ($details['weight'] != '' && $details['weight'] != '0') ? getUserWeight($details['weight']) : $this->lang->line('profile_prev_no_info');?></span></div>
		<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_eyes')?>:</span><span class="h-txt"><?=$this->assistant->userEyes($details['eyes'])?></span></div>   
		    
          </div>   
         
       <div class="col">            
        	<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_hair')?>:</span><span class="h-txt"><?=$this->assistant->userHair($details['hair'])?></span></div>
			<div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_occup')?>:</span><span class="h-txt"><? echo ($details['occupation'] != '') ? $details['occupation'] : $this->lang->line('profile_prev_no_info');?></span></div>
			<div class="row-odd"><span class="h"><?=$this->lang->line('profile_edit_rel')?>:</span><span class="h-txt"><?=$this->assistant->userReligion($details['religion'])?></span></div>
			<div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_edu')?>:</span><span class="h-txt"><?=$this->assistant->userEdu($details['education'])?></span></div>
			<div class="row-odd"><span class="h"><?=$this->lang->line('profile_prev_smoke')?>:</span> <span class="h-txt"><?=$this->assistant->userSmokeDrink($details['smoke'])?></span></div>
			<div class="row-even"><span class="h"><?=$this->lang->line('profile_prev_drink')?>:</span><span class="h-txt"><?=$this->assistant->userSmokeDrink($details['drink'])?></span></div>
	
			
         </div>
 </div>
 
	<? if($details['hobbies'] != ''): ?>
    <div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_prev_hobby')?></div>
						<?=$details['hobbies']?>
     </div>
     <? endif; ?>
     <? if($details['age_from'] != '' && $details['age_to'] != ''): ?>
     <div class="profile-info">
				<div class="title"><?=$this->lang->line('profile_prev_age')?></div><?=sprintf($this->lang->line('profile_prev_age2'), $details['age_from'], $details['age_to'])?> 
      </div>
      <? endif; ?>
      <? if($details['aoa'] != ''): ?>
      <div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_edit_aoa')?></div>
						<?=$details['aoa']?>
		</div>
		<? endif; ?>
		<? if($details['about_me'] != ''): ?>
       <div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_prev_about_me')?></div>
						<?=$details['about_me']?>
		</div>
		<? endif; ?>
        <? if($details['about_partner'] != ''):?><div class="profile-info">
						<div class="title"><?=$this->lang->line('profile_prev_about_part')?></div>
						<?=$details['about_partner']?><br />

		</div>
		<? endif; ?>
     
                               
    
</div>      


 <div id="clear"></div> 
 <? if($details['age_from'] != '' && $details['age_to'] != '' && $showLike != '0'):?>
 <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="360" height="8px">
        <div class="h2" style="float:left;" align="center"><?=$this->lang->line('profile_prev_like')?></div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="360" height="8px">
     </div>
 <?=$this->load->view('general/user_scroll_bottom')?>
<? endif; ?>
<div id="clear"></div> 

</div>
 
   
<!--end div content-->  


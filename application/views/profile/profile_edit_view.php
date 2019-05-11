<!-- div content -->

<? if ($resInfo): ?>
<script type="text/javascript">                      
showNotification({
    type : "<?=$resInfo['type']?>",
    message: "<?=$resInfo['message']?>",
    autoClose: true,
    duration: "4"
});    
</script>
<? endif; ?>

<script type="text/javascript">
//$(document).ready(function(){
//	$('.select2').selageStyle1();
//	$('.select3').countryStyle1();
//	$('.select5').cusStyle1Date();
//	$('.select6').cusStyle1Month();
//	});
	
</script>

<div id="maket-account-045">
  <? if ($this->pModel->isNeedAttention($this->selfId) == true):?>
    <div class="pc"><div class="txt"><?=sprintf($this->lang->line('profile_main_need_com'), base_url() . 'my/edit/', base_url() . 'my/photo/')?></div> </div>    
  <? endif; ?> 
     <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; margin-left: 40px;" width="410" height="8px">
        <div class="h2" style="float:left;" align="center"> My account</div>
<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px;" width="410" height="8px">
     </div>
     
      <div class="edit-link">
     
   <div class="el"> <a href="<?=base_url()?>my/edit/" class="active-link prof-edit-icon"><h3>Edit profile</h3></a></div>
    <div class="el">   <a href="<?=base_url()?>my/photo/" class="prof-edit-photo-icon"><h3 >My photos</h3></a>  </div>
       <div class="el"> <a href="<?=base_url()?>my/profile/preview/" class="prof-edit-prev-icon"><h3 >Preview profile</h3> </a></div>
       </div>
       
<div class="edit-content">
<form action="" method="POST" class="profile-edit-form">
<input type="hidden" name="changePassword" value="1" />
     
<div class="row-edit-bg">
<hr color="#E84B4B" width="25%">
<p><?=$this->lang->line('profile_edit_acc_info')?></p>
<hr color="#E84B4B" width="25%">
</div>
         <div class="col-edit">
          <div class="row1"><lable><?=$this->lang->line('profile_edit_email')?>: </lable></div>
		  <div class="row2"><b><?=$this->userInfo['email']?></b></div>
		 <div class="row1"><lable><?=$this->lang->line('profile_edit_gender')?>: </lable></div>
		  <div class="row2"><b><? if($this->userInfo['sex'] == 1): echo $this->lang->line('gender_male'); else: echo $this->lang->line('gender_female'); endif;?></b></div>
		
          </div>   
         
       <div class="col-edit">            
        	<div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_new_pwd')?>:</lable></div></div>
            <div class="row2"><input type="password" id="input260" name="password_new" value="" /></div>
			
         </div>
         
              
		<div class="line">
    		<img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; " width="1000" height="8px">   
     	</div>
     	
     	<div id="clear"></div>
     
     	<div class="send-btn">
			<button type="submit" name="sent" class="bt-save"><?=$this->lang->line('profile_edit_save_pwd')?></button>
        </div>
         
         
            
</form>         

<form action="" method="POST" class="profile-edit-form">
<input type="hidden" name="changeProfile" value="1" />
<div class="row-edit-bg">
<hr color="#E84B4B" width="25%">
<p><?=$this->lang->line('profile_edit_pers_info')?></p>
<hr color="#E84B4B" width="25%">
</div>
         
         <div class="col-edit">
          <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_name')?>: </lable></div></div>
                         <div class="row2"><input type="text" id="input260" name="name" value="<?=$this->userInfo['name']?>" /></div>
       
         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_lastname')?>: </lable></div></div>
                         <div class="row2"><input type="text" id="input260" name="lastname" value="<?=$this->userInfo['lastname']?>" /></div>
         
		 
		 <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_country')?>: </lable></div></div>
                  <div class="row2"><?=$ages[16]?></div>
 

                    <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_edu')?>:</lable></div></div>
                     <div class="row2"><?=$ages[3]?>
                     </div>
                     
                     <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_marital')?>:</lable></div></div>
                     <div class="row2"><?=$ages[2]?>     </div>
                  

                  
                  <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_height')?>:</lable></div></div>
                     <div class="row2"><?=$ages[13]?>
                     
                     </div>

                  <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_weight')?>:</lable></div></div>
                     <div class="row2"><?=$ages[14]?>
                     
                     </div>
                                          
                     <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_eyes')?>:</lable></div></div>
                     <div class="row2"><?=$ages[4]?>
                     </div>
                     
                     <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_smoking')?>:</lable></div></div>
                     <div class="row2"><?=$ages[5]?>
                     
                     </div>                                        
                       
         
</div>

<div class="col-edit">
          <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_bday')?>:</lable></div></div>
                         <div class="row2"><?=$ages[11]?><?=$ages[12]?><?=$ages[10]?>
                         </div>
                         
                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_city')?>: 	 </lable></div></div>
                         <div class="row2"><input type="text" id="input260" name="user_city" value="<?=$uDetails['city']?>" /></div>
                         
                         
                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_rel')?>:</lable></div></div>
                     <div class="row2"><?=$ages[7]?>
          </div>
          
                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_occup')?>: </lable></div></div>
                         <div class="row2"><input type="text" id="input260" name="user_occupation" value="<?=$uDetails['occupation']?>" />
                         </div>
                         
                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_children')?>:</lable></div></div>
                     <div class="row2"><?=$ages[8]?></div>


                          <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_hair')?>:</lable></div></div>
                     <div class="row2"><?=$ages[9]?></div>

                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_drinking')?>:</lable></div></div>
                     <div class="row2"><?=$ages[6]?>
             </div>
             
                        <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_hobbies')?>:</lable></div></div>
                         <div class="row2"><input type="text" id="input260" name="user_hobby" value="<?=$uDetails['hobbies']?>" />
                         </div>
                         
                         <? if($this->userInfo['sex'] == 2): ?>
                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_english')?>:</lable></div></div>
                         <div class="row2"><?=$ages[15]?>
                         </div>
                         <? endif; ?>

         
</div>
<div id="clear"></div>  
          
         <div class="row-edit-bg">
		 <hr color="#E84B4B" width="25%">
		 <p><?=$this->lang->line('profile_edit_adv')?></p>
		 <hr color="#E84B4B" width="25%">
		 </div>
         
         <div class="col-edit">
         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_age_from')?>:</lable></div></div>
                         <div class="row2">
                         <div id="in-small"><?=$ages[0]?></div><div class="to"><?=$this->lang->line('profile_edit_age_to')?></div>
                        <div id="in-small"><?=$ages[1]?></div>
                        <div class="yold"><?=$this->lang->line('profile_edit_age_final')?></div>
                         </div>
                         
                         <div class="row1"><div id="txt"><lable><?=$this->lang->line('profile_edit_aoa')?>:</lable></div></div>
                         <div class="row2">
                         <input type="text" id="input260" name="user_aim" value="<?=$uDetails['aoa']?>" />
                         </div>
         
         </div>
         
        	  
  <div id="clear"></div> 
       
          
         
         <div class="col-edit">
          <div id="txt" style="margin-left:10px;"><lable><?=$this->lang->line('profile_edit_aboutme')?>:</lable></div>
		<div>
       <textarea id="msg_account" name="description"><?=$uDetails['about_me']?></textarea>
        </div>
          </div>   
         
       <div class="col-edit">            
        	<div id="txt" style="margin-left:10px;"><lable><?=$this->lang->line('profile_edit_partner')?>:</lable></div>
		<div>
       <textarea id="msg_account" name="partner"><?=$uDetails['about_partner']?></textarea>
        </div>
			
         </div>
         
         <? if($this->userInfo['sex'] == 1):?>
		<div id="clear"></div>
     	<div class="row-edit-bg"><p><?=$this->lang->line('profile_edit_em')?></p></div>
		<div class="col-edit">
          <div id="txt"><label><?=$this->lang->line('profile_edit_email_not')?>:</label></div>
		<div>
        <input type="checkbox" value="1" name="email_notification" <?if($this->userInfo['email_notification'] == 1):?>checked="checked"<?endif;?>/>
        </div>
          </div>   
         
       <div class="col-edit">            
        	<div id="txt"><label><?=$this->lang->line('profile_edit_email_ads')?>:</label></div>
		<div>
       <input type="checkbox" value="1" name="email_ads" <?if($this->userInfo['email_ads'] == 1):?>checked="checked"<?endif;?> />
        </div>
        </div>
     	 
		<div id="clear"></div>
		<?endif; ?>
         
         
         <div class="line" >
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top: 30px; " width="1000" height="8px">
        
     </div>
     
     <div class="send-btn">
		<button type="submit" name="sent" class="bt-save"><?=$this->lang->line('profile_edit_save')?></button>
	
        </div>
         
        
         
        
          
		 
</form>
<? if($this->userInfo['user_status'] == '0' || $this->userInfo['user_status'] == '7'): ?>
<form action="" method="POST" class="profile-edit-form">
<input type="hidden" name="deleteProfile" value="1" />
     
<div class="row-edit-bg">
<hr color="#E84B4B" width="25%">
<p><?=$this->lang->line('profile_edit_delete')?></p>
<hr color="#E84B4B" width="25%">
</div>

     <div id="clear"></div>
     	<div class="send-btn">
			<button type="submit" name="sent" class="bt-save del"><?=$this->lang->line('profile_edit_del_button')?></button>
        </div>
         
         
          <div id="clear"></div>  
</form>
<? elseif ($this->userInfo['user_status'] == '2'):?>  
<form action="" method="POST" class="profile-edit-form">
<input type="hidden" name="restoreProfile" value="1" />
     
<div class="row-edit-bg"><p><?=$this->lang->line('profile_edit_restore')?></p></div>

     <div id="clear"></div>
     	<div class="send-btn">
			<button type="submit" name="sent" class="bt-save"><?=$this->lang->line('profile_edit_res_button')?></button>
        </div>
         
         
          <div id="clear"></div>  
</form>
<? endif; ?>
</div>     


     
    	  
  <div id="clear"></div> 

</div>
  <div id="clear"></div> 
   
<!--end div content-->  
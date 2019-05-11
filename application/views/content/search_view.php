<!-- div content -->
   <script type="text/javascript">
//$(document).ready(function(){
//	$('.select2').selageStyle1();
//	});
	
</script> 
<? if ($result): ?>
<script type="text/javascript">                      
showNotification({
    type : "<?=$result['type']?>",
    message: "<?=$result['message']?>",
    autoClose: true,
    duration: "6"
});    
</script>
<? endif; ?>
<div id="maket">
 <?=$this->load->view('general/user_scroll_bottom')?>
	 <!-- 
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="435" height="8px">  
     
        <span class="h2" style="float:left; ">Search</span>
 <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; " width="435" height="8px">    
     -->
<div id="clear"></div>  

<div id="main-content">
 
<form action="" method="post" class="form-search">
<input type="hidden" value="1" name="new_search">
		
		 <div class="col-edit">
			
			<div class="row1">	<label class="mc-lable"><?=$this->lang->line('search_id')?>:</label></div>
			<div class="row2">	<input type="text" id="inputtxt" name="id" value="" /></div>
				
													
			
			<div class="row1">
				<label class="mc-lable">Age from:</label></div>
				
			<div class="row2">	<div id="sel1">	<select name="age_from" class="select2"><option value="0"></option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">60</option>
</select></div>
					<span id="to">to</span><div id="sel2"> <select name="age_to" class="select2"><option value="0"></option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">60</option>
</select></div>
				
	</div>			
							
			
			
		<div class="row1"><label class="mc-lable">Height from:</label></div>
		<div class="row2">		
				<div id="sel1">	<?=$height_f?></div>
<span id="to">to</span> <div id="sel2"><?=$height_t?></div>
				
	</div>			
					
			
			
	<div class="row1"><label class="mc-lable">Weight from:</label></div>
				
	<div class="row2"><div id="sel2"><?=$weight_f?></div>
<span id="to">to</span> <div id="sel2"><?=$weight_t?></div>
</div>				
			
							
			
					
								
			
	<div class="row1">		
				<label class="mc-lable">Marital status:</label>
		</div>		
	<div class="row2"><select name="marital_status" class="select3"><option value="0"></option>
<option value="1">single</option>
<option value="2">widowed</option>
<option value="3">divorced</option>
<option value="4">never been married</option>
</select>
	</div>			
				
				
<div class="row1"><label class="mc-lable">Level of english:</label></div>
	<div class="row2"><select name="english" class="select3"><option value="0"></option>
<option value="1">don't speak</option>
<option value="2">with difficulties</option>
<option value="3">basic</option>
<option value="4">fluent</option>
</select>
</div>
				
 </div>            
             
             
  <div class="col-edit2">               
                
 <div class="row1"><label class="mc-lable">Eyes color:</label></div>
				
<div class="row2"><select name="eyes_color" class="select3"><option value="0"></option>
<option value="1">green</option>
<option value="2">grey</option>
<option value="3">hazel</option>
<option value="4">brown</option>
<option value="5">black</option>
<option value="6">blue</option>
</select></div>

<div class="row1"><label class="mc-lable">Hair color:</label></div>
<div class="row2"><select name="hair_color" class="select3"><option value="0"></option>
<option value="1">auburn</option>
<option value="2">black</option>
<option value="3">blonde</option>
<option value="4">light brown</option>
<option value="5">dark brown</option>
<option value="6">red</option>
<option value="7">white grey</option>
</select>
</div>

<div class="row1"><label class="mc-lable">Religion:</label></div>
<div class="row2"><select name="religion" class="select3"><option value="0"></option>
<option value="2">Buddhist</option>
<option value="3">Catholic</option>
<option value="1">Christian</option>
<option value="4">Jewish</option>
<option value="5">Muslim</option>
<option value="6">Hindu</option>
<option value="7">none</option>
<option value="8">other</option>
</select>
</div>

<div class="row1"><label class="mc-lable">Children:</label></div>
<div class="row2"><select name="children" class="select3"><option value="0"></option>
<option value="1">none</option>
<option value="2">1</option>
<option value="3">2</option>
<option value="4">3</option>
<option value="5">4</option>
<option value="6">5</option>
</select>
</div>

<div class="row1"><label class="mc-lable">Country:</label></div>
<div class="row2"><?php $this->load->helper('html'); 
echo form_dropdown('country', userCountry(), '0', 'class="select3"');?>
</div>                
				
<div class="row1"><label class="mc-lable">City:</label></div>
<div class="row2"><input type="text" id="inputtxt" name="city" value="" />
</div>				
			
</div>   
<div id="clear"></div>           
			
				
					 <div class="search-btn">
                    <div style="margin-left: 50px; margin-right: 20px;float:left;">	<label class="mc-lable">Online users:</label>
					<input type="checkbox" name="user_online" value="1" />
					</div>
                   
				<button type="submit" name="submit" class="btn-search">Search</button><br>
				<?php if ($is_broadcast == true && $this->userInfo['sex'] == 2 ) { ?>
				<p style="padding-left:180px;">
				<button type="submit" onClick="$('#broadcast').val('1');" class="btn-broad">Broadcast yourself</button>
				</p>
				<?php } ?>
				</div>
				<input type="hidden" name="broadcast" id="broadcast" value="0"/>
				
			
		
	</form>
  

 </div>
 
 </div>
 
<!--end div content-->  

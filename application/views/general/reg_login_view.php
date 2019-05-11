<? if ($this->isAuth == false): ?>
<!--- modal window Login -->
    <div id="popup" class="popup">
  <div class="blok-registration">
     <div class="line">   
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="340" height="8px">  
     
        <span class="h2" style="float:left; "><?=$this->lang->line('l_login')?></span>
 <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; " width="340" height="8px">    
     </div>
 <div id="clear"></div>
<div class="col-edit">
<form action="<?=base_url()?>login/" method="post" class="login-form">
<input type="hidden" value="1" name="loginMe" />
<p><?=$this->lang->line('l_text')?></p>

          <div class="row1"><div id="txt"><label><?=$this->lang->line('l_email')?>: </label></div></div>
                         <div class="row2"><input type="text" id="inputt" name="u_email" value="" /></div>
                        <div class="row1"><div id="txt"><label><?=$this->lang->line('l_pwd')?>:</label></div></div>
                      <div class="row2"><input type="password" id="inputt" name="u_password" value="" /></div>
			<div class="row-checkbox">     
			<input type="checkbox" id="rem" name="rem"  checked="checked" />
			<label class="checkbox"><?=$this->lang->line('l_remember')?></label>
		    </div>
                     <button type="submit" name="submit" class="btn-enter"><?=$this->lang->line('l_button')?></button>
                     
                     <div class="forgot-block">
			 <a href="<?=base_url()?>password/" id="link"><?=$this->lang->line('l_password')?></a>
		</div>
</form>
</div>
</div>
  <div class="btn-close"></div>
</div>
  
  
 <!-- end modal window --> 
 <? $row = $this->mainModel->getRandomProfile(); ?>
  <div id="popup-reg" class="popup-reg">  
 <div class="blok-registration">
     <div class="line">   
    <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; margin-left: 40px;" width="290" height="8px">  
     
        <span class="h2" style="float:left; "><?=$this->lang->line('r_text')?></span>
 <img src="<?=base_url()?>content/img/line.png" style="float:left; margin-top:30px; " width="290" height="8px">    
     </div>
      
 <div id="clear"></div>  
     
<div class="col-reg1">
<a href="<?=base_url()?>user<?=$row['id']?>" class="blok-foto-reg"><img src="<?=base_url()?>profiles/photo/user_<?=$row['id']?>/<?=$row['photo_link']?>_240.jpg"></a>
<div style="text-align:center;"><?=sprintf($this->lang->line('random_name_id'), $row['name'], $row['id'])?></div>
</div>   
<div class="col-reg2">

<form action="<?=base_url()?>/main" method="post" class="registration-form">
<input type="hidden" value="1" name="registerMe" />
<p><?=$this->lang->line('r_text_2')?></p>

          <div class="row3"><div id="txt"><lable> <?=$this->lang->line('r_email')?>:</lable></div></div>
                         <div class="row2"><input type="text" id="input-registration" name="user_email" value="" /></div>
                        
                        <div class="row3"><div id="txt"><lable ><?=$this->lang->line('r_pwd')?>:</lable></div></div>
                      <div class="row2"><input type="password" id="input-registration" name="user_password" value="" /></div>
                      
                      <div class="row3"><div id="txt"><lable><?=$this->lang->line('r_name')?>:</lable></div></div>
                         <div class="row2"><input type="text" id="input-registration" name="user_real_name" value="" /></div>
                   
                   	 <div class="row3"><div id="txt"><lable><?=$this->lang->line('r_lastname')?>:</lable></div></div>
                         <div class="row2"><input type="text" id="input-registration" name="user_lastname" value="" /></div>
                           
                         
                       <div class="row3"><div id="txt"><lable><?=$this->lang->line('r_country')?>: </lable></div></div>
                  <div class="row2"><select name="user_country" class="select3" >
<option value="1">Afghanistan</option>
<option value="2">Albania</option>
<option value="3">Algeria</option>
<option value="4">Am. Samoa</option>
<option value="5">Andorra</option>
<option value="6">Angola</option>
<option value="7">Anguilla</option>
<option value="8">Argentina</option>
<option value="9">Armenia</option>
<option value="10">Aruba</option>
<option value="11">Australia</option>
<option value="12">Austria</option>
<option value="13">Azerbaijan</option>
<option value="14">Bahamas</option>
<option value="15">Bahrain</option>
<option value="16">Bangladesh</option>
<option value="17">Barbados</option>
<option value="18">Belarus</option>
<option value="19">Belgium</option>
<option value="20">Belize</option>
<option value="21">Benin</option>
<option value="22">Bermuda</option>
<option value="23">Bhutan</option>
<option value="24">Bolivia</option>
<option value="25">Bosnia Herz.</option>
<option value="26">Botswana</option>
<option value="27">Bouvet Isl.</option>
<option value="28">Brazil</option>
<option value="29">Brunei</option>
<option value="30">Bulgaria</option>
<option value="31">Burkina Faso</option>
<option value="32">Burundi</option>
<option value="33">Cambodia</option>
<option value="34">Cameroon</option>
<option value="35">Canada</option>
<option value="36">Cape Verde</option>
<option value="37">Cayman Isl.</option>
<option value="38">Cen. Afr. Rep.</option>
<option value="39">Chad</option>
<option value="40">Chile</option>
<option value="41">China</option>
<option value="42">Christmas Isl.</option>
<option value="43">Colombia</option>
<option value="44">Comoros</option>
<option value="45">Congo</option>
<option value="46">Cook Islands</option>
<option value="47">Costa Rica</option>
<option value="48">Cote DIvoire</option>
<option value="49">Croatia</option>
<option value="51">Cyprus</option>
<option value="52">Czech Rep.</option>
<option value="53">Congo</option>
<option value="54">Denmark</option>
<option value="55">Djibouti</option>
<option value="56">Dominica</option>
<option value="57">Dominican Rep.</option>
<option value="58">East Timor</option>
<option value="59">Ecuador</option>
<option value="60">Egypt</option>
<option value="61">El Salvador</option>
<option value="62">England</option>
<option value="63">Equatorial G.</option>
<option value="64">Eritrea</option>
<option value="65">Estonia</option>
<option value="66">Ethiopia</option>
<option value="67">Falkland Isl.</option>
<option value="68">Faroe Isl.</option>
<option value="69">Fiji</option>
<option value="70">Finland</option>
<option value="71">France</option>
<option value="72">Fr. Guiana</option>
<option value="73">Fr. Polynesia</option>
<option value="74">Gabon</option>
<option value="75">Gambia</option>
<option value="76">Georgia</option>
<option value="77">Germany</option>
<option value="78">Ghana</option>
<option value="79">Gibraltar</option>
<option value="80">Greece</option>
<option value="81">Greenland</option>
<option value="82">Grenada</option>
<option value="83">Guadeloupe</option>
<option value="84">Guam</option>
<option value="85">Guatemala</option>
<option value="86">Guinea</option>
<option value="87">Guinea-Bissau</option>
<option value="88">Guyana</option>
<option value="89">Haiti</option>
<option value="90">Honduras</option>
<option value="91">Hong Kong</option>
<option value="92">Hungary</option>
<option value="93">Iceland</option>
<option value="94">India</option>
<option value="95">Indonesia</option>
<option value="97">Iraq</option>
<option value="98">Ireland</option>
<option value="99">Israel</option>
<option value="100">Italy</option>
<option value="101">Jamaica</option>
<option value="102">Japan</option>
<option value="103">Jordan</option>
<option value="104">Kazakhstan</option>
<option value="105">Kenya</option>
<option value="106">Kiribati</option>
<option value="109">Kuwait</option>
<option value="110">Kyrgyzstan</option>
<option value="111">Lao</option>
<option value="112">Latvia</option>
<option value="113">Lebanon</option>
<option value="114">Lesotho</option>
<option value="115">Liberia</option>
<option value="116">Libya</option>
<option value="117">Liechtenstein</option>
<option value="118">Lithuania</option>
<option value="119">Luxembourg</option>
<option value="120">Macao</option>
<option value="121">Macedonia</option>
<option value="122">Madagascar</option>
<option value="123">Malawi</option>
<option value="124">Malaysia</option>
<option value="125">Maldives</option>
<option value="126">Mali</option>
<option value="127">Malta</option>
<option value="128">Marshall Isl.</option>
<option value="129">Martinique</option>
<option value="130">Mauritania</option>
<option value="131">Mauritius</option>
<option value="132">Mayotte</option>
<option value="133">Mexico</option>
<option value="134">Micronesia</option>
<option value="135">Moldova</option>
<option value="136">Monaco</option>
<option value="137">Mongolia</option>
<option value="138">Montserrat</option>
<option value="139">Morocco</option>
<option value="140">Mozambique</option>
<option value="142">Namibia</option>
<option value="143">Nauru</option>
<option value="144">Nepal</option>
<option value="145">Netherlands</option>
<option value="146">New Caledonia</option>
<option value="147">New Zealand</option>
<option value="148">Nicaragua</option>
<option value="149">Niger</option>
<option value="150">Nigeria</option>
<option value="151">Niue</option>
<option value="152">Norfolk Isl.</option>
<option value="153">Norway</option>
<option value="154">Oman</option>
<option value="155">Other</option>
<option value="156">Pakistan</option>
<option value="157">Palau</option>
<option value="158">Panama</option>
<option value="159">Papua new G.</option>
<option value="160">Paraguay</option>
<option value="161">Peru</option>
<option value="162">Philippines</option>
<option value="163">Pitcairn Isl.</option>
<option value="164">Poland</option>
<option value="165">Portugal</option>
<option value="166">Puerto Rico</option>
<option value="167">Qatar</option>
<option value="168">Reunion</option>
<option value="169">Romania</option>
<option value="170">Russia</option>
<option value="171">Rwanda</option>
<option value="172">Saint Lucia</option>
<option value="173">Samoa</option>
<option value="174">San Marino</option>
<option value="175">Saudi Arabia</option>
<option value="176">Scotland</option>
<option value="177">Senegal</option>
<option value="178">Seychelles</option>
<option value="179">Sierra Leone</option>
<option value="180">Singapore</option>
<option value="181">Slovak Rep.</option>
<option value="182">Slovenia</option>
<option value="183">Solomon Isl.</option>
<option value="184">Somalia</option>
<option value="185">South Africa</option>
<option value="186">Spain</option>
<option value="187">Sri Lanka</option>
<option value="188">St Helena</option>
<option value="190">Suriname</option>
<option value="191">Swaziland</option>
<option value="192">Sweden</option>
<option value="193">Switzerland</option>
<option value="195">Taiwan</option>
<option value="196">Tajikistan</option>
<option value="197">Tanzania</option>
<option value="198">Thailand</option>
<option value="199">Togo</option>
<option value="200">Tokelau</option>
<option value="201">Tonga</option>
<option value="202">Trinidad & Tob.</option>
<option value="203">Tunisia</option>
<option value="204">Turkey</option>
<option value="205">Turkmenistan</option>
<option value="206">Tuvalu</option>
<option value="207">Uganda</option>
<option value="208" selected="selected">Ukraine</option>
<option value="209">UAE</option>
<option value="210">United States</option>
<option value="211">Uruguay</option>
<option value="212">Uzbekistan</option>
<option value="213">Vanuatu</option>
<option value="214">Venezuela</option>
<option value="215">Vietnam</option>
<option value="216">Virgin Islands (Br)</option>
<option value="217">Virgin Islands (US)</option>
<option value="218">Wales</option>
<option value="219">West Sahara</option>
<option value="220">Yemen</option>
<option value="221">Yugoslavia</option>
<option value="222">Zambia</option>
<option value="223">Zimbabwe</option>
</select></div>
<div class="row3"><div id="txt"><lable><?=$this->lang->line('r_sex')?>: </lable></div></div>
                  <div class="row2"><select name="user_sex" class="select3" ><option value=""></option>
                  <option value="1"><?=$this->lang->line('r_male')?></option><option value="2"><?=$this->lang->line('r_female')?></option>
                  </select>
                  </div>
<div id="clear"></div>
<p><?=$this->lang->line('r_rules')?> </p>
                      
                     
             
                     
                     <input type="submit" class="btn-enter" value="<?=$this->lang->line('r_button')?>" />
                     
</form>
 

</div>
  
</div> 
<div class="btn-close"></div>
</div>
  

   
<!--end div content-->    
 <? endif; ?>
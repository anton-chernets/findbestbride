<?=$this->load->view('general/head_view')?>

<body>

<!--glavnui div-->    
<div id="container">

<!--- header--->

<?=$this->load->view('general/register_login_buttons_view')?>  

<div id="clear"></div>

</div>
<!--div top menu -->     
<?=$this->load->view('general/head_menu_view');?>
<!-- end div top menu -->    
    
<!-- div img header-->    
    <div id="header">
<script>
$(document).ready(function(){

$('.flicker-example').flicker();
});
</script>

<div class="flicker-example" data-block-text="false">
<ul>
<li data-background="/content/img/slide_01.jpg">
<div class="flick-title"></div>
<div class="flick-sub-text"></div>
</li>
<li data-background="/content/img/slide_02.jpg">
<div class="flick-title"></div>
<div class="flick-sub-text"></div>
</li>
</ul>
</div>
<div id="container">
	 <?=$this->load->view('general/header_registration');?>              
</div>                
  </div>
  
<!--end div img header-->   
<div id="container">
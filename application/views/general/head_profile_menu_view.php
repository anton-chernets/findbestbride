<script type="text/javascript">
$(document).ready(function(){
$('#main_menu a').each(function () {
  if($(this).attr('href') == location.href) $(this).addClass('active');
});
});
</script>
<div class="b-menu">
    <div id="menu">
      <div class="menu__icon">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
        <ul id="main_menu">
		<? if ($this->isAuth == true): ?><li><a href="<?=base_url()?>my/profile/">MY ACCOUNT</a></li><? else: ?><li><a href="#" id="needToLogin">MY ACCOUNT</a></li><? endif; ?>
		<li><? if($this->userInfo['sex'] == 1):?><a href="<?=base_url()?>women_profiles/">WOMEN PROFILES</a><?else:?><a href="<?=base_url()?>men_profiles">MEN PROFILES</a><?endif;?></li>
        <li><a href="<?=base_url()?>search/">SEARCH</a></li>
        <li><a href="<?=base_url()?>page/romance_tours/">ROMANCE TOURS</a></li>
        <li><a href="<?=base_url()?>page/information/">USEFUL INFORMATION</a></li>
        <li><a href="<?=base_url()?>support/">SUPPORT</a></li>
        <li><a href="<?=base_url()?>page/faq/">FAQ</a></li>
    </ul>
    </div>
</div>

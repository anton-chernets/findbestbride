<div class="span9" id="content">
	<div class="row-fluid">
		<div class="span12">
			<div class="block">
            	<div class="navbar navbar-inner block-header">
                	<div class="muted pull-left">Изменить изображение</div>
                </div>
                <div class="block-content collapse in">
                	<div class="span12">
                		<div class="alert alert-info">Чтобы обрезать изображение, выберите область обрезки на изображении и нажмите сохранить. При повороте изображения размер не меняется.</div>
						<?php if (!empty($result)) { ?><div class="alert alert-success"><?=$result?></div><?php } ?>
						<div align="center">
							<img src="<?=$image?>" id="cropbox">
							<br>
							<form action="" method="post" onsubmit="return checkCoords();">
								<input type="hidden" name="crop" value="1" />
								<input type="hidden" id="x" name="x" />
								<input type="hidden" id="y" name="y" />
								<input type="hidden" id="w" name="w" />
								<input type="hidden" id="h" name="h" />
								<button type="submit" class="btn btn-success">Сохранить изменения</button>
							</form>
							<form action="" method="post">
								<input type="hidden" name="rotate" value="1"/>
								<input type="hidden" name="tp" value="left">
								<button type="submit" class="btn btn-success"><i class="icon icon-arrow-left"></i> Повернуть влево</button>
							</form>
							
							<form action="" method="post">
								<input type="hidden" name="rotate" value="1"/>
								<input type="hidden" name="tp" value="right">
								<button type="submit" class="btn btn-success"><i class="icon icon-arrow-right"></i> Повернуть вправо</button>
							</form>
						</div>
                    </div>
                </div>
             </div>
         </div>
	</div>
</div>
</div>

<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
	  bgOpacity: .3,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
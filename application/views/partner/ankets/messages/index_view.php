<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Личные сообщения анкет</h1>
        </div>
    </div>
    <div class="col-lg-12">
    <?php if (!empty($error)) { ?><div class="alert alert-danger"><?=$error?></div><?php } ?>
	<p class="alert alert-warning">Чтение личных сообщений доступно только для активных анкет.</p>
		
		<form method="POST" action="">
			<div class="form-group">
				<label for="a_id">Анкета</label>
				<select id="a_id" name="a_id" class="form-control" style="width:45%;">
					<option value=""></option>
					<?php foreach($this->pModel->activeAnkets($this->partId) as $anket) { ?>
						<option value="<?=$anket['id']?>"><?=$anket['name'].' '.$anket['lastname'];?></option>
					<?php } ?>
				</select>
			</div>
			<div align="center">
            	<button type="submit" id="send" class="btn btn-primary btn-lg">Перейти к чтению</button>
            </div>
		</form>
	</div>
</div>
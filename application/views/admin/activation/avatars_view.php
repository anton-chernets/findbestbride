          <div class="span9" id="content">

                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Активация аватаров</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Профиль</th>
						                  <th>Аватар</th>
						                  <th>Действия</th>
						                </tr>
						              </thead>
						              <tbody>
						              <? foreach($list as $row): 
						              ?>
						                <tr id="b_<?=$row['id'];?>">
						                  <td><? echo $row['name'] . ' ' . $row['lastname'] . '<br>' . '[' . $row['id'].']'; ?></td>
						                  <td><a href="/profiles/photo/user_<?=$row['id'];?>/<?=$row['avatar_act']?>_original.jpg"><img src="/profiles/photo/user_<?=$row['id']?>/<?=$row['avatar_act']?>_100.jpg"></a></td>
						                  <td><button class="btn btn-success btn-mini" onClick="approve(<?=$row['id']?>)">Подтвердить</button><br><br>
										  <button onClick="cancel(<?=$row['id']?>)" class="btn btn-danger btn-mini">Отказать</button>
										  </td>
						                </tr>
						            <? endforeach; ?>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /block -->
                    </div>

                </div>
            </div>
            
      <script type="text/javascript">
            function approve(id)
            {
        		$.ajax({
        			url: '/admin/activation/ajax/avatar_approve/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#b_' + id).remove()
        				}
        			}	
        		});
            }

            function cancel(id)
            {
        		$.ajax({
        			url: '/admin/activation/ajax/avatar_cancel/',
        			type: 'POST',
        			dataType: 'json',
        			data: { id: id },
        			success: function(obj) {
        				if (obj.result == 'success') {
        					$('#b_' + id).remove();
        				}
        			}	
        		});
            }
      </script>

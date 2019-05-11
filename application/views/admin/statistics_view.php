                <div class="span9" id="content">
<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Статистика
                               </div>
                               <div align="right"><form action="" method="post"><select name="type">
                                              <option value="1" <?if($type_now==1):?>selected="selected"<?endif;?>>За всё время</option>
                                              <option value="2" <?if($type_now==2):?>selected="selected"<?endif;?>>За месяц</option>
                                              <option value="3" <?if($type_now==3):?>selected="selected"<?endif;?>>За неделю</option>
                                              <option value="4" <?if($type_now==4):?>selected="selected"<?endif;?>>За сутки</option>
                                            </select><br/>
                                            <button class="btn" type="submit">Показать</button>
                                            </form>                                         
                               </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th></th>
						                  <th></th>
						                </tr>
						              </thead>
						              <tbody>
						                <tr>
						                  <td>Зарегистрировано пользователей</td>
						                  <td><b><?=$register['total']?></b></td>
						                </tr>
						                <tr>
						                  <td>Мужчин</td>
						                  <td><b><?=$register['men']?></b></td>
						                </tr>
						                <tr>
						                  <td>Девушек</td>
						                  <td><b><?=$register['women']?></b></td>
						                </tr>

						                <tr>
						                  <td>Отправлено сообщений</td>
						                  <td><b><?=$messages['total']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Прикреплено вложений</td>
						                  <td><b><?=$messages['attach']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Открыто чатов</td>
						                  <td><b><?=$chat['total']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Сообщений в чатах</td>
						                  <td><b><?=$chat['msg']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Загружено фотографий</td>
						                  <td><b><?=$photo['ph']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Загружено видео-презентаций</td>
						                  <td><b><?=$photo['vid']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Подарено подарков</td>
						                  <td><b><?=$gifts['g']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Куплено романтических туров</td>
						                  <td><b><?=$gifts['rt']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Покупок кредитов мужчинами / удачно</td>
						                  <td><b><?=$credits['total']?> / <?=$credits['luck']?> </b></td>
						                </tr>
						                
						                <tr>
						                  <td>Логов в журнале событий</td>
						                  <td><b><?=$logs?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Обращений в техподдержку</td>
						                  <td><b><?=$partner['tp']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Зарегистрировано партнеров</td>
						                  <td><b><?=$partner['total']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Сделано начислений партнерам</td>
						                  <td><b><?=$partner['add']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Наложено штрафов на партнеров</td>
						                  <td><b><?=$partner['penalty']?></b></td>
						                </tr>
						                
						                 <tr>
						                  <td>Создано анкет партнерами</td>
						                  <td><b><?=$partner['ankets']?></b></td>
						                </tr>
						                
						                <tr>
						                  <td>Создано романтических туров</td>
						                  <td><b><?=$partner['tour']?></b></td>
						                </tr>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>

                </div>
            </div>
            
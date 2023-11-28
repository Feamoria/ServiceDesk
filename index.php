<?php

session_start();

if (isset($_SESSION['user'])==false) {
	header('Location: singin.php');
} else {
//$u=$_SESSION['user']['full_name'];echo "$u  <a href='logout.php'>Выйти</a>";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiceDesk</title>
	<script src="js/jquery-2.2.4.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type='text/javascript' src='jqui/jquery-ui.min.js'></script>
	<link rel='stylesheet' type='text/css' media='screen' href='jqui/jquery-ui.min.css'/>
	<link rel='stylesheet' type='text/css' media='screen' href='jqui/jquery-ui.structure.css'/>
	<!--<link rel='stylesheet' type='text/css' media='screen' href='jqui/jquery-ui.theme.css'/> --!>
	
	<link rel="stylesheet" href="css/singin.css">
	<script src='js/main.js?<?php echo time();?>' type="text/javascript"></script>

	<link rel="stylesheet" href="js/fias-api/jquery.fias.min.css">
	<script src='js/fias-api/jquery.fias.min.js' type="text/javascript"></script>
	<script src='js/api_kladr.js?<?php echo time();?>' type="text/javascript"></script>
	
	
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ServiceDesk</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if ($_SESSION['user']['type'] ==0) 	
            	echo "<li><a href='#' onclick='opn_tack(0)'>Новая заявка</a></li>"
            ?>
            <?php if ($_SESSION['user']['type'] ==1) 
            	echo "<li><a id='btn_add_user' onclick='opn_add_user(1)'>Добавить пользователя</a></li>"
            ?>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <?=$_SESSION['user']['full_name']?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#" onclick='opn_add_user(2)'>Изменить свои данные</a></li>
		<li><a href="logout.php">Выйти</a></li>
              </ul>
            </li>            
            
          </ul>
        </div>
      </div>
    </nav>
<div style="margin: 10px;padding-top: 5px;" id='task_table'>
	<label style="margin-right: 5px;" for='search'>Поиск </label><input id='search' class=''></input>
	<table id='task_table' style='margin: 5px;'  class='table table-bordered'>
	<thead>
              <tr>
                <th># <span id='th_sp' class=''></span></th>
                <th>ФИО Заказчика <span name='th_sp' class=''></span></th>
                <th>Дата/Время Заявки <span name='th_sp' class=''></span></th>
                <th>Компьютер <span name='th_sp' class=''></span></th>
                <th>Статус <span name='th_sp' class=''></span></th>
                <th>Проблема <span name='th_sp' class=''></span></th>
                <th>Исполнитель <span name='th_sp' class=''></span></th>
                <th>#</th>
              </tr>
            </thead>
            <tbody id='task_table_body'>
              
            </tbody>
	</table>
</div>


<div id="fm_add_user"  style="display: none;">
<div class="conteiner">
    <form method="post" id='fm_add_user1' class="">
        <h2 class="form-signin-heading">Пользователь</h2>
      <div class=''>
        <div class='col-md-6'>
        <input type='hidden' name='op' id='op' value='edit'>
        <label class="" for="login">Логин</label>
        <input required="" id="login" class="form-control input-sm" type="text" name="login"  placeholder="Введите логин пользователя">
        <label class="" for="password">Пароль</label>
        <input required="" id="password" class="form-control input-sm" type="password" name="password" placeholder="Введите пароль">
        <label class="" for="fio">ФИО</label>
        <input required="" id="fio" class="form-control input-sm" type="text" name="fio"  placeholder="Введите ФИО пользователя">
        <label class="" for="tel">Телефон</label>
        <input required="" id="tel" class="form-control input-sm" type="text" name="tel"  placeholder="Введите телефон пользователя">
        <label class="" for="type">Тип</label>
        <select id='type' name='type' class="form-control">
        	<option value='0' selected>Заказчик</option>
        	<option value='1' >Исполнитель</option>
        </select>
        
        <button class="btn btn-lg btn-primary btn-block" id="submit_fm_add_user" type="submit">Сохранить</button>
        </div >
        <div id='adr_con' class='col-md-6'>
        	<label class="" for="address">Адрес полный</label>
        	<input id='address' class="form-control input-sm" name="address" type="text" value="" placeholder="Адрес">
        	<div>
        	<div class='col-md-6' style="padding: 0px;">
        	<label class="" for="zip">Индекс</label>
        	<input id='zip' class="form-control input-sm" name="zip" type="text" value="" placeholder="zip">
        	</div>
        	<div class='col-md-6' style="padding-right: 0px;">
        	<label class="" for="region">Регион</label>
        	<input id='region' class="form-control input-sm" name="region" type="text" value="" placeholder="region">
        	</div>
        	</div>
        	<label class="" for="district">Район/Область</label>
        	<input id='district' class="form-control input-sm" name="district" type="text" value="" placeholder="Район/Область">
        	<label class="" for="city">Город/Населённый пункт</label>
        	<input id='city' class="form-control input-sm" name="city" type="text" value="" placeholder="city">
        	<label class="" for="street">Улица</label>
        	<input id='street' class="form-control input-sm" name="street" type="text" value="" placeholder="street">
        	<div>
        	<div class='col-md-4' style="padding: 0px;">
        		<label class="" for="building">Дом</label>
        		<input id='building' class="form-control input-sm" name="building" type="text" value="" placeholder="building">
        	</div>
        	<!--<div class='col-md-4'>
        		<label class="" for="address">Корпус</label>
        		<input id='address' class="form-control input-sm" name="address" type="text" value="" placeholder="Адрес">
        	</div>
        	<div class='col-md-4' style="padding: 0px;">
        		<label class="" for="address">Офис,Квартира</label>
        		<input id='address' class="form-control input-sm" name="address" type="text" value="" placeholder="Адрес">
        	</div> -->
        	</div>
        </div>
        </div>        
    </form>
   </div>
</div>

<div id="fm_tack" style="display: none;">
<div class="conteiner">
    <form method="post" id='fm_tack1' class="">
    	<h2 class="form-signin-heading">Заявка</h2>
	<div class=''>
           <div id='tackMain' class='col-md-6'>
        	<input type='hidden' name='op_tack' id='op_tack' value='edit'>
        	<div id='detTack'>
        	<label>Номер заявки: <span id="N"></span><br>Статус: <span id="status"></span></label><br>
        	<label class="" for="DT_cr">Дата подачи заявки</label>
        	<input disabled="disabled" id="DT_cr" class="form-control" type="text" name="DT_cr">
        	<label class="" for="fio_owner">ФИО Заказчика</label>
        	<input disabled="disabled" id="fio_owner" class="form-control" type="text" name="fio_owner">
        	<label class="" for="fio_executor">ФИО Исполнителя</label>
        	<input disabled="disabled" id="fio_executor" class="form-control" type="text" name="fio_executor">
        	
        	</div>
        	<label class="" for="PC">Компьютер</label>
        	<input required="" id="PC" class="form-control" type="text" name="PC" placeholder="Введите инвентарный компьютера">
        	<input id="PC_id" type="hidden" name="PC_id">
        	<label class="" for="message">Проблема</label>
        	<textarea required="" class="form-control " id="message" name="message" placeholder="Опишите проблему"></textarea>
        	<button class="btn btn-lg btn-primary btn-block" id="btn_fm_tack" type="submit">Сохранить</button> 
        	</div>
        	<div id='detTack2' class='col-md-6'>
        		<div class="">
  				<div id='task_log' class="row"></div>
  				<div id='task_mess'class="row"></div>
        	</div>
        </div>
        
        
               
    </form>
   </div>
</div>


</body>
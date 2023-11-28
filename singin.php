<?php 
session_start();
//a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3
//a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3
if (isset($_POST['login'])) {
	require_once 'connect.php';
	$login=mysqli_real_escape_string($connect,$_POST['login']);
	$pass = hash('sha256', $_POST['password']);
	$SQL="SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'";
	$check_user = mysqli_query($connect,$SQL) or $_SESSION["messageSQL"]=mysqli_error($connect);
	if (mysqli_num_rows($check_user) > 0) {
		$user = mysqli_fetch_assoc($check_user);
		$_SESSION['user'] = [
            		"id" => $user['id'],
	            	"full_name" => $user['fio'],
            		"type" => $user['role']
        	];
        	 header('Location: index.php');
	} else {
		$_SESSION['message'] = "Не верный логин или пароль";
	}
} 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
	<script src="js/jquery-2.2.4.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/singin.css">
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="conteiner">
    <form method="post" class="form-signin">
        <h2 class="form-signin-heading">Авторизация </h2> <br><br>
        <label class="sr-only" for="login">Логин</label>
        <input required="" id="login" class="form-control" type="text" name="login"  placeholder="Введите логин пользователя">
        <label class="sr-only" for="password">Пароль</label>
        <input required="" id="password" class="form-control" type="password" name="password" placeholder="Введите пароль">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>        
    </form>
    <?php
    	if (isset($_SESSION['message'])) {
    	
    	echo	"<div class='alert alert-danger' role='alert'>
        	<strong>Ошибка!</strong> {$_SESSION["message"]} 
      		</div>";
      	unset ($_SESSION['message']);
      	}
      	if (isset($_SESSION['messageSQL'])) {
 
    	echo	"<div class='alert alert-danger' role='alert'>
        	<strong>Ошибка!</strong> {$_SESSION["messageSQL"]}
      		</div>";
      	unset ($_SESSION['messageSQL']);
      	}
    ?>
</div>
</body>
</html>


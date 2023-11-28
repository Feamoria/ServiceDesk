<?php
$host = 'localhost';  // Хост
$user = 'root';    // Имя созданного вами пользователя
$pass = 'f15142342'; // Установленный вами пароль пользователю
$db_name = 'ServiceDesk';  // Имя базы данных
$connect = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

if (!$connect) {
    die('Error connect to database!');
}
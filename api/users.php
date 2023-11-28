<?php
//login=&password=&fio=&tel=&type=0
	session_start();
	$ret=[];
	if (isset($_SESSION['user'])==false) { 
		$ret['mess']='Login Error';
		die(json_encode($ret));
	}
	if (isset($_GET['add']) and ($_SESSION['user']['type']==0) ) { 
		$ret['mess']=' 403 Forbidden';
		die(json_encode($ret));
	}
	/*if ($_SESSION['user']['type']==0) { 
		$ret['mess']='Login Error';
		die(json_encode($ret))
	}*/
	require_once '../connect.php';
	if (isset($_POST['login'])){
		$passIsEmpty=false;
		$login=mysqli_real_escape_string($connect,$_POST['login']);
		$password=mysqli_real_escape_string($connect,$_POST['password']);
		$fio=mysqli_real_escape_string($connect,$_POST['fio']);
		$tel=mysqli_real_escape_string($connect,$_POST['tel']);
		$type=mysqli_real_escape_string($connect,$_POST['type']);
		$address=mysqli_real_escape_string($connect,$_POST['address']);
		if ($password == '') $passIsEmpty =true;
		$password = hash('sha256', $_POST['password']);
	}
	if (isset($_GET['add'])) {
		$SQL = "INSERT INTO users (login,pass,fio,telephone,role) VALUES
		('$login','$password','$fio','$tel','$type');";
	}
	if (isset($_GET['edit'])) {
		$SQL_PASS='';
		if (!$passIsEmpty) {$SQL_PASS="`pass`='$password',";}
		$SQL = "UPDATE `users` SET 
		`login`='$login',
		$SQL_PASS
		`fio`='$fio',
		`address`='$address',
		`telephone`='$tel',
		`role`='$type' WHERE `id`={$_SESSION['user']['id']};
		";
	}
	if (isset($_GET['get'])) {
		$SQL = "SELECT id,fio,login,address,telephone,role from users where id=".$_SESSION['user']['id'];
	}
	if (isset($_GET['GetEx'])) {
		$SQL = "SELECT id,fio from users where role=1";
	}
	
	$result = mysqli_query($connect,$SQL);
	if (!$result) {
		$ret['mess']=mysqli_error($connect);
		$ret['sql']=$SQL;
		die(json_encode($ret));
	}
	if (isset($_GET['get']) or isset($_GET['GetEx']) ) {
		//$ret['data']=mysqli_fetch_assoc($result);
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$ret['data'][]=$row;
		}
	}
	
	
	$ret['ok']=1;
	die(json_encode($ret));
	
	
	
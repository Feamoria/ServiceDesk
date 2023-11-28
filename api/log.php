<?php
	session_start();
	require_once '../connect.php';
	$ret=[];
	$SQL='';
	if (isset($_GET['show_log'])){
		$id=mysqli_real_escape_string($connect,$_POST['id']);
		$SQL="SELECT * FROM log where id_tack=$id order by dt_status desc";
		$ret['result']='ok';
	}
	if (isset($_GET['show_comment'])){
		$id=mysqli_real_escape_string($connect,$_POST['id']);
		$SQL="SELECT comment.*,users.fio  FROM comment, users where users.id=comment.id_user and id_tack=$id order by dt_message";
		$ret['result']='ok';
	}
	if (isset($_GET['set_mess'])){
		$id=mysqli_real_escape_string($connect,$_POST['id']);
		$mess=mysqli_real_escape_string($connect,$_POST['mess']);
		$SQL="INSERT INTO `comment`( `id_tack`, `id_user`, `message`) VALUES ('$id','{$_SESSION['user']['id']}','$mess')";
		$ret['result']='ok';
	
	}
	
	if ($SQL=='') {
		$ret['mess']='api command not found';
		$ret['result']='error';
		die(json_encode($ret));
	}
	$result = mysqli_multi_query($connect,$SQL);
	if (!$result) {
		$ret['mess']=mysqli_error($connect);
		$ret['sql']=$SQL;
		$ret['result']='error';
		die(json_encode($ret));
	} 
	/*if ($result == true) {
		die(json_encode($ret));
	}*/
	$result=mysqli_use_result($connect);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$ret['data'][]=$row;
		}
	die(json_encode($ret));
		

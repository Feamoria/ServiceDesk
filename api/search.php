<?php
	session_start();
	require_once '../connect.php';
	$ret=[];
	if (isset($_GET['InvPC'])){
		$term=mysqli_real_escape_string($connect,$_GET['term']);
		$SQL="SELECT * FROM pc where inv like '%$term%'";
	}
	
	$result = mysqli_query($connect,$SQL);
	if (!$result) {
		$ret['mess']=mysqli_error($connect);
		$ret['sql']=$SQL;
		die(json_encode($ret));
	}
	$i=0;
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$ret[$i]['id']=$row['id_pc'];
		$ret[$i]['label']=$row['inv'].' в '.$row['place'];
		$ret[$i]['value']=$row['inv'];
		$i++;
		
	}
	die(json_encode($ret));

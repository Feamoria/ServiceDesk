<?php

//add - создать зявку
//edit - изменить зявку
//show - вывести заявку(и)

	session_start();
	require_once '../connect.php';
	$ret=[];
	$SQL='';
	if ($_POST['op_tack']=='add'){
		$PC=mysqli_real_escape_string($connect,$_POST['PC_id']);
		$message=mysqli_real_escape_string($connect,$_POST['message']);
		$SQL="INSERT INTO `tack`( `id_owner`, `id_pc`, `message`) VALUES 
		('{$_SESSION['user']['id']}','$PC','$message');
		INSERT INTO `log` (id_tack,status) VALUES (LAST_INSERT_ID(),0);
		";
		$ret['result']='ok';
	}
	if ($_POST['op_tack']=='chg_st'){
		$id=mysqli_real_escape_string($connect,$_POST['id']);
		$st=mysqli_real_escape_string($connect,$_POST['st']);
		$SQL="INSERT INTO `log`( `id_tack`, `status`) VALUES ('$id','$st')";
		$ret['result']='ok';
	}
	if ($_POST['op_tack']=='chg_ex'){
		$id=mysqli_real_escape_string($connect,$_POST['id']);
		$ex=mysqli_real_escape_string($connect,$_POST['ex']);
		$SQL="UPDATE `tack` 
			SET `id_executor`='$ex'
			 WHERE `id_tack`=".$id;
		$ret['result']='ok';
	}
	
	if ($_POST['op_tack']=='show'){
		/*$PC=mysqli_real_escape_string($connect,$_POST['PC']);
		$message=mysqli_real_escape_string($connect,$_POST['message']);*/
		$where_con = [];
		
		if ($_SESSION['user']['type']==0){
			$where_con[] = "`tack`.id_owner=".$_SESSION['user']['id'];
		}
		if (isset($_POST['id'])) {
			$where_con[] = '`tack`.`id_tack`= '.$_POST['id'];
		}
		if (isset($_POST['search'])) {
			if ($_POST['search']!=''){
				$str=explode(' ',$_POST['search']);
				foreach ($str as $key => $value) {
					$where_con[] = " CONCAT_WS('',`tack`.`id_tack`,u1.fio,u2.fio,tack.DT_create,pc.inv,pc.place,log.status,tack.message) like '%$value%'";
				}
			}
			//$where_con[] = '`tack`.`id_tack`= '.$_POST['id'];
		}
		
		$where_sql='';
		if (count($where_con)>0) {
			$where_sql='where '.implode(' and ',$where_con);
			
			
			
		}
		$SQL="SELECT `tack`.`id_tack` as N,
			u1.fio as FIO_owner,
			u2.fio as FIO_executor,
			tack.DT_create,
			pc.inv, pc.place,
			log.status,tack.message
			FROM `tack` 
			LEFT JOIN users as u1 on `tack`.id_owner=u1.id
			left JOIN users as u2 on `tack`.id_executor=u2.id
			LEFT JOIN (SELECT log.id_tack, MAX(`status`) as `status`  from log GROUP by id_tack ) 
				as log on `tack`.id_tack=log.id_tack
			LEFT JOIN pc on `tack`.`id_pc`=pc.id_pc
			$where_sql
			order by tack.DT_create DESC";
		$ret['result']='ok';
		$ret['SQL']=$SQL;
		$ret['type_user']=$_SESSION['user']['type'];
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
	$result=mysqli_use_result($connect);
	
	if ($_POST['op_tack']=='show'){
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$ret['data'][]=$row;
		}
	}
	die(json_encode($ret));
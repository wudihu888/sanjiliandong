<?php
/**
 */
define('IN_DOUCO', true);

require (dirname(__FILE__) . '/include/init.php');

$res = $_REQUEST['res'];
if($res=='city'){

	$pid = $_REQUEST['pid'];
	//查询城市
	$sql = "select*from" .$dou->table('city') . "where pid=".$pid;
	$query = $dou->query($sql);
	while($row = $dou->fetch_array($query)){
		$city[] = array(
				'id'=>$row['id'],
				'name'=>$row['name'],
		);
	}

	$html = '';
	foreach($city as $k=>$v){
		$html.= '  <option value ="'.$v['id'].'" >'.$v['name'].'</option>';
	}
	echo json_encode($html);
}elseif($res=='qv'){

	$pid = $_REQUEST['pid'];
	$sql = "select * from".$dou->table('city')."where pid=".$pid;
	$query = $dou->query($sql);
	while($row = $dou->fetch_array($query)){
		$qv[] =array(
			'id'=>$row['id'],
			'name'=>$row['name'],
		);
	}

	$html = '';
	foreach ($qv as $k => $v) {
		 $html.= '<option value ="'.$v['id'].'" >'.$v['name'].'</option>';
	}

	echo json_encode($html);
}elseif($res=='tj'){
		$dizhi = $_POST['sheng'].$_POST['shi'].$_POST['qv'];
		$add_time =time();
		$sql = "INSERT INTO " . $dou->table('guestbook') . " (id, name, tel, qq,content, add_time)" . " VALUES (NULL,'$_POST[name]', '$_POST[tel]', '$_POST[qq]', '$dizhi','$add_time')";
		echo $sql;
		if($dou->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
 }
 
?>
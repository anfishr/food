<?php
include("fooddb.php");
include('foodclass_find.php');

$data123 = $_POST;

$user = $data123["user"] ?: '';
$fbm = $data123["fbm"] ?: 0;
$ht = $data123["ht"] ?: 0;
$bg = $data123["bg"] ?: 0;
$nn = $data123["nn"] ?: 0;
//$ip = $data123["ip"] ?: 0;

$ip = $_SERVER['REMOTE_ADDR'];

//验证人
if ($user == "") {
	echo json_encode(['code'=>2,'msg'=>'请输入正确的领取人！']);
	return;
	//echo "<script> alert('请输入正确的领取人！');window.location.href='food.php'; </script>";
	//exit;
}

//验证只能输入中文
if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $user) <= 0){
    echo json_encode(['code'=>2,'msg'=>'请输入你的中文姓名！']);
    return;
}

//验证时间，19:30前不能领取食物
date_default_timezone_set('Asia/Shanghai'); 
$time = time();

$t1 = date('H:i', $time);
$t2 = "8:30";

 if(strtotime($t1)<strtotime($t2)) {
 	echo json_encode(['code'=>2,'msg'=>'还未到吃零食的时间！请19:30后再来！']);
	return;
  //echo "<script> alert('还未到吃零食的时间！请19:30后再来！');window.location.href='food.php';</script>";
 // exit;
 }

//验证什么都不领
if ($fbm == 0 and $ht == 0 and $bg == 0 and $nn == 0) {
	echo json_encode(['code'=>2,'msg'=>'你什么都不吃，就点提交了，这是不行的！']);
	return;
}

//取出总量
$num_find = new find();
$total_fbm = $num_find->total("fbm");
$total_ht = $num_find->total("ht");
$total_bg = $num_find->total("bg");
$total_nn = $num_find->total("nn");


//print_r($total_fbm);
//验证取出的食物不能大于库存
if ($fbm > $total_fbm or $ht > $total_ht or $bg > $total_bg or $nn > $total_nn) {
	echo json_encode(['code'=>2,'msg'=>'请注意，您领取的食物大于现有数量！']);
	return;
	//echo "<script> alert('请注意，您领取的食物大于现有数量！');window.location.href='food.php';</script>";
	//exit;
}

$sql = "insert into `detail` (`time`, `ip`, `user`, `fbm`, `ht`, `bg`, `nn`) values ('{$time}','{$ip}','{$user}',{$fbm},'{$ht}','{$bg}','{$nn}')";

$mysqli_result = $db->query($sql);

if ($mysqli_result == false) {
	echo "SQL错误!";
	exit;
}


$db->query("update totalfood set total = ($total_fbm - $fbm) where name = 'fbm'");
$db->query("update totalfood set total = ($total_ht - $ht) where name = 'ht'");
$db->query("update totalfood set total = ($total_bg - $bg) where name = 'bg'");
$db->query("update totalfood set total = ($total_nn - $nn) where name = 'nn'");

echo json_encode(['code'=>1,'msg'=>'领取成功！']);
	return;
?>
<?php
include("fooddb.php");
include("food.php");

$data123 = $_POST;

$user = $data123["user"];
$fbm = $data123["fbm"];
$ht = $data123["ht"];
$bg = $data123["bg"];
$nn = $data123["nn"];


//验证人
if ($user == "") {
	echo "<script> alert('请输入正确的领取人！');window.location.href='food.php';</script>";
	exit;
}

//验证时间，19:30前不能领取食物
date_default_timezone_set('Asia/Shanghai'); 
$time = time();

$t1 = date('H:i', $time);
$t2 = "8:30";

 if(strtotime($t1)<strtotime($t2)) {
  echo "<script> alert('还未到吃零食的时间！请19:30后再来！');window.location.href='food.php';</script>";
  exit;
 }

//验证取出的食物不能大于库存
if ($fbm > $total_fbm or $ht > $total_ht or $bg > $total_bg or $nn > $total_nn) {
	echo "<script> alert('请注意，您领取的食物大于现有数量！');window.location.href='food.php';</script>";
	exit;
}

$sql = "insert into detail (time, user, fbm, ht, bg, nn) values ('{$time}','{$user}','{$fbm}','{$ht}','{$bg}','{$nn}')";

$mysqli_result = $db->query($sql);
if ($mysqli_result == false) {
	echo "SQL错误！";
	exit;
}


$db->query("update totalfood set total = ($total_fbm - $fbm) where name = 'fbm'");
$db->query("update totalfood set total = ($total_ht - $ht) where name = 'ht'");
$db->query("update totalfood set total = ($total_bg - $bg) where name = 'bg'");
$db->query("update totalfood set total = ($total_nn - $nn) where name = 'nn'");

echo "<script> alert('领取成功！');window.location.href='food.php';</script>";
?>
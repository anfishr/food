<?php
include("fooddb.php");
include("foodadmin.php");

$data321 = $_POST;


$fbm = $data321["fbm"];
$ht = $data321["ht"];
$bg = $data321["bg"];
$nn = $data321["nn"];



$db->query("update totalfood set total = ($total_fbm + $fbm) where name = 'fbm'");
$db->query("update totalfood set total = ($total_ht + $ht) where name = 'ht'");
$db->query("update totalfood set total = ($total_bg + $bg) where name = 'bg'");
$db->query("update totalfood set total = ($total_nn + $nn) where name = 'nn'");

$time = time();
$sql = "insert into totaldetail (time, fbm, ht, bg, nn) values ('{$time}','{$fbm}','{$ht}','{$bg}','{$nn}')";

$mysqli_result = $db->query($sql);
if ($mysqli_result == false) {
	echo "SQL错误！";
	exit;
} else {
	echo "<script> alert('入库成功！');window.location.href='foodadmin.php';</script>";
}
?>
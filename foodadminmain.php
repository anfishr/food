<?php
include("fooddb.php");
include("foodadmin.php");


$data321 = $_POST;

$fbm = $data321["fbm"];
$ht = $data321["ht"];
$zsbg = $data321["zsbg"];
$nn = $data321["nn"];
$ld = $data321["ld"];
$slf = $data321["slf"];
$ccs = $data321["ccs"];
$mb = $data321["mb"];


if ($fbm == 0 and $ht == 0 and $zsbg == 0 and $nn == 0 and $ld == 0 and $slf == 0 and $ccs == 0 and $mb == 0) {
    echo "<script> alert('不能0库存入库！');window.location.href='foodadmin.php';</script>";
}


$db->query("update totalfood set total = ($total_fbm + $fbm) where name = 'fbm'");
$db->query("update totalfood set total = ($total_ht + $ht) where name = 'ht'");
$db->query("update totalfood set total = ($total_zsbg + $zsbg) where name = 'zsbg'");
$db->query("update totalfood set total = ($total_nn + $nn) where name = 'nn'");
$db->query("update totalfood set total = ($total_ld + $ld) where name = 'ld'");
$db->query("update totalfood set total = ($total_slf + $slf) where name = 'slf'");
$db->query("update totalfood set total = ($total_ccs + $ccs) where name = 'ccs'");
$db->query("update totalfood set total = ($total_mb + $mb) where name = 'mb'");


date_default_timezone_set('Asia/Shanghai');
$time = time();

//导入数据库当前时间
$datetime = date("Y-m-d H:i:s",time());

$sql = "insert into totaldetail (time, datetime,fbm, ht, zsbg, nn, ld, slf, ccs, mb) 
        values ('{$time}','{$datetime}','{$fbm}','{$ht}','{$zsbg}','{$nn}','{$ld}','{$slf}','{$ccs}','{$mb}')";

$mysqli_result = $db->query($sql);
if ($mysqli_result == false) {
	echo "SQL错误！";
	exit;
} else {
	echo "<script> alert('入库成功！');window.location.href='foodadmin.php';</script>";
}
?>
<?php
include("fooddb.php");
include('foodclass_find.php');

$data123 = $_POST;

$user = $data123["user"] ?: '';
$fbm = $data123["fbm"] ?: 0;
$ht = $data123["ht"] ?: 0;
$zsbg = $data123["zsbg"] ?: 0;
$nn = $data123["nn"] ?: 0;
$ld = $data123["ld"] ?: 0;
$slf = $data123["slf"] ?: 0;
$ccs = $data123["ccs"] ?: 0;
$mb = $data123["mb"] ?: 0;

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

//导入数据库当前时间
$datetime = date("Y-m-d H:i:s",time());

$t1 = date('H:i', $time);
$t2 = "8:30";

 if(strtotime($t1)<strtotime($t2)) {
 	echo json_encode(['code'=>2,'msg'=>'还未到吃零食的时间！请19:30后再来！']);
	return;
  //echo "<script> alert('还未到吃零食的时间！请19:30后再来！');window.location.href='food.php';</script>";
 // exit;
 }

//验证什么都不领
if ($fbm == 0 and $ht == 0 and $zsbg == 0 and $nn == 0 and $ld == 0 and $slf == 0 and $ccs == 0 and $mb == 0) {
	echo json_encode(['code'=>2,'msg'=>'你什么都不吃，就点提交了，这是不行的！']);
	return;
}

//取出总量
$num_find = new find();
$total_fbm = $num_find->total("fbm");
$total_ht = $num_find->total("ht");
$total_zsbg = $num_find->total("zsbg");
$total_nn = $num_find->total("nn");
$total_ld = $num_find->total("ld");
$total_slf = $num_find->total("slf");
$total_ccs = $num_find->total("ccs");
$total_mb = $num_find->total("mb");

//echo $total_ccs ;
//验证取出的食物不能大于库存
if ($fbm > $total_fbm or $ht > $total_ht or $zsbg > $total_zsbg or $nn > $total_nn or $ld > $total_ld or $slf > $total_slf or $ccs > $total_ccs
	or $mb > $mb) {

	echo json_encode(['code'=>2,'msg'=>'请注意，您领取的食物大于现有数量！']);
	return;
	//echo "<script> alert('请注意，您领取的食物大于现有数量！');window.location.href='food.php';</script>";
	//exit;
}

$sql = "insert into `detail` (time,datetime, ip, user, fbm, ht, zsbg, nn, ld, slf, ccs, mb) 
        values ('{$time}','{$datetime}','{$ip}','{$user}',{$fbm},'{$ht}','{$zsbg}','{$nn}','{$ld}','{$slf}','{$ccs}','{$mb}')";

$mysqli_result = $db->query($sql);

if ($mysqli_result == false) {
	echo "SQL错误!";
	exit;
}


$db->query("update totalfood set total = ($total_fbm - $fbm) where name = 'fbm'");
$db->query("update totalfood set total = ($total_ht - $ht) where name = 'ht'");
$db->query("update totalfood set total = ($total_zsbg - $zsbg) where name = 'zsbg'");
$db->query("update totalfood set total = ($total_nn - $nn) where name = 'nn'");
$db->query("update totalfood set total = ($total_ld - $ld) where name = 'ld'");
$db->query("update totalfood set total = ($total_slf - $slf) where name = 'slf'");
$db->query("update totalfood set total = ($total_ccs - $ccs) where name = 'ccs'");
$db->query("update totalfood set total = ($total_mb - $mb) where name = 'mb'");

echo json_encode(['code'=>1,'msg'=>'领取成功！']);
	return;
?>
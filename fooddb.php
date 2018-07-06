<?php
$host = "190.168.0.14";
$dbuser = "wsadmin";
$password = "xast890567??";
$dbname = "db_ajc_food";

$db = new mysqli($host, $dbuser, $password, $dbname);
if ($db->connect_errno != 0) {
	die("连接数据库失败！");
}
$db->query("set names UTF8");
?>
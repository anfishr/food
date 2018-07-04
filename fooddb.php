<?php
$host = "127.0.0.1";
$dbuser = "root";
$password = "";
$dbname = "food";

$db = new mysqli($host, $dbuser, $password, $dbname);
if ($db->connect_errno != 0) {
	die("连接数据库失败！");
}
$db->query("set names UTF8");
?>
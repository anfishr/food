<?php
//查找total的总库存
class find {
    function total($fbm) {
        $host = "127.0.0.1";
        $dbuser = "root";
        $password = "";
        $dbname = "food";

        $db = new mysqli($host, $dbuser, $password, $dbname);
        if ($db->connect_errno != 0) {
            die("连接数据库失败！");
        }
        $db->query("set names UTF8");

        $sql = "select total from totalfood where name='{$fbm}'";

        $total_result = $db->query($sql);

        if ($total_result == false) {
            echo "SQL错误！";
            exit;
        }
        $total_array = $total_result->fetch_array(MYSQL_ASSOC);

        $total = $total_array['total'];
       
        return $total;
        
        }
}

?>
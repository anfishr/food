<?php
//查找total的总库存
class find {
    function total($fbm) {
        include("fooddb.php");

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
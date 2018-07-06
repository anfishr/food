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

        $row=mysqli_fetch_array($total_result,MYSQLI_NUM);
        return $row[0];

        
        
        }
}

?>
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

        $row = mysqli_fetch_array($total_result,MYSQLI_ASSOC);
        return $row['total'];
        }
}

class stack {

    function ls($fbm,$start_time) {

        include("fooddb.php");
        //fbm上月库存
        $sql = "select sum(`{$fbm}`) as total from totaldetail where time <= $start_time";//初始入库，到查询时间之前的总量

        $mysqli_result = $db->query($sql);

        $total_array = mysqli_fetch_array($mysqli_result,MYSQLI_ASSOC);
        $st_total_fbm = $total_array['total'];

        $sql = "select sum(`{$fbm}`) as total from detail where time <= $start_time";//初始入库，到查询时间之前吃的总量
        $mysqli_result = $db->query($sql);
        $total_array = mysqli_fetch_array($mysqli_result,MYSQLI_ASSOC);

        $st_eat_fbm = $total_array['total'];

        $result = $st_total_fbm - $st_eat_fbm;//总量减去吃的总量等于上月库存
        return $result;

    }

    function is($fbm,$start_time,$end_time) {

        include("fooddb.php");
        //本月入库
        $sql = "select sum(`{$fbm}`) as total from totaldetail where time > $start_time and time <= $end_time";
        $mysqli_result = $db->query($sql);
        $total_array = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);
        $result = $total_array['total'];
        return $result;
    }

    function os($fbm,$start_time,$end_time) {

        include("fooddb.php");
        //本月领用
        $sql = "select sum(`{$fbm}`) as total from detail where time > $start_time and time <= $end_time";
        $mysqli_result = $db->query($sql);
        $total_array = mysqli_fetch_array($mysqli_result,MYSQLI_ASSOC);
        $result = $total_array['total'];
        return $result;
    }

    function ts($fbm,$end_time) {

        include("fooddb.php");
        //本月库存
        $sql = "select sum(`{$fbm}`) as total from totaldetail where time <= $end_time";//初始入库，到查询时间之后的总量
        $mysqli_result = $db->query($sql);
        $total_array = mysqli_fetch_array($mysqli_result,MYSQLI_ASSOC);
        $en_total_fbm = $total_array['total'];

        $sql = "select sum(`{$fbm}`) as total from detail where time <= $end_time";//初始入库，到查询时间之后吃的总量
        $mysqli_result = $db->query($sql);
        $total_array = mysqli_fetch_array($mysqli_result,MYSQLI_ASSOC);
        $en_eat_fbm = $total_array['total'];

        $result = $en_total_fbm - $en_eat_fbm;//总量减去吃的总量等于现有库存
        return $result;
    }
}
?>
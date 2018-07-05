<?php
include('foodclass_find.php');

//取出各个食物的库存
$num_fbm = new find();
$total_fbm = $num_fbm->total("fbm");

$num_ht = new find();
$total_ht = $num_ht->total("ht");

$num_bg = new find();
$total_bg = $num_bg->total("bg");

$num_nn = new find();
$total_nn = $num_fbm->total("nn");


//连接数据库，获取上月库存
//$lsfbm = new laststack();
//$last_stok_fbm = $lsfbm->ls("fbm");
if(isset($_POST["starttime"])&&$_POST["endtime"]) {

$st = $_POST["starttime"];
$et = $_POST["endtime"];


$start_time = strtotime("$st");
$end_time = strtotime("$et");

$host = "127.0.0.1";
$dbuser = "root";
$password = "";
$dbname = "food";
$db = new mysqli($host, $dbuser, $password, $dbname);

if ($db->connect_errno != 0) {
    echo "连接失败:";
    echo $db->connect_error;
    exit;
}
$db->query("set names UTF8");


//fbm上月库存
$sql = "select sum(fbm) as total from totaldetail where time <= $start_time";//初始入库，到查询时间之前的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_total_fbm = $total_array['total'];

$sql = "select sum(fbm) as total from detail where time <= $start_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_eat_fbm = $total_array['total'];

$last_stack_fbm = $st_total_fbm - $st_eat_fbm;//总量减去吃的总量等于现有库存


//本月入库
$sql = "select sum(fbm) as total from totaldetail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$in_stack_fbm = $total_array['total'];

//本月领用
$sql = "select sum(fbm) as total from detail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$out_stack_fbm = $total_array['total'];

//本月库存
$sql = "select sum(fbm) as total from totaldetail where time <= $end_time";//初始入库，到查询时间之后的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_total_fbm = $total_array['total'];

$sql = "select sum(fbm) as total from detail where time <= $end_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_eat_fbm = $total_array['total'];

$this_stack_fbm = $en_total_fbm - $en_eat_fbm;//总量减去吃的总量等于现有库存




//ht上月库存
$sql = "select sum(ht) as total from totaldetail where time <= $start_time";//初始入库，到查询时间之前的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_total_ht = $total_array['total'];

$sql = "select sum(ht) as total from detail where time <= $start_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_eat_ht = $total_array['total'];

$last_stack_ht = $st_total_ht - $st_eat_ht;//总量减去吃的总量等于现有库存


//本月入库
$sql = "select sum(ht) as total from totaldetail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$in_stack_ht = $total_array['total'];

//本月领用
$sql = "select sum(ht) as total from detail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$out_stack_ht = $total_array['total'];

//本月库存
$sql = "select sum(ht) as total from totaldetail where time <= $end_time";//初始入库，到查询时间之后的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_total_ht = $total_array['total'];

$sql = "select sum(ht) as total from detail where time <= $end_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_eat_ht = $total_array['total'];

$this_stack_ht = $en_total_ht - $en_eat_ht;//总量减去吃的总量等于现有库存



//bg上月库存
$sql = "select sum(bg) as total from totaldetail where time <= $start_time";//初始入库，到查询时间之前的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_total_bg = $total_array['total'];

$sql = "select sum(bg) as total from detail where time <= $start_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_eat_bg = $total_array['total'];

$last_stack_bg = $st_total_bg - $st_eat_bg;//总量减去吃的总量等于现有库存


//本月入库
$sql = "select sum(bg) as total from totaldetail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$in_stack_bg = $total_array['total'];

//本月领用
$sql = "select sum(bg) as total from detail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$out_stack_bg = $total_array['total'];

//本月库存
$sql = "select sum(bg) as total from totaldetail where time <= $end_time";//初始入库，到查询时间之后的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_total_bg = $total_array['total'];

$sql = "select sum(bg) as total from detail where time <= $end_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_eat_bg = $total_array['total'];

$this_stack_bg = $en_total_bg - $en_eat_bg;//总量减去吃的总量等于现有库存




//nn上月库存
$sql = "select sum(nn) as total from totaldetail where time <= $start_time";//初始入库，到查询时间之前的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_total_nn = $total_array['total'];

$sql = "select sum(nn) as total from detail where time <= $start_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$st_eat_nn = $total_array['total'];

$last_stack_nn = $st_total_nn - $st_eat_nn;//总量减去吃的总量等于现有库存


//本月入库
$sql = "select sum(nn) as total from totaldetail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$in_stack_nn = $total_array['total'];

//本月领用
$sql = "select sum(nn) as total from detail where time > $start_time and time <= $end_time";
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$out_stack_nn = $total_array['total'];

//本月库存
$sql = "select sum(nn) as total from totaldetail where time <= $end_time";//初始入库，到查询时间之后的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_total_nn = $total_array['total'];

$sql = "select sum(nn) as total from detail where time <= $end_time";//初始入库，到查询时间之前吃的总量
$mysqli_result = $db->query($sql);
$total_array = $mysqli_result->fetch_array(MYSQL_ASSOC);
$en_eat_nn = $total_array['total'];

$this_stack_nn = $en_total_nn - $en_eat_nn;//总量减去吃的总量等于现有库存

} 





/*else {
    
    echo "<script> alert('请输入正确的时间段！');window.location.href='foodadmin.php';</script>";
    exit;
}*/


?>

<?php if(@$_REQUEST['type'] != 'post'):?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="foodcss.css"/>

<title>零食</title>


</head>
<body>
<table>
<tr>
    <td>当前时间：</td>
    <td id="CurrentTime"></td>
    <script type="text/javascript">
        function changetime(){
            var ary = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
            var Timehtml = document.getElementById('CurrentTime');
            var date = new Date();
            Timehtml.innerHTML = ''+date.toLocaleString()+'   '+ary[date.getDay()];
        }
        window.onload = function(){
            changetime();
            setInterval(changetime,1000);   
        }
    </script>
</tr>
</table>

<div class="h">
		<h2>西安三态电子商务有限公司</h2>
		<h3>加班食物库存管理</h3>
</div>
<div class="addGoods">
    <div class="goods_list">
    <form action="foodadminmain.php" method="post" style="display:inline">
        <ul>
            <li><img class="goods_img" src="fbm.jpg"><p>方便面</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_fbm;?></span><span style="margin-left:600px;">需要增加的数量：</span><input class="input" type="text" name="fbm" value="0"/></div></li>
            <li><img class="goods_img" src="ht.jpg"><p>火腿</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_ht;?></span><span style="margin-left:600px;">需要增加的数量：</span><input class="input" type="text" name="ht" value="0"/></div></li>  
            <li><img class="goods_img" src="bg.jpg"><p>饼干</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_bg;?></span><span style="margin-left:600px;">需要增加的数量：</span><input class="input" type="text" name="bg" value="0"/></div></li>  
            <li><img class="goods_img" src="nn.jpg"><p>牛奶</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_nn;?></span><span style="margin-left:600px;">需要增加的数量：</span><input class="input" type="text" name="nn" value="0"/></div></li>      
        </ul>

        <div class="pay">
          <span><button type="submit">提交入库</button></span>
        </div>  
    </form> 
          
    <form id="time" action="foodadmin.php" method="post"> 
        <div style="margin-top: 120px; text-align:center;">
            <span>查询开始时间：<input name="starttime" type="text" style="padding:6px 8px; font-size:16px"/></span>
            <span>查询结束时间：<input name="endtime" type="text" style="padding:6px 8px; font-size:16px"/></span>

            <input type="hidden" name="type" value="post" />

            <input id="show" type="button" value="提交查询结果" style="width:100px; height:35px; font-size:16px"/>

        </div>
	</form>  
    <div id="res">
    </div>       
      </div>
</div>


<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js" ></script>
<script type="text/javascript">

$(document).ready(function() {

//增加
    $(".jia").click(function() {
        var num = $(this).parent().children("span");

//单个增加
        num.text(parseInt(num.text())+1);
        $('input[name="'+ num.attr('id') +'"]').val(num.text());
    });

//减少
     $(".jian").click(function() {
        var num = $(this).parent().children("span");
        
        if(parseInt(num.text())){
            num.text(parseInt(num.text())-1);  
            $('input[name="'+ num.attr('id') +'"]').val(num.text());      
        } else{
            num.text("0");
            alert("入库食物不能为负");
        }
    }); 

   $("#show").click(function(){
            $.ajax({
                url:"foodadmin.php",
                type:"post",
                data:$("#time").serialize(),
                success:function(data){
                    console.log(data);
                    $("#res").html(data);
                },
                error:function(e){
                    alert("错误！！");
                    window.clearInterval(timer);
                }
            });        

    });
});


</script>

</body>
</html>

<?php else: ?>
<div id="table" >
    <p style="margin: 10px auto; text-align:center;"><?php echo ($st = empty($st)? "" : $st)."-".($et = empty($et)? "" : $et)?></p>
    <table border="1" width="500" style="margin:  auto; text-align:center;">
        <tr>
            <th>食物名称</th>
            <th>上月库存</th>
            <th>本月入库</th>
            <th>本月领用</th>
            <th>本月库存</th>
        </tr>
        <tr>
            <td>方便面</td>
            <td><?php echo $last_stack_fbm = empty($last_stack_fbm)? "" : $last_stack_fbm;?></td>
            <td><?php echo $in_stack_fbm = empty($in_stack_fbm)? "" : $in_stack_fbm;?></td>
            <td><?php echo $out_stack_fbm = empty($out_stack_fbm)? "" : $out_stack_fbm;?></td>
            <td><?php echo $this_stack_fbm = empty($this_stack_fbm)? "" : $this_stack_fbm;?></td>
        </tr>
        <tr>
            <td>火腿</td>
            <td><?php echo $last_stack_ht = empty($last_stack_ht)? "" : $last_stack_ht;?></td>
            <td><?php echo $in_stack_ht = empty($in_stack_ht)? "" : $in_stack_ht;?></td>
            <td><?php echo $out_stack_ht = empty($out_stack_ht)? "" : $out_stack_ht;?></td>
            <td><?php echo $this_stack_ht = empty($this_stack_ht)? "" : $this_stack_ht;?></td>
        </tr>
        <tr>
            <td>饼干</td>
            <td><?php echo $last_stack_bg = empty($last_stack_bg)? "" : $last_stack_bg;?></td>
            <td><?php echo $in_stack_bg = empty($in_stack_bg)? "" : $in_stack_bg;?></td>
            <td><?php echo $out_stack_bg = empty($out_stack_bg)? "" : $out_stack_bg;?></td>
            <td><?php echo $this_stack_bg = empty($this_stack_bg)? "" : $this_stack_bg;?></td>
        </tr>
        <tr>
            <td>牛奶</td>
            <td><?php echo $last_stack_nn = empty($last_stack_nn)? "" : $last_stack_nn;?></td>
            <td><?php echo $in_stack_nn = empty($in_stack_nn)? "" : $in_stack_nn;?></td>
            <td><?php echo $out_stack_nn = empty($out_stack_nn)? "" : $out_stack_nn;?></td>
            <td><?php echo $this_stack_nn = empty($this_stack_nn)? "" : $this_stack_nn;?></td>
        </tr>
    </table>
</div>
<?php endif; ?>

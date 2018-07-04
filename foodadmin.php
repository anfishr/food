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


//连接数据库，取下方滚动的数据
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
$sql = "select * from detail order by time desc";

$mysqli_result = $db->query($sql);
if ($mysqli_result == false) {
    echo "SQL错误！";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="foodcss.css"/>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js" ></script>
<title>零食</title>

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
});

</script>


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
              <span><button  id="btn" type="submit">提交入库</button></span>
	          </form>
          </div>
      </div>
</div>
</body>
</html>
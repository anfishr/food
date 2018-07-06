<?php
include('foodclass_find.php');
include("fooddb.php");
date_default_timezone_set('Asia/Shanghai'); 

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
<title>零食领用</title>

<script type="text/javascript">

$(document).ready(function() {

//增加
    $(".jia").click(function() {
        var num = $(this).parent().children("span");

//单个增加
        num.text(parseInt(num.text())+1);
//总数增加
        var totalNum = 0;
        totalNum = parseInt($(".totalNum").text());
        totalNum++;
        $(".totalNum").text(totalNum);
        $('input[name="'+ num.attr('id') +'"]').val(num.text());
    });

//减少
     $(".jian").click(function() {
        var num = $(this).parent().children("span");
        
        if(parseInt(num.text())){
	        num.text(parseInt(num.text())-1);
	        var totalNum = parseInt($(".totalNum").text());
	        totalNum--;
	        $(".totalNum").text(totalNum);	  
            $('input[name="'+ num.attr('id') +'"]').val(num.text());      
	    } else{
	        num.text("0");
	        alert("领取食物不能为负");
	    }
    }); 
});


window.onload=function(){
    var odiv = document.getElementById('div1');
    var oul = odiv.getElementsByTagName('ul')[0];
    var ali = oul.getElementsByTagName('li');
    var spa = -2;               

    oul.innerHTML=oul.innerHTML+oul.innerHTML;
    oul.style.height=ali[0].offsetHeight*ali.length+'px';

    function move(){
        if(oul.offsetTop<-oul.offsetHeight/2){
            oul.style.top='0';
        }

        if(oul.offsetTop>0){
            oul.style.left=-oul.offsetHeight/2+'px'
        }

        oul.style.top=oul.offsetTop+spa+'px';
    }

    var timer = setInterval(move,100)
    odiv.onmousemove=function(){clearInterval(timer);}

    odiv.onmouseout=function(){timer = setInterval(move,100)};

     changetime();
     setInterval(changetime,1000);  


}

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
    </script>  
</tr>
</table>


<div class="h">
		<h2>西安三态电子商务有限公司</h2>
		<h3>加班食物领取信息系统</h3>
</div>
<div class="addGoods">
      <div class="goods_list">
          <ul>
            <div class="liout"><img class="goods_img" src="fbm.jpg"><p>方便面</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_fbm;?></span><div class="num"><img class="jian" src="jianhao.jpg" /><span id="fbm">0</span><img class="jia"  src="jiahao.jpg"></div></div></div>
            <div class="liout"><img class="goods_img" src="ht.jpg"><p>火腿</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_ht;?></span><div class="num"><img class="jian" src="jianhao.jpg" /><span id="ht">0</span><img class="jia" src="jiahao.jpg"></div></div></div>  
            <div class="liout"><img class="goods_img" src="bg.jpg"><p>饼干</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_bg;?></span><div class="num"><img class="jian" src="jianhao.jpg" /><span id="bg">0</span><img class="jia" src="jiahao.jpg"></div></div></div>  
            <div class="liout"><img class="goods_img" src="nn.jpg"><p>牛奶</p>
            	<div class="goods_num"><span class="goods_num">库存:<?php echo $total_nn;?></span><div class="num"><img class="jian" src="jianhao.jpg" /><span id="nn">0</span><img class="jia" src="jiahao.jpg"></div></div></div>      
          </ul>

          <div class="pay">共计<span class="totalNum">0</span>件
	          <form action="foodmain.php" method="post" style="display:inline">
              <input type="hidden" name="fbm" value="0">
              <input type="hidden" name="ht" value="0">
              <input type="hidden" name="bg" value="0">
              <input type="hidden" name="nn" value="0">

		          <span>领取人：<input name="user" type="text" style="padding:8px 10px; font-size:16px"/></span>
		          <span><button  id="btn" type="submit">提交领取</button></span>
	          </form>
          </div>
      </div>
</div>

<div id="div1"> 
	<ul> 
	    <?php       
	    while($row = $mysqli_result->fetch_array(MYSQL_ASSOC)) {
	    ?>
	    <div>
	        <li>
	        <span><?php echo date("Y-m-d H:i:s",$row['time']);?></span>
	        <span><?php echo $row["user"]." 领取了";?></span>
	        <span><?php echo $row["fbm"]."桶方便面";?></span>
	        <span><?php echo ",".$row["ht"]."根火腿";?></span>
	        <span><?php echo ",".$row["bg"]."包饼干";?></span>
	        <span><?php echo ",".$row["nn"]."盒牛奶";?></span></li>   
	    </div>        
	    <?php
	    }
	    ?>   
    </ul>                 
</div>
</body>
</html>
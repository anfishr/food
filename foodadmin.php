<?php
include('foodclass_find.php');
include("fooddb.php");
date_default_timezone_set('Asia/Shanghai'); 

//取出各个食物的库存
$num_find = new find();
$total_fbm = $num_find->total("fbm");
$total_ht = $num_find->total("ht");
$total_zsbg = $num_find->total("zsbg");
$total_nn = $num_find->total("nn");
$total_ld = $num_find->total("ld");
$total_slf = $num_find->total("slf");
$total_ccs = $num_find->total("ccs");


//连接数据库，获取上月库存

if(isset($_POST["starttime"])&&$_POST["endtime"]) {

$st = $_POST["starttime"];
$et = $_POST["endtime"];

$start_time = strtotime("$st");
$end_time = strtotime("$et");


//foodadmin 新建查找数据的类
$stack_find = new stack();

//1.取方便面的库存变化表格
$last_stack_fbm = $stack_find->ls("fbm","$start_time");
$in_stack_fbm = $stack_find->is("fbm","$start_time","$end_time");
$out_stack_fbm = $stack_find->os("fbm","$start_time","$end_time");
$this_stack_fbm = $stack_find->ts("fbm","$end_time");


//2.取火腿的库存变化表格
$last_stack_ht = $stack_find->ls("ht","$start_time");
$in_stack_ht = $stack_find->is("ht","$start_time","$end_time");
$out_stack_ht = $stack_find->os("ht","$start_time","$end_time");
$this_stack_ht = $stack_find->ts("ht","$end_time");


//3.取芝士饼干的库存变化表格
$last_stack_zsbg = $stack_find->ls("zsbg","$start_time");
$in_stack_zsbg = $stack_find->is("zsbg","$start_time","$end_time");
$out_stack_zsbg = $stack_find->os("zsbg","$start_time","$end_time");
$this_stack_zsbg = $stack_find->ts("zsbg","$end_time");


//4.取牛奶的库存变化表格
$last_stack_nn = $stack_find->ls("nn","$start_time");
$in_stack_nn = $stack_find->is("nn","$start_time","$end_time");
$out_stack_nn = $stack_find->os("nn","$start_time","$end_time");
$this_stack_nn = $stack_find->ts("nn","$end_time");


//5.取卤蛋的库存变化表格
$last_stack_ld = $stack_find->ls("ld","$start_time");
$in_stack_ld = $stack_find->is("ld","$start_time","$end_time");
$out_stack_ld = $stack_find->os("ld","$start_time","$end_time");
$this_stack_ld = $stack_find->ts("ld","$end_time");


//6.取酸辣粉的库存变化表格
$last_stack_slf = $stack_find->ls("slf","$start_time");
$in_stack_slf = $stack_find->is("slf","$start_time","$end_time");
$out_stack_slf = $stack_find->os("slf","$start_time","$end_time");
$this_stack_slf = $stack_find->ts("slf","$end_time");


//7.取脆脆鲨的库存变化表格
$last_stack_ccs = $stack_find->ls("ccs","$start_time");
$in_stack_ccs = $stack_find->is("ccs","$start_time","$end_time");
$out_stack_ccs = $stack_find->os("ccs","$start_time","$end_time");
$this_stack_ccs = $stack_find->ts("ccs","$end_time");

}
?>

<?php if(@$_REQUEST['type'] != 'post'):?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="foodcss.css"/>

<title>零食管理员</title>


</head>
<div class="content">
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
            <div>
                <div class="liout"><img class="goods_img" src="fbm.jpg"><p>方便面</p>
                    <div class="goods_num"><span>库存:<?php echo $total_fbm;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="fbm" value="0"/></div></div>
                <div class="liout"><img class="goods_img" src="ht.jpg"><p>火腿</p>
                    <div class="goods_num"><span>库存:<?php echo $total_ht;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="ht" value="0"/></div></div>
                <div class="liout"><img class="goods_img" src="zsbg.jpg"><p>芝士饼干</p>
                    <div class="goods_num"><span>库存:<?php echo $total_zsbg;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="zsbg" value="0"/></div></div>
                <div class="liout"><img class="goods_img" src="nn.jpg"><p>牛奶</p>
                    <div class="goods_num"><span>库存:<?php echo $total_nn;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="nn" value="0"/></div></div>
                <div class="liout"><img class="goods_img" src="ld.jpg"><p>卤蛋</p>
                    <div class="goods_num"><span>库存:<?php echo $total_ld;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="ld" value="0"/></div></div>
                <div class="liout"><img class="goods_img" src="slf.jpg"><p>酸辣粉</p>
                    <div class="goods_num"><span>库存:<?php echo $total_slf;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="slf" value="0"/></div></div>
                <div class="liout"><img class="goods_img" src="ccs.jpg"><p>脆脆鲨</p>
                    <div class="goods_num"><span>库存:<?php echo $total_ccs;?></span><span style="margin-left:420px;">需要增加的数量：</span><input class="input" type="text" name="ccs" value="0"/></div></div>
            </div>

            <div class="pay">
              <span><button type="submit">提交入库</button></span>
            </div>
        </form>

        <form id="time" action="foodadmin.php" method="post">
            <div class="time">
                <span>查询开始时间：<input placeholder='开始时间' name="starttime" type="text" id="start_time" class="Wdate" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm', readOnly: true ,maxDate:'#F{$dp.$D(\'end_time\')}'});" format="yyyy-MM-dd HH:mm"  style="padding:6px 8px; font-size:16px"/></span>
                <span>查询结束时间：<input placeholder='结束时间' name="endtime" type="text" id="end_time" class="Wdate" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm', readOnly: true ,minDate:'#F{$dp.$D(\'start_time\')}'});" format="yyyy-MM-dd HH:mm"  style="padding:6px 8px; font-size:16px"/></span>

                <input type="hidden" name="type" value="post" />

                <input id="show" type="button" value="提交查询结果" style="width:100px; height:35px; font-size:16px"/>

            </div>
        </form>
        <div id="res">
        </div>
          </div>
    </div>


    <script type="text/javascript" src="jquery.js" ></script>
    <script type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
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
                        $("#res").html(data);
                        $('body,html').scrollTop($('body').height());
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
        <table border="1" width="500" style="margin:  auto; text-align:center; margin-bottom: 10% ;">
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
                <td>芝士饼干</td>
                <td><?php echo $last_stack_zsbg = empty($last_stack_zsbg)? "" : $last_stack_zsbg;?></td>
                <td><?php echo $in_stack_zsbg = empty($in_stack_zsbg)? "" : $in_stack_zsbg;?></td>
                <td><?php echo $out_stack_zsbg = empty($out_stack_zsbg)? "" : $out_stack_zsbg;?></td>
                <td><?php echo $this_stack_zsbg = empty($this_stack_zsbg)? "" : $this_stack_zsbg;?></td>
            </tr>
            <tr>
                <td>牛奶</td>
                <td><?php echo $last_stack_nn = empty($last_stack_nn)? "" : $last_stack_nn;?></td>
                <td><?php echo $in_stack_nn = empty($in_stack_nn)? "" : $in_stack_nn;?></td>
                <td><?php echo $out_stack_nn = empty($out_stack_nn)? "" : $out_stack_nn;?></td>
                <td><?php echo $this_stack_nn = empty($this_stack_nn)? "" : $this_stack_nn;?></td>
            </tr>
            <tr>
                <td>卤蛋</td>
                <td><?php echo $last_stack_ld = empty($last_stack_ld)? "" : $last_stack_ld;?></td>
                <td><?php echo $in_stack_ld = empty($in_stack_ld)? "" : $in_stack_ld;?></td>
                <td><?php echo $out_stack_ld = empty($out_stack_ld)? "" : $out_stack_ld;?></td>
                <td><?php echo $this_stack_ld = empty($this_stack_ld)? "" : $this_stack_ld;?></td>
            </tr>
            <tr>
                <td>酸辣粉</td>
                <td><?php echo $last_stack_slf = empty($last_stack_slf)? "" : $last_stack_slf;?></td>
                <td><?php echo $in_stack_slf = empty($in_stack_slf)? "" : $in_stack_slf;?></td>
                <td><?php echo $out_stack_slf = empty($out_stack_slf)? "" : $out_stack_slf;?></td>
                <td><?php echo $this_stack_slf = empty($this_stack_slf)? "" : $this_stack_slf;?></td>
            </tr>
            <tr>
                <td>脆脆鲨</td>
                <td><?php echo $last_stack_ccs = empty($last_stack_ccs)? "" : $last_stack_ccs;?></td>
                <td><?php echo $in_stack_ccs = empty($in_stack_ccs)? "" : $in_stack_ccs;?></td>
                <td><?php echo $out_stack_ccs = empty($out_stack_ccs)? "" : $out_stack_ccs;?></td>
                <td><?php echo $this_stack_ccs = empty($this_stack_ccs)? "" : $this_stack_ccs;?></td>
            </tr>
        </table>
    </div>
</div>
<?php endif; ?>
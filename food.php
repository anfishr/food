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
$total_mb = $num_find->total("mb");






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
    <script type="text/javascript" src="jquery.js"></script>
    <title>零食领用</title>

    <script type="text/javascript">

     $(document).ready(function () {



    //循环判断食物领取的库存，为0自动隐藏，不为0显示
    // console.log($(".goods_list").find(".goods_num").find("span:eq(1)").html());
        var $list = $(".goods_list").find(".goods_num").find("span:eq(1)");
    //  console.log($list);

        $.each($list,function(i,item){

     //      console.log(i, item);
    //       console.log($(this).html());

        if ($(this).html() == 0) {
             $(this).parent().parent().hide();
        }else{
             $(this).parent().parent().show();
        }

        });





//增加
            $(".jia").click(function () {
                var num = $(this).parent().children("span");

//单个增加
                num.text(parseInt(num.text()) + 1);
//总数增加
                var totalNum = 0;
                totalNum = parseInt($(".totalNum").text());
                totalNum++;
                $(".totalNum").text(totalNum);
                $('input[name="' + num.attr('id') + '"]').val(num.text());
            });

//减少
            $(".jian").click(function () {
                var num = $(this).parent().children("span");

                if (parseInt(num.text())) {
                    num.text(parseInt(num.text()) - 1);
                    var totalNum = parseInt($(".totalNum").text());
                    totalNum--;
                    $(".totalNum").text(totalNum);
                    $('input[name="' + num.attr('id') + '"]').val(num.text());
                } else {
                    num.text("0");
                    alert("领取食物不能为负");
                }
            });



     //下方滚动的jQuery代码
            var odiv = document.getElementById('div1');
            var oul = odiv.getElementsByTagName('ul')[0];
            var ali = oul.getElementsByTagName('li');
            var spa = -2;

            /*    oul.innerHTML=oul.innerHTML+oul.innerHTML;
             oul.style.height=ali[0].offsetHeight*ali.length+'px';*/


            //向上移动
            function move() {
                if (oul.offsetTop < -oul.offsetHeight / 2) {
                    oul.style.top = '0';
                }

                if (oul.offsetTop > 0) {
                    oul.style.left = -oul.offsetHeight / 2 + 'px'
                }

                oul.style.top = oul.offsetTop + spa + 'px';
            }

            var timer = setInterval(move, 100)


            odiv.onmousemove = function () {
                clearInterval(timer);
            }

            odiv.onmouseout = function () {
                timer = setInterval(move, 100)
            };

            changetime();
            setInterval(changetime, 1000);


            $("#btn").click(function () {
                //console.log($('input[class="fbm"]').val());
                //console.log($('input[name="fbm"]').val());
                $.ajax({
                    url: "foodmain.php",
                    type: "post",
                    data: {
                        'fbm': $('input[name="fbm"]').val(),
                        'ht': $('input[name="ht"]').val(),
                        'zsbg': $('input[name="zsbg"]').val(),
                        'nn': $('input[name="nn"]').val(),
                        'ld': $('input[name="ld"]').val(),
                        'slf': $('input[name="slf"]').val(),
                        'ccs': $('input[name="ccs"]').val(),
                        'mb': $('input[name="mb"]').val(),



                        'user': $("#user").val()
                    },
                    success: function (data) {
                        var data = eval("(" + data + ")");
                        alert(data.msg);
                        if (data.code == 1) {
                            location.reload();
                        }
                    },
                    error: function (e) {
                        alert("错误！！");
                        window.clearInterval(timer);
                    }
                });
            });


        });

    </script>


</head>
<body>

<div class="content">
    <table>
        <tr>
            <td>当前时间：</td>
            <td id="CurrentTime"></td>
            <script type="text/javascript">
                function changetime() {
                    var ary = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
                    var Timehtml = document.getElementById('CurrentTime');
                    var date = new Date();
                    Timehtml.innerHTML = '' + date.toLocaleString() + '   ' + ary[date.getDay()];
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

                <div class="liout"><img class="goods_img" src="fbm.jpg">
                    <p>方便面</p>
                        <div class="goods_num">
                            <span>库存:</span>
                            <span id="total_fbm"><?php echo $total_fbm; ?></span>
                            <div class="num">
                                <img class="jian" src="jianhao.jpg"/>
                                <span id="fbm">0</span>
                                <img class="jia" src="jiahao.jpg">
                        </div>
                    </div>
                </div>

                <div class="liout"><img class="goods_img" src="ht.jpg">
                    <p>火腿</p>
                    <div class="goods_num"><span>库存:</span><span id="total_ht"><?php echo $total_ht; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="ht">0</span><img class="jia"
                                                                                                         src="jiahao.jpg">
                        </div>
                    </div>
                </div>

                <div class="liout"><img class="goods_img" src="zsbg.jpg">
                    <p>芝士饼干</p>
                    <div class="goods_num"><span>库存:</span><span id="total_zsbg"><?php echo $total_zsbg; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="zsbg">0</span><img class="jia"
                                                                                                           src="jiahao.jpg">
                        </div>
                    </div>
                </div>

                <div class="liout"><img class="goods_img" src="nn.jpg">
                    <p>牛奶</p>
                    <div class="goods_num"><span>库存:</span><span id="total_nn"><?php echo $total_nn; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="nn">0</span><img class="jia"
                                                                                                         src="jiahao.jpg">
                        </div>
                    </div>
                </div>

                <div class="liout"><img class="goods_img" src="ld.jpg">
                    <p>卤蛋</p>
                    <div class="goods_num"><span>库存:</span><span id="total_ld"><?php echo $total_ld; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="ld">0</span><img class="jia"
                                                                                                         src="jiahao.jpg">
                        </div>
                    </div>
                </div>

                <div class="liout"><img class="goods_img" src="slf.jpg">
                    <p>酸辣粉</p>
                    <div class="goods_num"><span>库存:</span><span id="total_slf"><?php echo $total_slf; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="slf">0</span><img class="jia"
                                                                                                         src="jiahao.jpg">
                        </div>
                    </div>
                </div>

                <div class="liout"><img class="goods_img" src="ccs.jpg">
                    <p>脆脆鲨</p>
                    <div class="goods_num"><span>库存:</span><span id="total_ccs"><?php echo $total_ccs; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="ccs">0</span><img class="jia"
                                                                                                         src="jiahao.jpg">
                        </div>
                    </div>
                </div>
                    
                <div class="liout"><img class="goods_img" src="mb.jpg">
                    <p>面包</p>
                    <div class="goods_num"><span>库存:</span><span id="total_mb"><?php echo $total_mb; ?></span>
                        <div class="num"><img class="jian" src="jianhao.jpg"/><span id="mb">0</span><img class="jia"
                                                                                                         src="jiahao.jpg">
                        </div>
                    </div>
               
                </div>



            </div>

            <div class="pay">共计<span class="totalNum">0</span>件
                <form action="foodmain.php" method="post" style="display:inline">
                    <input type="hidden" name="fbm" value="0">
                    <input type="hidden" name="ht" value="0">
                    <input type="hidden" name="zsbg" value="0">
                    <input type="hidden" name="nn" value="0">
                    <input type="hidden" name="ld" value="0">
                    <input type="hidden" name="slf" value="0">
                    <input type="hidden" name="ccs" value="0">
                    <input type="hidden" name="mb" value="0">

                    <!--<input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">-->

                    <span>领取人：<input name="user" id="user" type="text" style="padding:8px 10px; font-size:16px"
                                     placeholder='在这输入你的名字'/></span>
                    <span><button id="btn" type="button">提交领取</button></span>
                </form>
            </div>
        </div>
    </div>

    <div id="div1">
        <ul>
            <?php
            while ($row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC)) {
                ?>
                <div>
                    <li>
                        <span><?php echo date("Y-m-d H:i:s", $row['time']); ?></span>
                        <span><?php echo $row["user"] . " 领取了:"; ?></span>
                        <span><?php if ($row["fbm"]!=0){echo $row["fbm"] . "桶方便面";} ?></span>
                        <span><?php if ($row["ht"]!=0){echo " " . $row["ht"] . "根火腿";} ?></span>
                        <span><?php if ($row["zsbg"]!=0){echo " " . $row["zsbg"] . "包芝士饼干";} ?></span>
                        <span><?php if ($row["nn"]!=0){echo " " . $row["nn"] . "盒牛奶";} ?></span>
                        <span><?php if ($row["ld"]!=0){echo " " . $row["ld"] . "个卤蛋";} ?></span>
                        <span><?php if ($row["slf"]!=0){echo " " . $row["slf"] . "桶酸辣粉";} ?></span>
                        <span><?php if ($row["ccs"]!=0){echo " " . $row["ccs"] . "根脆脆鲨";} ?></span>
                        <span><?php if ($row["mb"]!=0){echo " " . $row["mb"] . "个面包";} ?></span>
                    </li>
                </div>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
</body>
</html>
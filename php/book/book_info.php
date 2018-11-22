<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-查看车票详情</title>
</head>

<body background="../image/123.jpg">
	<center>
<div class="container">

 <h1 class="row skew-title"> <span>欢</span><span>迎</span><span>访</span><span>问</span><span>果</span><span class="last">壳</span>   <span>1</span><span>2</span><span>3</span><span class="last">0</span>   <span class="alt">6</span><span class="alt">网</span><span class="alt">站</span><span class="alt last">!</span> </h1>

 <p class="row row--intro"></p>

</div>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>查看车票详情</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$userid = $_SESSION["userid"];
$bookid=$_GET["bookid"];

echo "<center>";
echo "<H3>尊敬的用户 $username ，您的订单 $bookid 详情如下：</H3>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";


$get_book_info = <<<EOF
				SELECT * 
				FROM Book
				WHERE B_id = $bookid;
EOF;
$ret = pg_query($dbconn, $get_book_info);
$row_num = pg_num_rows($ret);
//echo $row_num;
if (!$row_num){
	echo "未知错误！查看失败！";
}
$info = pg_fetch_row($ret);

$status = array ( "cancelled"=>"已取消", "uncancelled"=>"未取消");

$bookst = $info[7];

echo "<table border = \"4\">";
echo "<tr>";
echo "<td>用户名</td>";
echo "<td>用户ID</td>";
echo "<td>订单号</td>";
echo "<td>列车号</td>";
echo "<td>出发日期</td>";
echo "<td>出发站</td>";
echo "<td>到达站</td>";
echo "<td>票价</td>";
echo "<td>订单状态</td>";
echo "<td>是否取消</td>";
echo "</tr>";

echo "<tr>";
echo "<td>$username</td>";
echo "<td>$userid</td>";
echo "<td>$info[0]</td>";
echo "<td>$info[4]</td>";
echo "<td>$info[3]</td>";
echo "<td>$info[5]</td>";
echo "<td>$info[6]</td>";
echo "<td>$info[2]</td>";
echo "<td>$status[$bookst]</td>";
if ($info[7] == "uncancelled"){
    echo "<td><a href=\"../book/book_cancel.php?bookid=$info[0]\"  target=\"_blank\"><center>取消</center></a></td>";
}else	echo "<td>不可取消</td>";
echo "</tr>";

echo "</table>";

    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/book.php\"><input type=\"button\" value = \"返回订单查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../bin/user_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";

pg_close($dbconn);
//echo $username;
echo "</center>";
?>
	<center>
<script src="js/jquery.min.js"></script>

<script>

(function() {

  $('.skew-title').children('span').hover((function() {

    var $el, n;

    $el = $(this);

    n = $el.index() + 1;

    $el.addClass('flat');

    if (n % 2 === 0) {

      return $el.prev().addClass('flat');

    } else {

      if (!$el.hasClass('last')) {

        return $el.next().addClass('flat');

      }

    }

  }), function() {

    return $('.flat').removeClass('flat');

  });

}).call(this);

</script>

   <style type="text/css">
   <style type="text/css">
body { margin-top: 20px; background-color: #112; background-color: #0c2d41; font-family: Roboto, 'helvetica neue', Helvetica, Arial, sans-serif; }

.container { width: 800px; margin: auto; }

.row { position: relative; height: 30px; z-index: 1; clear: both; margin-bottom: 10px; text-align: center; }

.row--intro { padding-top: 20px; font-size: 16px; line-height: 28px; font-weight: 300; color: #fff; opacity: 0.4; }

.row--intro span { font-size: 11px; }

.skew-title { font-size: 25px; }

.skew-title span { position: relative; display: inline-block; width: 40px; height: 50px; margin: auto; z-index: 2; text-align: center; color: #fff; font-family: 'roboto condensed'; font-weight: 700; font-size: 35.714285714285715px; line-height: 50px; -webkit-transform: skewY(-15deg); transform: skewY(-15deg); -webkit-transform-origin: 0 100%; transform-origin: 0 100%; transition: all 0.2s; cursor: default; }

.skew-title span:after, .skew-title span:before { display: block; top: 0; left: 0; width: 40px; height: 50px; position: absolute; background: #185a81; content: ' '; z-index: -1; transition: all 0.2s; }

.skew-title span:before { background: rgba(0,0,0,0.1); -webkit-transform: skewY(15deg); transform: skewY(15deg); -webkit-transform-origin: 0 0; transform-origin: 0 0; }

.skew-title span:nth-child(even) { background-color: #144c6e; -webkit-transform: skewY(15deg); transform: skewY(15deg); -webkit-transform-origin: 100% 100%; transform-origin: 100% 100%; color: #d9d9d9; }

.skew-title span:nth-child(even):after { background-color: #144c6e; }

.skew-title span:nth-child(even):before { -webkit-transform-origin: 100% 0; transform-origin: 100% 0; -webkit-transform: skewY(-15deg); transform: skewY(-15deg); }

.skew-title span.flat { -webkit-transform: skewY(0); transform: skewY(0); color: #fff; }

.skew-title span.flat:before { -webkit-transform: skewY(0); transform: skewY(0); }

.skew-title span.flat:nth-child(even):after { background-color: #185a81; }

.skew-title span.alt:after { background-color: #b94a2c; }

.skew-title span.alt:nth-child(even):after { background-color: #9d3f25; }

.skew-title span.alt.flat:nth-child(even):after { background-color: #b94a2c; }

</style>
    <div>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
        <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>

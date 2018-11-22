<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-用户订单查询结果</title>
</head>

<body background="../image/123.jpg">
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>用户订单查询结果</h2></b></p></div>
<br>
<?php
function datadd($n, $date){
    return date("Y-m-d", strtotime($date ." +$n day"));
}
session_start();
$username = $_SESSION["username"];
//$userid = $_SESSION["userid"];
$date_min = $_POST["from_date_min"];
$date_max = $_POST["from_date_max"];
/*
echo $date_min;
echo "<br>";
echo $date_max;
echo "<br>";
echo $userid;
echo "<br>";
*/
echo "<center>";
echo "<H3>尊敬的用户 $username ，您的订单查询结果详情如下</H3>";

    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$get_uid = <<<EOF
			SELECT U_ICNum
			FROM MyUser
			WHERE U_UName = '$username';
EOF;
$ret = pg_query($dbconn, $get_uid);
$row = pg_fetch_row($ret);
$userid = $row[0];
//echo $userid;
$_SESSION["userid"]=$userid;

$select_book = <<<EOF
			SELECT * 
			FROM Book 
			WHERE B_Date BETWEEN '$date_min' AND '$date_max' 
			AND B_User = '$userid' ORDER BY B_Id;
EOF;
$ret = pg_query( $dbconn, $select_book );
$row_num = pg_num_rows($ret);
if (!$ret)
	echo "查询失败！";
//$row_num=($userid%2==0);
if (!$row_num){
	echo "<b>";
	$back_href = "../serve/book.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "无任何订单信息！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新选择时间段";
    echo "</br>";
    echo "</p>";
    echo "</FONT>";
    echo "</b>";
}
else{
$status = array ("cancelled"=>"已取消", "uncancelled"=>"未取消");

echo "<table border = \"4\">";
echo "<tr>";
echo "<td>订单号</td>";
echo "<td>订单状态</td>";
echo "<td>查看详情</td>";
echo "<td>是否取消</td>";
echo "</tr>";

while ($row = pg_fetch_row($ret))
{
	$bookst=$row[7];
	echo "<tr>";
	echo "<td>$row[0]</td>";
	echo "<td>$status[$bookst]</td>";
echo "<td><a href=\"../book/book_info.php?bookid=$row[0]\"  target=\"_blank\"><center>查看</center></a></td>";
if ($row[7] == "uncancelled"){
    echo "<td><a href=\"../book/book_cancel.php?bookid=$row[0]\"  target=\"_blank\"><center>取消</center></a></td>";
}else	echo "<td>不可取消</td>";
	echo "</tr>";
}

	echo "</table>";
}
    echo "<br>";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../serve/book.php'\">返回车次查询</a>
   </div> ";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../bin/user_signin.php'\">返回服务选择</a>
   </div> ";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../index.php'\">退出登录</a>
   </div> ";

pg_close($dbconn);
echo "</center>";
?>
   <style type="text/css">

* {
    margin: 10;
    padding: 10;
}

@font-face {
  font-family:League-Gothic;
  src:url("http://static.tumblr.com/unxjxmf/8oKm0yq2w/league-gothic.otf") format("opentype");
}
body{
    -webkit-transition: background-color 1s ease;
    -moz-transition: background-color 1s ease;
    -ms-transition: background-color 1s ease;
    -o-transition: background-color 1s ease;
    transition: background-color 1s ease;
}

#wrap      {width:80%;margin:auto;padding:20px 0px;}
/**
 * =======================================================
 * START CSS3 BUTTONS
 * To provide a convenient update, start a new button from top,
 * not from bottom
 * =======================================================
 */


/* 3D block button w/ hover transition */
/*     Would be much cleaner with a little .less */

a.three-dee-block {
    background: rgb(255,255,255); 
    background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(80%,rgba(215,215,215,0.2)), color-stop(100%,rgba(200,200,200,0.4))); 
    background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -o-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    box-shadow: 1px 1px 0 rgb(190,190,190),
        2px 2px 0 rgb(180,180,180),
        3px 3px 0 rgb(170,170,170),
        4px 4px 0 rgb(160,160,160),
        5px 5px 0 rgb(150,150,150),
        3px 6px 1px rgba(0,0,0,0.1),
        0 0 5px rgba(0,0,0,0.1),
        0 1px 3px rgba(0,0,0,0.3),
        1px 3px 5px rgba(0,0,0,0.2),
        2px 5px 10px rgba(0,0,0,0.25),
        5px 10px 10px rgba(0,0,0,0.2),
        10px 20px 20px rgba(0,0,0,0.15);
    color: rgba(70,70,70,0.6);
    cursor: pointer;
    display: block;
    font: normal 1em/1.1em arial, sans-serif;
    margin: 0 auto;
    padding: 0.3em 0.5em;
    -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -ms-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
    width: 8em;
}

a.three-dee-block:hover {
    background: rgb(235,235,235); 
    background: -moz-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,rgba(205,255,205,0.5)), color-stop(70%,rgba(255,255,255,0))), -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(80%,rgba(215,215,215,0.2)), color-stop(100%,rgba(200,200,200,0.4))); 
    background: -webkit-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -o-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -o-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    background: -ms-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    color: rgba(30,30,30,0.7);
    
    -moz-transform: translate(0px, -1px);
    -webkit-transform: translate(0px, -1px);
    -o-transform: translate(0px, -1px);
    -ms-transform: translate(0px, -1px);
    transform: translate(0px, -1px);
    
    -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -ms-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
}

a.three-dee-block:active {
    background: rgb(255,255,255); 
    background: -moz-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -webkit-gradient(linear, left bottom, left top, color-stop(0%,rgba(255,255,255,0)), color-stop(80%,rgba(200,200,200,0.3)), color-stop(100%,rgba(185,185,185,0.5))); 
    background: -webkit-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -o-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    background: -ms-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    box-shadow: 1px 1px 0 rgb(160,160,160),
        2px 2px 0 rgb(150,150,150),
        3px 3px 0 rgb(140,140,140),
        4px 4px 0 rgb(130,130,130),
        5px 5px 0 rgb(120,120,120),
        3px 6px 1px rgba(0,0,0,0.1),
        0 0 5px rgba(0,0,0,0.1),
        0 1px 6px rgba(0,0,0,0.3),
        1px 3px 7px rgba(0,0,0,0.2);
    color: rgba(60,60,60,0.7);
    
    -moz-transform: translate(0px, 1px);
    -webkit-transform: translate(0px, 1px);
    -o-transform: translate(0px, 1px);
    -ms-transform: translate(0px, 1px);
    transform: translate(0px, 1px);
    
    -webkit-transition: all 200ms ease-out;
    -moz-transition: all 200ms ease-out;
    -ms-transition: all 200ms ease-out;
    -o-transition: all 200ms ease-out;
    transition: all 200ms ease-out;
}


/**
 * =======================================================
 * END CSS3 BUTTONS
 * =======================================================
 */

body.light    {background-color:whitesmoke;}
body.light h1,
body.light h2 {text-shadow:0px 1px 4px rgba(0,0,0,0.2);}
a#toggler {
  position:fixed !important;
  position:absolute;
  bottom:10px;
  right:10px; 
  font:bold 11px Arial;
  color:gold;    
}
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

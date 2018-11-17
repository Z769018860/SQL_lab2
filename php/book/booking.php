<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-订单确认</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>订单确认</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$trainid = $_GET["trainid"];
$date = $_GET["date"];
$type = $_GET["type"];
$ticketprice = $_GET["price"];
$from_station = $_GET["from_station"];
$to_station = $_GET["to_station"];
switch ($type){
case "YZ":
	$seat = "硬座";
	break;
case "RZ":
	$seat = "软座";
	break;
case "YW1":
	$seat = "硬卧上";
	break;
case "YW2":
	$seat = "硬卧中";
	break;
case "YW3":
	$seat = "硬卧下";
	break;
case "RW1":
	$seat = "软卧上";
	break;
case "RW2":
	$seat = "软卧下";
	break;
}

echo "<center>";
echo "<H3>尊敬的用户 $username ，您是否要预订一张</H3>";

    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";
/*
$getfrom = <<<EOF
			SELECT p_stationname
			FROM passby
			WHERE p_trainid = '$trainid'
			 AND  p_stationnum = $first;
EOF;
$ret = pg_query($conn, $getfrom);
$row = pg_fetch_row($ret);
$fromname = $row[0];
$getto = <<<EOF
			SELECT p_stationname
			FROM passby
			WHERE p_trainid = '$trainid'
			 AND  p_stationnum = $last;
EOF;
*/
/*
$ret = pg_query($conn, $getto);
$row = pg_fetch_row($ret);
$toname = $row[0];
$gettime = <<<EOF
			SELECT p_gotime
			FROM passby
			WHERE p_trainid = '$trainid'
			 AND  p_stationnum = 1;
EOF;
$ret = pg_query($conn, $gettime);
$row = pg_fetch_row($ret);
$gotime = $row[0];
$price = $ticketprice + 5;
*/
//echo $price;
echo "<p><H4>日期为 $date  时间为 $ime ，从 $from_station 到 $to_station 的 $trainid 次列车的 $seat 票 一张，票价为 $price (含5元手续费) 。点击下方确认生成订单，取消返回服务选择。</H4></p>";

echo "<center>";
echo "<input type=button value=\"确认\" onclick=\"window.location.href='book_confirm.php'\">";
echo "   ";
echo "<input type=button value = \"取消\" onclick = \"window.location.href='../bin/user_signin.php'\">";
echo "</center>";

    
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

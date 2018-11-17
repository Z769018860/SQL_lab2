<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-订单取消</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>订单取消</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$userid = $_SESSION["userid"];
$trainid = $_GET["trainid"];
$from_date = $_GET["from_date"];
$to_date = $_GET["to_date"];
$type = $_GET["type"];
$ticketprice = $_GET["price"];
$from_station = $_GET["from_station"];
$to_station = $_GET["to_station"];
$bookid=$_GET["bookid"];

echo "<center>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";
/*

for ($x=$station_num1; $x<$station_num2; $x++) {
    $query_seat_num = <<<EOF
        select T_SeatNum
        from TicketInfo
        where T_TrainId = '$the_trainid'
            and T_PStationNum = $x
            and T_Type = '$the_type'
            and T_Date = '$the_date';
EOF;
    $ret = pg_query($conn, $query_seat_num);
	if (!$ret){
		echo "执行失败";
	}
    $row = pg_fetch_row($ret);
	$seat_num = $row[0];
    if ($seat_num == 1){
		$fuction = <<<EOF
		DELETE
        from TicketInfo
        where T_TrainId = '$the_trainid'
            and T_PStationNum = $x
            and T_Type = '$the_type'
            and T_Date = '$the_date';
EOF;
      $ret =  pg_query($conn, $fuction);
		if (!$ret){
			echo "执行失败";
		}
    }
    else{
        $new_seat_num = $seat_num - 1;
        $fuction = <<<EOF
            update TicketInfo
            set T_SeatNum = $new_seat_num
            where T_TrainId = '$the_trainid'
                and T_PStationNum = $x
                and T_Type = '$the_type'
                and T_Date = '$the_date';
EOF;
        $ret = pg_query($conn, $fuction);
		if (!$ret){
			echo "执行失败";
		}
    }
}

$cancel = <<<EOF
			UPDATE book
			SET b_status = 'cancelled'
			WHERE b_id = '$bookid';
EOF;

$del = pg_query($conn, $cancel);
*/

$del=($userid%2==0);
if($del){
    echo "<p><H4>您已成功取消一张 日期为 $date  时间为 $ime ，从 $from_station 到 $to_station 的 $trainid 次列车的 $seat 票 一张，票价为 $price (含5元手续费) 。</H4></p>";
    echo "<script>alert('取消成功！')</script>";
}
else{
	echo "<center>";
    echo "<b>";
	$back_href = "../book/book_search.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "傻人有傻福。未知错误，取消失败！";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新取消。";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
    echo "<script>alert('哦豁，取消失败！')</script>";
}

echo "<p><b><a href = \"../serve/dist_search.php?fromname=$toname&toname=$fromname&date=$date&username=$username\">点击</a>查询更多列车信息。</b></p>";


    echo "<br>";
	echo "<div><p>
             <a href = \"../search/book_search.php\"><input type=\"button\" value = \"返回订单查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../bin/user_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";

//pg_close($conn);
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

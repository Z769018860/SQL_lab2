<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-预订完成</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>预订完成</h2></b></p></div>
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
/*
echo "<center>";
echo "<H3>尊敬的用户 $username ，您的订单 $bookid 详情如下：</H3>";

$conn = pg_connect("host=localhost port=5432 dbname=train user=fenglv password=nopasswd");
if (!$conn){
	echo "连接失败";
}

$get_uid = <<<EOF
			SELECT user_id 
			FROM userinfo
			WHERE u_uname = '$username';
EOF;

$ret = pg_query($conn, $get_uid);
$result = pg_fetch_row($ret);
$uid = $result[0];

$book = <<<EOF
		INSERT INTO 
    	book(B_UserId,B_TrainId,B_Date,B_StationNum1,B_StationNum2,B_SType,B_Money,B_Status)
	    VALUES('$uid', '$trainid', '$date', $stnum1, $stnum2, '$seattype', $money, 'normal');
EOF;
$ins = pg_query($conn, $book);
*/
$ins=($userid%2==0);
if($ins){
    echo "<p><H4>您已成功预订一张 日期为 $date  时间为 $ime ，从 $from_station 到 $to_station 的 $trainid 次列车的 $seat 票 一张，票价为 $price (含5元手续费) 。可选购返程票或前往订单查询。</H4></p>";
    echo "<script>alert('预订成功！')</script>";
}
else{
	echo "<center>";
    echo "<b>";
	$back_href = "../book/booking.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "天不遂人愿。未知错误，预订失败！";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新预订。";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
    echo "<script>alert('哦豁，预订失败！')</script>";
}
/*
for ($x=$stnum1; $x<$stnum2; $x++) {
    $query_seat_num = <<<EOF
        select T_SeatNum
        from TicketInfo
        where T_TrainId = '$trainid'
            and T_PStationNum = $x
            and T_Type = '$seattype'
            and T_Date = '$date';
EOF;
    $ret = pg_query($conn, $query_seat_num);
	if (!$ret){
		echo "执行失败";
	}
    $row_num = pg_num_rows($ret);
    if ($row_num == 0){
        $fuction = <<<EOF
            insert into
                TicketInfo(T_TrainId,T_PStationNum,T_Type,T_Date,T_SeatNum)
            values ('$trainid', $x, '$seattype', '$date', 1);
EOF;
    $ret = pg_query($conn, $fuction);
		if (!$ret){
			echo "执行失败";
		}
    }
    else{
        $row = pg_fetch_row($ret);
		$seat_num = $row[0];
        $new_seat_num = $seat_num + 1;
        $fuction = <<<EOF
            update TicketInfo
            set T_SeatNum = $new_seat_num
            where T_TrainId = '$trainid'
                and T_PStationNum = $x
                and T_Type = '$seattype'
                and T_Date = '$date';
EOF;
        $ret = pg_query($conn, $fuction);
		if (!$ret){
			echo "执行失败";
		}
    }
}
*/
echo "<p><b><a href = \"book_back.php?fromname=$toname&toname=$fromname&date=$date&username=$username\">点击</a>查询返程信息。</b></p>";

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

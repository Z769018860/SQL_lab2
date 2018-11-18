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
$date = $_GET["date"];
$type = $_GET["type"];
$seat = $_GET["seat"];
$ticketprice = $_GET["price"];
$from_station = $_GET["from_station"];
$to_station = $_GET["to_station"];
$go_time = $_GET["go_time"];
$got_time = $_GET["got_time"];
$price=$ticketprice-5;
/*
echo $userid;
echo "<br>";
echo $trainid;
echo "<br>";
echo $date;
echo "<br>";
echo $type;
echo "<br>";
echo $seat;
echo "<br>";
echo $ticketprice;
echo "<br>";
echo $from_station;
echo "<br>";
echo $to_station;
echo "<br>";*/
/*
$bookid=$_SESSION['bookid'];
$bookid=$bookid+1;
$_SESSION['bookid'] = $bookid;
echo $bookid;
echo "<br>";*/

echo "<center>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";


$book = <<<EOF
	INSERT INTO 
    	Book(B_User,B_Money,B_Date,B_Train,B_StartSt,B_ArrivalSt,B_Status)
	VALUES('$userid', $ticketprice, '$date', '$trainid', '$from_station', '$to_station', 'uncancelled');
EOF;
$ins = pg_query($dbconn, $book);
//余票信息！！！！
$get_stnum=<<<EOF
				SELECT T_StNum
				FROM Train
				WHERE T_Name = '$trainid'
				and T_Station = '$to_station';
EOF;
$ret_stnum = pg_query($dbconn, $get_stnum);
$row_stnum = pg_fetch_row($ret_stnum);
$to_stnum=$row_stnum[0]-1;

$get_stnum=<<<EOF
				SELECT T_StNum
				FROM Train
				WHERE T_Name = '$trainid'
				and T_Station = '$from_station';
EOF;
$ret_stnum = pg_query($dbconn, $get_stnum);
$row_stnum = pg_fetch_row($ret_stnum);
$from_stnum=$row_stnum[0];

//echo $to_stnum;
$get_passby = <<<EOF
				SELECT T_Station
				FROM Train
				WHERE T_Name = '$trainid'
				and T_StNum between $from_stnum and $to_stnum;
EOF;
$ret_p = pg_query($dbconn, $get_passby);
while ($row_p=pg_fetch_row($ret_p))
{

	$get_seat_num = <<<EOF
				SELECT Se_Num
				FROM Seat
				WHERE Se_Train = '$trainid'
				AND Se_Date = '$date'
				AND Se_Station = '$row_p[0]'
				AND Se_Type = '$type';
EOF;
$ret_s = pg_query($dbconn, $get_seat_num);
$row_s = pg_fetch_row($ret_s);
if (!$row_s[0])
{
$seat_num = <<<EOF
	INSERT INTO 
    	Seat(Se_Train,Se_Station,Se_Date,Se_Type,Se_Num)
	VALUES('$trainid', '$row_p[0]', '$date', '$type', 4);
EOF;
}
else
{
$new_num=$row_s[0]-1;
$seat_num = <<<EOF
				update Seat 
				set Se_Num=$new_num 
				WHERE Se_Train = '$trainid'
				AND Se_Date = '$date'
				AND Se_Station = '$row_p[0]'
				AND Se_Type = '$type';
EOF;
}
$ins2=pg_query($dbconn, $seat_num);
if (!$ins2)
	echo "WARINING!!!";
}
//$ins=($userid%2==0);
if($ins&&$ins2){
    echo "<p><H4>您已成功预订一张 出发日期为 $date  出发时间为 $go_time ，到达时间为 $got_time , 从 $from_station 到 $to_station 的 $trainid 次列车的 $seat 票 一张，票价为 $ticketprice (含5元手续费) 。可选购返程票或前往订单查询。</H4></p>";
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
    echo  "请<a href =\"../book/booking.php?from_station=$from_station&to_station=$to_station&seat=$seat&trainid=$trainid&date=$date&type=$type&price=$price\">返回</a>重新预订。";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
    echo "<script>alert('哦豁，预订失败！')</script>";
}

echo "<p><b><a href = \"book_back.php?from_station=$to_station&to_station=$from_station&date=$date&username=$username\">点击</a>查询返程信息。</b></p>";

    echo "<br>";
	echo "<div><p>
             <a href = \"../search/book_search.php\"><input type=\"button\" value = \"返回订单查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
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

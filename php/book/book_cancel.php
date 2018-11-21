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
$bookid=$_GET["bookid"];

echo "<center>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$get_train = <<<EOF
		SELECT *
		From Book
		WHERE B_Id=$bookid;
EOF;
$ret=pg_query($dbconn,$get_train);
$train_row=pg_fetch_row($ret);
$trainid=$train_row[4];
$from_station=$train_row[5];
$to_station=$train_row[6];
$date=$train_row[3];
$price=$train_row[2];
/*
echo $userid;
echo "<br>";
echo $trainid;
echo "<br>";
echo $date;
echo "<br>";
echo $price;
echo "<br>";
echo $from_station;
echo "<br>";
echo $to_station;
echo "<br>";
*/
$get_train_info = <<<EOF
				SELECT T_StartTime
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_Station = '$from_station';
EOF;
$ret=pg_query($dbconn,$get_train_info);
if (!$ret)
	echo "WARNING!!!!";
$train_row=pg_fetch_row($ret);
$go_time=$train_row[0];

$get_train_info = <<<EOF
		SELECT T_ArrivalTime
		FROM Train
		WHERE T_Name='$trainid'
		AND T_Station='$to_station';
EOF;
$ret=pg_query($dbconn,$get_train_info);
$train_row=pg_fetch_row($ret);
$got_time=$train_row[0];
/*
echo $go_time;
echo "<br>";
echo $got_time;
echo "<br>";
*/
$seatst   = array("YZ"=>"硬座", "RZ"=>"软座", "YW1"=>"硬卧上", "YW2"=>"硬卧中", "YW3"=>"硬卧下", "RW1"=>"软卧上", "RW2"=>"软卧下");
$get_seat_type = <<<EOF
		SELECT Se_Type
		FROM Seat
		WHERE Se_Train = '$trainid'
		AND Se_Date = '$date'
		AND Se_Station = '$from_station';
EOF;
$ret=pg_query($dbconn,$get_seat_type);
if (!$ret)
	echo "WARNING!!!!";
$seat_row=pg_fetch_row($ret);
$type=$seat_row[0];
$seat=$seatst[$type];
//echo $type;
//echo $seat;
//$del=($userid%2==0);
$cancel = <<<EOF
			UPDATE Book
			SET B_Status = 'cancelled'
			WHERE b_Id = '$bookid';
EOF;
$del = pg_query($dbconn, $cancel);

//余票！！！！！！
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
if (!$ret_s)
	echo "WARNING!!!!";
$row_s = pg_fetch_row($ret_s);
$new_num=$row_s[0]+1;
//echo $new_num;
$seat_num = <<<EOF
				update Seat 
				set Se_Num=$new_num 
				WHERE Se_Train = '$trainid'
				AND Se_Date = '$date'
				AND Se_Station = '$row_p[0]'
				AND Se_Type = '$type';
EOF;
$del2=pg_query($dbconn, $seat_num);
}
if($del&&$del2){
	//到达日期判断
	if (($got_time-$to_time])<0)
		$to_date=datadd(1,$date);
	else
		$to_date=$date;

    echo "<p><H4>您已成功取消一张 出发日期为 $date , 出发时间为 $go_time ，到达日期为 $to_date , 到达时间为 $got_time , 从 $from_station 到 $to_station 的 $trainid 次列车的 $seat 票 一张，票价为 $price (含5元手续费) 。</H4></p>";
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

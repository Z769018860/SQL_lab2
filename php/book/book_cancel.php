<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-订单取消</title>
</head>

<body background="../image/123.jpg">
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
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../serve/book.php'\">返回订单查询</a>
   </div> ";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../bin/user_signin.php'\">返回服务选择</a>
   </div> ";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../index.php'\">退出登录</a>
   </div> ";

//pg_close($conn);
//echo $username;
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

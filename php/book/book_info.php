<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-预订车票</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>预订车票</h2></b></p></div>
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
echo "<H3>尊敬的用户 $username ，您的订单 $bookid 详情如下：</H3>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

/*
$get_book_info = <<<EOF
				SELECT * 
				FROM book
				WHERE b_id = $bookid;
EOF;
$ret = pg_query($conn, $get_book_info);
$row_num = pg_num_rows($ret);
//echo $row_num;
if ($row_num == 0){
	echo "网页错误";
}
$info = pg_fetch_row($ret);
*/
// 获取出发和到达站的名字
/*
$sd1  = $info[4];
$sd2  = $info[5];
$trainid = $info[2];
$sdname1 = <<<EOF
	 SELECT p_stationname 
	 FROM passby
	 WHERE p_stationnum = $sd1 
	 AND p_trainid = '$trainid';
EOF;

$ret = pg_query( $conn, $sdname1 );

if (!$ret){
	echo "执行失败";
}
$x = pg_num_rows($ret);
if(!$x){
	echo "错误";
}
$station1 = pg_fetch_row($ret);
$station1name = $station1[0];
echo $station1name;
$sdname2 = <<<EOF
		SELECT p_stationname 
		FROM passby 
		WHERE p_stationnum = $sd2
		AND p_trainid = '$trainid';
EOF;
$ret = pg_query( $conn, $sdname2 );
if (!$ret){
	echo "执行失败";
}
$station2 = pg_fetch_row($ret);
$station2name = $station2[0];
echo $station2name;
*/
$status = array ("normal"=>"未乘坐", "cancelled"=>"已取消", "past"=>"已乘坐");
$seat   = array("YZ"=>"硬座", "RZ"=>"软座", "YW1"=>"硬卧上", "YW2"=>"硬卧中", "YW3"=>"硬卧下", "RW1"=>"软卧上", "RW2"=>"软卧下");

$index_ofse = $info[6];
$index_ofst = $info[8];
echo "<table border = \"4\">";
echo "<tr>";
echo "<td>用户名</td>";
echo "<td>用户ID</td>";
echo "<td>订单号</td>";
echo "<td>列车号</td>";
echo "<td>出发日期</td>";
echo "<td>出发站</td>";
echo "<td>到达日期</td>";
echo "<td>到达站</td>";
echo "<td>座位类型</td>";
echo "<td>票价</td>";
echo "<td>订单状态</td>";
echo "<td>是否取消</td>";
echo "</tr>";

echo "<tr>";
echo "<td>$username</td>";
echo "<td>$userid</td>";
echo "<td>$info[0]</td>";
echo "<td>$info[2]</td>";
echo "<td>$info[3]</td>";
echo "<td>$station1name</td>";
echo "<td>$info[5]</td>";
echo "<td>$station2name</td>";
echo "<td>$seat[$index_ofse]</td>";
echo "<td>$info[7]</td>";
echo "<td>$status[$index_ofst]</td>";
/*if ($info[8] = "normal"){*/
    echo "<td><a href=\"../book/book_cancel.php\"  target=\"_blank\"><center>取消</center></a></td>";
/*}
else{
	echo "<td>不可取消</td>";
}
*/
echo "</tr>";
echo "</table>";

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
	<center>
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

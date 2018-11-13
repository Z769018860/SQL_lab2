<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-具体车次查询结果</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>具体车次查询结果</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$trainid = $_POST["trainid"];
$train_date = $_POST["train_date"];

echo "<center>";
echo "<H3>尊敬的用户 $username ，您查询的车次 $trainid 信息如下：</H3>";
/*
$conn = pg_connect("host=localhost port=5432 dbname=train user=fenglv password=nopasswd");
if (!$conn){
	echo "连接失败";
}

$sql = <<<EOF
	SELECT * FROM passby WHERE p_trainid = '$trainid';
EOF;
$ret = pg_query($conn, $sql);
$row_num = pg_num_rows($ret);
*/
$row_num=1;
if ($row_num==0)
{
    echo "<b>";
	$back_href = "../serve/train_search.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "无任何车次信息！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新输入查询";
    echo "</br>";
    echo "</p>";
    echo "</FONT>";
    echo "</b>";
}
else
{
echo "<table border=\"4\"><tr>";
echo "<td>始发站</td>";
echo "<td>$first_name</td>";
echo "<td>终点站</td>";
echo "</table>";

echo "<H4><p>列车 $trainid 的票价信息如下</p></H4>";

echo "<td>$last_name</td>";
echo "<table border=\"4\"><tr>";
echo "<td>站名</td>" ;
echo "<td>到达时间</td>" ;
echo "<td>出发时间</td>";
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";
/*
while ($row = pg_fetch_row($ret)){
	////echo count($row);
	$num = count($row);
	echo "<tr>";
	for ( $i = 0; $i < $num; $i = $i + 1 ){
		echo "<td>" . "$row[$i]" . "</td>";
	}
	echo "</tr>";
}
*/
echo "</table>";

//获取总站数
/*
$get_station_num = <<<EOF
				SELECT COUNT(p_trainid)
				FROM passby
				WHERE p_trainid = '$trainid';
EOF;
$ret = pg_query($conn, $get_station_num);
$station_num = pg_fetch_row($ret);
$sta_num = $station_num[0];

$get_first = <<<EOF
				SELECT p_stationname
				FROM passby
				WHERE p_trainid = '$trainid'
				AND p_stationnum = 1;
EOF;
$ret1 = pg_query($conn, $get_first);
$row = pg_fetch_row($ret1);
$first_name = $row[0];
$get_last = <<<EOF
				SELECT p_stationname
				FROM passby
				WHERE p_trainid = '$trainid'
				AND p_stationnum = $sta_num;
EOF;
$ret1 = pg_query($conn, $get_last);
$row = pg_fetch_row($ret1);
$last_name = $row[0];
*/
/*
$get_price = <<<EOF
			SELECT *
			FROM passby
			WHERE p_trainid = '$trainid' 
			AND   p_stationnum = $sta_num;
EOF;

$ret = pg_query($conn, $get_price);
$hastype = array();
$price = pg_fetch_row($ret);

$hastype = array($price[5], $price[6], $price[7],
 $price[8], $price[9], $price[10], $price[11]);
*/
//获取余票信息
/*
$get_booked_ticket = <<<EOF
				with T1(T1_Type, T1_SeatNum) as
				(SELECT T_Type, T_SeatNum
				 FROM TicketInfo 
				 WHERE T_TrainId = '$trainid'
					AND T_PStationNum >= 1
					AND T_PStationNum < $sta_num
					AND T_Date = '$thedate')
				
				SELECT T1_Type, MAX(T1_SeatNum)
				FROM T1
				GROUP BY T1_Type;
EOF;
$ret = pg_query($conn, $get_booked_ticket);
if (!$ret){
	echo "执行失败";
}
*/
/*
$all_type = array("YZ", "RZ", "YW1", "YW2", "YW3", "RW1", "RW2");

$left_num = array(0, 0, 0, 0, 0, 0, 0);

for ($i = 0; $i < 7; $i = $i + 1){
	//for ($j = 0; $j < count($all_result); $j = $j + 1){
	//    //if ($j == $i && )
	//        $booked = $all_result[$i][$j];
	//}
	if (!$hastype[$i])
		$left_num[$i] = -1;//不存在
	else
		$left_num[$i] = 5;
}
//计算余票
while ($row = pg_fetch_row($ret)){
	for ($i = 0; $i <7; $i = $i + 1){
		if ($row[0] == $all_type[$i])
			$left_num[$i] = 5 - $row[1];
	}
}
*/
echo "<H4><p>$train_date ，列车 $trainid 的余票信息如下</p></H4>";
echo "<table border = \"4\">";
echo "<tr>";
echo "<td>站名</td>" ;
echo "<td>到达时间</td>" ;
echo "<td>出发时间</td>";
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";
echo "<tr>";

echo "<tr>";
echo "<td></td><td></td><td></td>";
for ($i = 0; $i <7; $i = $i + 1)
{
    echo "<td><a href=\"../book/booking.php\"  target=\"_blank\"><center>--</center></a></td>";
}
/*
for ($i = 0; $i <7; $i = $i + 1){
	if ($left_num[$i] == -1)
		echo "<td> - </td>";
	elseif( $left_num[$i] == 0 )
		echo "<td>0</td>";
	else{
		$k = $i + 5;
		echo "<td><a href=\"booking.php?trainid=$trainid&date=$thedate&type=$all_type[$i]&price=$price[$k]&fromstation=1&tostation=$sta_num\">$left_num[$i]</a></td>";

	}
}
*/
echo "</tr>";
echo "</table>";
    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/train_search.php\"><input type=\"button\" value = \"返回车次查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../bin/user_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";
echo "</center>";
//pg_close($conn);

}


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

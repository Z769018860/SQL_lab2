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

    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$sql = <<<EOF
	SELECT * FROM Train WHERE T_Name = '$trainid';
EOF;
$ret = pg_query($dbconn, $sql);
$row_num = pg_num_rows($ret);

//$row_num=1;
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
$get_station_num = <<<EOF
				SELECT COUNT(T_StNum)
				FROM Train
				WHERE T_Name = '$trainid';
EOF;
$ret2 = pg_query($dbconn, $get_station_num);
$station_num = pg_fetch_row($ret2);
$sta_num = $station_num[0];

$get_first = <<<EOF
				SELECT T_Station
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_StNum = 1;
EOF;
$ret1 = pg_query($dbconn, $get_first);
$row = pg_fetch_row($ret1);
$first_name = $row[0];

$get_last = <<<EOF
				SELECT T_Station
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_StNum = $sta_num;
EOF;
$ret3 = pg_query($dbconn, $get_last);
$row = pg_fetch_row($ret3);
$last_name = $row[0];

echo "<table border=\"4\"><tr>";
echo "<td>始发站</td>";
echo "<td>$first_name</td>";
echo "<td>终点站</td>";
echo "<td>$last_name</td>";
echo "</table>";

echo "<H4><p>列车 $trainid 的票价信息如下</p></H4>";
echo "<table border=\"4\"><tr>";
echo "<td>站名</td>" ;
echo "<td>站号</td>" ;
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

while ($row = pg_fetch_row($ret)){
	////echo count($row);
	$num = count($row);
	echo "<tr>";
	for ( $i = 1; $i < $num; $i = $i + 1 ){
		echo "<td>" . "$row[$i]" . "</td>";
	}
	echo "</tr>";
}

echo "</table>";


echo "<H4><p>$train_date ，列车 $trainid 的余票信息如下</p></H4>";
echo "<table border = \"4\">";
echo "<tr>";
echo "<td>站名</td>" ;
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";
echo "<tr>";


//获取余票信息
$all_type = array("YZ", "RZ", "YW1", "YW2", "YW3", "RW1", "RW2");

$get_train_station = <<<EOF
				SELECT T_Station
				From Train
				Where T_Name = '$trainid';
EOF;
$ret_t = pg_query($dbconn, $get_train_station);
while ($row = pg_fetch_row($ret_t)){
	echo "<td> $row[0] </td>";
$get_stnum=<<<EOF
				SELECT T_StNum
				FROM Train
				WHERE T_Name = '$trainid'
				and T_Station = '$row[0]';
EOF;
$ret_stnum = pg_query($dbconn, $get_stnum);
$row_stnum = pg_fetch_row($ret_stnum);
$to_stnum=$row_stnum[0]-1;
//echo $to_stnum;

for ($i = 0; $i <7; $i = $i + 1){

	$get_seat_num = <<<EOF
				SELECT MIN(Seat.Se_Num)
				FROM Train,Seat
				WHERE Train.T_Name = '$trainid'
    				AND Seat.Se_Train = Train.T_Name
    				AND Seat.Se_Date = '$train_date'
    				AND Seat.Se_Type = '$all_type[$i]'
    				AND Seat.Se_Station = Train.T_Station
    				AND Train.T_StNum BETWEEN 1 AND $to_stnum;
EOF;
$ret_s = pg_query($dbconn, $get_seat_num);
$row_s = pg_fetch_row($ret_s);
	$get_seat_money = <<<EOF
				SELECT *
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_Station = '$row[0]';
EOF;
$ret_m = pg_query($dbconn, $get_seat_money);
$hastype = array();
$price = pg_fetch_row($ret_m);
$hastype = array($price[5], $price[6], $price[7],
 $price[8], $price[9], $price[10], $price[11]);
if (!$hastype[$i])
	echo "<td> -- </td>";

else if (!$row_s[0])
	echo "<td><a href=\"../book/booking.php?date=$train_date&trainid=$trainid&date=$train_date&type=$all_type[$i]&price=$hastype[$i]&from_station=$first_name&to_station=$row[0]\">5</a></td>";

else
	echo "<td><a href=\"../book/booking.php?date=$train_date&trainid=$trainid&date=$train_date&type=$all_type[$i]&price=$hastype[$i]&from_station=$first_name&to_station=$row[0]\">$row_s[0]</a></td>";
}
echo "</tr>";
}

echo "</table>";
    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/train_search.php\"><input type=\"button\" value = \"返回车次查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../bin/user_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";
echo "</center>";
pg_close($dbconn);

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

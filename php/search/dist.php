<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-两地间车次查询结果</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>两地间车次查询结果</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$from_station = $_POST["from_station"];
$to_station = $_POST["to_station"];
$from_date = $_POST["from_date"];
$from_time = $_POST["from_time"];

echo "<center>";
echo "<H3>尊敬的用户 $username ，您查询的相应车次余票信息如下：</H3>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";
/*
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
echo "<td>车次</td>" ;
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达日期</td>";
echo "<td>到达时间</td>";
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";

echo "<tr>";
echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
for ($i = 0; $i <7; $i = $i + 1)
{
    echo "<td><a href=\"../book/booking.php\" target=\"_blank\"><center>--</center></a></td>";
}

/*
$hastype = array($a_row[5], $a_row[6], $a_row[7],
 $a_row[8], $a_row[9], $a_row[10], $a_row[11]);
$get_booked_ticket = <<<EOF
				with T1(T1_Type, T1_SeatNum) as
				(SELECT T_Type, T_SeatNum
				 FROM TicketInfo 
				 WHERE T_TrainId = '$a_row[0]'
					AND T_PStationNum >= $a_row[12]
					AND T_PStationNum < $a_row[13]
					AND T_Date = '$thedate')
				
				SELECT T1_Type, MAX(T1_SeatNum)
				FROM T1
				GROUP BY T1_Type;
EOF;
$ret = pg_query($conn, $get_booked_ticket);
if (!$ret){
	echo "执行失败";
}
$all_type = array("YZ", "RZ", "YW1", "YW2", "YW3", "RW1", "RW2");

$left_num = array(0, 0, 0, 0, 0, 0, 0);

for ($i = 0; $i < 7; $i = $i + 1){
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

echo "<tr>";
echo "<td></td><td></td><td></td><td></td><td></td>";
for ($i = 0; $i <7; $i = $i + 1){
	if ($left_num[$i] == -1)
		echo "<td> - </td>";
	elseif( $left_num[$i] == 0 )
		echo "<td>0</td>";
	else{
		//$k = $i + 5;
		//echo $price[$k] . "   ";
		echo "<td><a href=\"booking.php?trainid=$a_row[0]&date=$thedate&type=$all_type[$i]&price=$hastype[$i]&fromstation=$a_row[12]&tostation=$a_row[13]\">$left_num[$i]</a></td>";

	}
}
*/
echo "</tr>";
echo "</table>";
    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/dist_search.php\"><input type=\"button\" value = \"返回车次查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
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

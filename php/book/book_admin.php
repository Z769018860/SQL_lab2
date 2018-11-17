<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-用户订单（管理员）</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>用户订单（管理员）</h2></b></p></div>
<br>
<?php
function datadd($n, $date){
    return date("Y-m-d", strtotime($date ." +$n day"));
}
session_start();
$username = $_SESSION["username"];
$userid = $_SESSION["userid"];
$date_min = $_POST["from_date_min"];
$date_max = $_POST["from_date_max"];

echo "<center>";

echo "<H3>尊敬的管理员，您现在正在查看用户 $username 的订单信息</H3>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";
/*

$get_uid = <<<EOF
			SELECT user_id
			FROM userinfo
			WHERE u_uname = '$username';
EOF;
$ret = pg_query($conn, $get_uid);
$row = pg_fetch_row($ret);
$uid = $row[0];
$select_book = <<<EOF
			SELECT b_id 
			FROM book 
			WHERE b_date BETWEEN '$date_min' AND '$date_max' AND b_userid = '$uid' ORDER BY b_date DESC;
EOF;
$ret = pg_query($conn, $select_book);
if (!$ret){
	echo "查询失败！";
}
$row_num = pg_num_rows($ret);
*/
$row_num=($userid%2==0);
if ($row_num == 0){
	echo "<b>";
	$back_href = "../bin/admin_signin.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "一贫如洗！闻者落泪！该用户无任何订单信息！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新选择用户";
    echo "</br>";
    echo "</p>";
    echo "</FONT>";
    echo "</b>";
}
else{
    $status = array ("normal"=>"未乘坐", "cancelled"=>"已取消", "past"=>"已乘坐");
    $seat   = array("YZ"=>"硬座", "RZ"=>"软座", "YW1"=>"硬卧上", "YW2"=>"硬卧中", "YW3"=>"硬卧下", "RW1"=>"软卧上", "RW2"=>"软卧下");
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

echo "</tr>";
echo "</table>";
/*
	while ($all_record = pg_fetch_row($ret)){
		$i = $i + 1;
		$sd1 = $all_record[4];
		$sd2 = $all_record[5];
		$trainid = $all_record[2];
		$sdname = <<<EOF
			 SELECT p_stationname
			 FROM passby 
			 WHERE p_stationnum = $sd1
			 AND p_trainid = '$trainid';
EOF;
		$ret1 = pg_query( $conn, $sdname );
		$station1 = pg_fetch_row($ret1);
		$station1name = $station1[0];
		$sdname = <<<EOF
			 SELECT p_stationname 
			 FROM passby 
			 WHERE p_stationnum = $sd2
			 AND p_trainid = '$trainid';
EOF;
		$ret1 = pg_query( $conn, $sdname );
		$station2 = pg_fetch_row($ret1);
		$station2name = $station2[0];

		echo "<tr>";
		for ( $j = 0; $j < 4; $j = $j + 1 )
			echo "<td>$all_record[$j]</td>";
		$se_index = $all_record[6];
		$st_index = $all_record[8];
		echo "<td>$station1name</td>";
		echo "<td>$station2name</td>"; 
		echo "<td>$seat[$se_index]</td>";
		echo "<td>$all_record[7]</td>";
		echo "<td>$status[$st_index]</td>";
		echo "</tr>";
*/
}
    echo "<br>";
	echo "<div><p>
             <a href = \"../bin/admin_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";
    
    echo "</center>";

pg_close($dbconn);
//echo $username;
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

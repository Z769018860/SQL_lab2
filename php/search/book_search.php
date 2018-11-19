<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-用户订单查询结果</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>用户订单查询结果</h2></b></p></div>
<br>
<?php
function datadd($n, $date){
    return date("Y-m-d", strtotime($date ." +$n day"));
}
session_start();
$username = $_SESSION["username"];
//$userid = $_SESSION["userid"];
$date_min = $_POST["from_date_min"];
$date_max = $_POST["from_date_max"];
/*
echo $date_min;
echo "<br>";
echo $date_max;
echo "<br>";
echo $userid;
echo "<br>";
*/
echo "<center>";
echo "<H3>尊敬的用户 $username ，您的订单查询结果详情如下</H3>";

    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$get_uid = <<<EOF
			SELECT U_ICNum
			FROM MyUser
			WHERE U_UName = '$username';
EOF;
$ret = pg_query($dbconn, $get_uid);
$row = pg_fetch_row($ret);
$userid = $row[0];
//echo $userid;
$_SESSION["userid"]=$userid;

$select_book = <<<EOF
			SELECT * 
			FROM Book 
			WHERE B_Date BETWEEN '$date_min' AND '$date_max' 
			AND B_User = '$userid' ORDER BY B_Id;
EOF;
$ret = pg_query( $dbconn, $select_book );
$row_num = pg_num_rows($ret);
if (!$ret)
	echo "查询失败！";
//$row_num=($userid%2==0);
if (!$row_num){
	echo "<b>";
	$back_href = "../serve/book.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "无任何订单信息！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新选择时间段";
    echo "</br>";
    echo "</p>";
    echo "</FONT>";
    echo "</b>";
}
else{
$status = array ("cancelled"=>"已取消", "uncancelled"=>"未取消");

echo "<table border = \"4\">";
echo "<tr>";
echo "<td>订单号</td>";
echo "<td>订单状态</td>";
echo "<td>查看详情</td>";
echo "<td>是否取消</td>";
echo "</tr>";

while ($row = pg_fetch_row($ret))
{
	$bookst=$row[7];
	echo "<tr>";
	echo "<td>$row[0]</td>";
	echo "<td>$status[$bookst]</td>";
echo "<td><a href=\"../book/book_info.php?bookid=$row[0]\"  target=\"_blank\"><center>查看</center></a></td>";
if ($row[7] == "uncancelled"){
    echo "<td><a href=\"../book/book_cancel.php?bookid=$row[0]\"  target=\"_blank\"><center>取消</center></a></td>";
}else	echo "<td>不可取消</td>";
	echo "</tr>";
}

	echo "</table>";
}
    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/book.php\"><input type=\"button\" value = \"返回订单查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../bin/user_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";
pg_close($dbconn);
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

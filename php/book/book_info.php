<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-查看车票详情</title>
</head>

<body background="../image/123.jpg">
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>查看车票详情</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$userid = $_SESSION["userid"];
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


$get_book_info = <<<EOF
				SELECT * 
				FROM Book
				WHERE B_id = $bookid;
EOF;
$ret = pg_query($dbconn, $get_book_info);
$row_num = pg_num_rows($ret);
//echo $row_num;
if (!$row_num){
	echo "未知错误！查看失败！";
}
$info = pg_fetch_row($ret);

$status = array ( "cancelled"=>"已取消", "uncancelled"=>"未取消");

$bookst = $info[7];

echo "<table border = \"4\">";
echo "<tr>";
echo "<td>用户名</td>";
echo "<td>用户ID</td>";
echo "<td>订单号</td>";
echo "<td>列车号</td>";
echo "<td>出发日期</td>";
echo "<td>出发站</td>";
echo "<td>到达站</td>";
echo "<td>票价</td>";
echo "<td>订单状态</td>";
echo "<td>是否取消</td>";
echo "</tr>";

echo "<tr>";
echo "<td>$username</td>";
echo "<td>$userid</td>";
echo "<td>$info[0]</td>";
echo "<td>$info[4]</td>";
echo "<td>$info[3]</td>";
echo "<td>$info[5]</td>";
echo "<td>$info[6]</td>";
echo "<td>$info[2]</td>";
echo "<td>$status[$bookst]</td>";
if ($info[7] == "uncancelled"){
    echo "<td><a href=\"../book/book_cancel.php?bookid=$info[0]\"  target=\"_blank\"><center>取消</center></a></td>";
}else	echo "<td>不可取消</td>";
echo "</tr>";

echo "</table>";

    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/book.php\"><input type=\"button\" value = \"返回订单查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
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

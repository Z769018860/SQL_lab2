<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-管理员登录</title>
</head>

<body background="../image/123.jpg">
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><h2> <b>管理员您好！Hello，my master!</b></h2></p></div>
    <div><h2> <b>以下信息请您过目：</b></h2></div>
    <br>

<?php
// 管理员登录
 $name="管理员";
 $userid="000000000000000000";
 $usertel="00000000000";
 $cardid="0000000000000000";
 $username="admin";
 $password="111111";

    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$booknum = <<<EOF
	SELECT COUNT(*), SUM(B_Money) FROM Book;
EOF;
$ret = pg_query( $dbconn, $booknum );
if (!$ret){
	echo "执行失败";
}
$result = pg_fetch_row($ret);
$ticket_num = $result[0];
$money_num = $result[1];
if ($ticket_num == 0) {
	$money_num = 0;
}
echo "<center>";
echo "<p><b>当前总订单数：$ticket_num .</b></p>";
echo "<p><b>当前总票价：$money_num .</b></p>";

$select_hot_train = <<<EOF
				SELECT B_Train, COUNT(B_Train) 
				FROM Book
				GROUP BY B_Train ORDER BY  COUNT(B_Train) DESC;
EOF;
$ret = pg_query( $dbconn, $select_hot_train );
$i = 0;

echo "<FONT color=#ff0000>";
echo "<h3><b>热门车次</b></h3>";
echo "</FONT>";
echo "<table border=\"4\"><tr><th>列车号</th><th>订单数</th></tr>";


while ( $i < 10 && $row = pg_fetch_row($ret) ){
	echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
	$i = $i + 1;
}

echo "</table>";
echo "<br>";

//show user info 

$select_user = <<<EOF
	SELECT * FROM MyUser;
EOF;
$ret = pg_query($dbconn, $select_user);

$usernum = <<<EOF
	SELECT COUNT(*) FROM MyUser;
EOF;
$ret2 = pg_query( $dbconn, $usernum );
if (!$ret2){
	echo "执行失败";
}
$result = pg_fetch_row($ret2);
$user_num = $result[0];


echo "<FONT color=#66CD00>";
echo "<h3><b>当前已注册用户列表（包含游客）：$user_num </b></h3>";
echo "</FONT>";
echo "<table border = \"4\"><tr><th>身份证号</th><th>手机号</th><th>用户名</th><th>姓名</th><th>信用卡号</th><th>查看订单</th</tr>";
//}
while ($row = pg_fetch_row($ret)){
	$userid = $row[0];
	$username = $row[2];
	echo "<tr>";
	for ($i = 0; $i < 5; $i = $i + 1){
		echo "<td>$row[$i]</td>";	
	}
	echo "<td><a href = \"../book/book_admin.php?username=$username&userid=$userid \" target=\"_blank\">查看</a></td>";
	echo "</tr>";
	}
echo "</table>";
echo "<br>";
pg_close($dbconn);
//}
echo "</center>";
?>

	<center>		
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
	    <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>

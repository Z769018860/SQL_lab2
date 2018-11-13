<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-管理员登录</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b>管理员您好！Hello，my master!</b></p></div>
    <div><p> <b>以下信息请您过目：</b></p></div>
    <br>

<?php
// 管理员登录
 $name="管理员";
 $userid="000000000000000000";
 $usertel="00000000000";
 $cardid="0000000000000000";
 $username="admin";
 $password="111111";

$ticket_num=0;
$money_num=0;
$user_num=0;
echo "<center>";
echo "<p><b>当前总订单数：$ticket_num .</b></p>";
echo "<p><b>当前总票价：$money_num .</b></p>";

echo "<FONT color=#ff0000>";
echo "<p><b>热门车次</b></p>";
echo "</FONT>";
echo "<table border=\"4\"><tr><th>列车号</th><th>订单数</th><th>查看详情</th></tr>";
/*
while ( $i < 10 && $row = pg_fetch_row($ret) ){
	echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
	$i = $i + 1;
}
*/
echo "</table>";
echo "<br>";

//show user info 
/*
$select_user = <<<EOF
	SELECT * FROM userinfo;
EOF;
$ret = pg_query($conn, $select_user);
*/
echo "<p><b>当前注册用户总数：：$user_num .</b></p>";

echo "<FONT color=#66CD00>";
echo "<p><b>当前已注册用户列表（包含游客）</b></p>";
echo "</FONT>";
echo "<table border = \"4\"><tr><th>用户ID</th><th>姓名</th><th>身份证号</th><th>手机号</th><th>信用卡号</th><th>用户名</th><th>查看订单</th</tr>";
//}
/*
while ( $row = pg_fetch_row($ret) ){
	$id = $row[0];
	$username = $row[3];
	echo "<tr>";
	for ($i = 0; $i < 2; $i = $i + 1){
		echo "<td>$row[$i]</td>";	
	}
	echo "<td>$id</td>";
	for ( $i = 2; $i < 5; $i = $i + 1 ){
		echo "<td>$row[$i]</td>";
	}
	echo "<td><a href = \"userbook.php?username=$username&id=$id\">订单</a></td>";
	echo "</tr>";
	}
    */
echo "</table>";
echo "<br>";
//pg_close($conn);
//}
echo "</center>";
?>

	<center>		
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
	</center>
</body>
</html>

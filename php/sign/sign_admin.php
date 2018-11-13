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
	<div><p> <b>管理员登录</b></p></div>

<?php
// 管理员登录
 $name="管理员";
 $userid="000000000000000000";
 $usertel="00000000000";
 $cardid="0000000000000000";
 $username="admin";
 $password="111111";

 echo "<center>";
 echo "<table>";
 echo "<tr><td>";
 echo "<br>";
 echo "姓名：$name";
 echo "</br>";
 echo "</tr></td>";
 echo "<tr><td>";
 echo "<br>";
 echo "身份证：$userid";
 echo "</br>";
 echo "</tr></td>";
 echo "<tr><td>";
 echo "<br>";
 echo "手机号：$usertel";
 echo "</br>";
 echo "</tr></td>";
 echo "<tr><td>";
 echo "<br>";
 echo "信用卡：$cardid";
 echo "</br>";
 echo "</tr></td>";
 echo "<tr><td>";
 echo "<br>";
 echo "用户名：$username";
 echo "</br>";
 echo "</tr></td>";
 echo "<tr><td>";
 echo "<br>";
 echo "密码：$password";
 echo "</br>";
 echo "</tr></td>";
 echo "<tr><td>";
 echo "<br>";
 echo "</table>";
 echo "</center>";

?>
	<center>		
    <div>
    <p><form action="../bin/admin_signin.php" method="post"></p>
    			<p><input type="submit" name="登录" value="登录" ><br></p>
			</form></b>

    <div>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
	</center>
</body>
</html>

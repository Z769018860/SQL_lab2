<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-游客登录</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b>游客登录</b></p></div>
    </center>
<?php
/*
 * 生成随机字符串
 * @param int $length 生成随机字符串的长度
 * @param string $char 组成随机字符串的字符串
 * @return string $string 生成的随机字符串
 */
function str_rand_6($length = 6, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!is_int($length) || $length < 0) {
        return false;
    }

    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }

    return $string;
}
function str_rand_8($length = 8, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!is_int($length) || $length < 0) {
        return false;
    }

    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }

    return $string;
}
function num_rand_11($length = 11, $char = '0123456789') {
    if(!is_int($length) || $length < 0) {
        return false;
    }

    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }

    return $string;
}
function num_rand_18($length = 18, $char = '0123456789') {
    if(!is_int($length) || $length < 0) {
        return false;
    }

    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }

    return $string;
}
function num_rand_16($length = 16, $char = '0123456789') {
    if(!is_int($length) || $length < 0) {
        return false;
    }

    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }

    return $string;
}
//echo str_rand(),"<br />";

/*
 * 生成32位唯一字符串
 */
$uniqid = md5(uniqid(microtime(true),true));
//echo $uniqid;
 $user_signup=0;

 $name="游客";
 $userid=num_rand_18();
 $usertel=num_rand_11();
 $cardid=num_rand_16();
 $username=str_rand_8();
 $password=str_rand_6();
 Session_start(); 
 $_SESSION["name"] = $name;
 $_SESSION["userid"] = $userid;
 $_SESSION["usertel"] = $usertel;
 $_SESSION["cardid"] = $cardid;
 $_SESSION["username"] = $username;

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
    <p><form action="../bin/user_signup_random.php" method="post"></p>
    			<p><input type="submit" name="登录" value="登录" ><br></p>
			</form></b>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
	</center>

</body>
</html>

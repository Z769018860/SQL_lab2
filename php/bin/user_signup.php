<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-新用户注册</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b>新用户注册</b></p></div>
<?php 
    $name = $_POST["name"];
    $username = $_POST["username"];
    $userid = $_POST["userid"];
    $usertel = $_POST["usertel"];
    $cardid = $_POST["cardid"];

// 检查输入是否合法
$name_len = strlen("$name");
$uid_len = strlen("$userid");
$phone_len = strlen("$usertel");
$card_len = strlen("$cardid");
$uname_len = strlen("$username");
$back_href = "../sign/sign_up.php";

if ($name_len <=1){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "生而为人，你的姓名必然不可能这么短！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
}

elseif ($uid_len != 18){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "生而为人，身份证号必须为18位！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
}

elseif($phone_len != 11){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "人在江湖，手机号必须为11位！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
}

elseif($card_len != 16){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "财连于命，信用卡必须为16位！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
}

elseif ($uname_len >20){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "劝你善良，你的用户名怎么可以超过20字符！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
}
//输入均合法，检查用户名是否重复
/*
else{
$conn = pg_connect("host=localhost port=5432 dbname=train user=fenglv password=nopasswd");
if (!$conn){
	echo "连接失败";
}
//echo $username;
//echo "<br>";
$sql =<<<EOF
		SELECT u_uname 
		FROM userinfo 
		WHERE u_uname='$username';
EOF;
$ret = pg_query($conn, $sql);
//$result = pg_fetch_all($ret);
$sum = pg_num_rows($ret);

$sql_uid = <<<EOF
			SELECT user_id 
			FROM userinfo
			WHERE user_id = '$user_id';
EOF;
$ret = pg_query($conn, $sql_uid);
$sum_uid = pg_num_rows($ret);

$sql_phone = <<<EOF
			SELECT u_phone
			FROM userinfo
			WHERE u_phone = '$phone';
EOF;
$ret = pg_query($conn, $sql_phone);
$sum_phone = pg_num_rows($ret);
//echo $sum;
*/
else
{
$sum=($username=="123");
$sum_uid=($userid=="111111111111111111");
$sum_phone=($usertel=="11111111111");
if ($sum || $username == "admin"){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "如有雷同纯属巧合？你的用户名已被注册！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
}

elseif ($sum_uid || $userid=="000000000000000000"){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "如有雷同纯属巧合？你的身份证号已被注册！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";

}

elseif($sum_phone || $usertel=="00000000000"){
	echo "<center>";
    echo "<b>";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "WARNING!!!";
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo "如有雷同纯属巧合？你的手机号已被注册！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新注册。";
    echo "</FONT>";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";

}
//输入正确
else{
/*
	$ins = <<<EOF
		INSERT INTO 
		userinfo(user_id,u_name,u_phone, u_uname, u_creditcardid) 
		VALUES ('$user_id', '$name', '$phone', '$username', '$card');
EOF;

	$insert = pg_query($conn, $ins);
*/
$insert=1;
	if (!$insert){
	    echo "<center>";
        echo "<b>";
        echo "<p>";
        echo "<br>";
        echo "<FONT color=#ff0000>";
	    echo "WARNING!!!";
        echo "</br>";
        echo "</p>";
        echo "<p>";
        echo "<br>";
        echo "未知错误！用户注册失败！" ;
        echo "</br>";
        echo "</p>";
        echo "<p>";
        echo "<br>";
        echo  "请<a href = $back_href>返回</a>重新注册。";
        echo "</FONT>";
        echo "</br>";
        echo "</p>";
        echo "</b>";
	    echo "</center>";
	}
	else {
		$login = "../sign/sign_in.php";
        echo "<center>";
        echo "<b>";
        echo "<p>";
        echo "<br>";
        echo "<FONT color=#ff0000>";
	    echo "CONGRATULATIONS!!";
        echo "</br>";
        echo "</p>";
        echo "<p>";
        echo "<br>";
        echo "用户 $username 注册成功" ;
        echo "</br>";
        echo "</p>";
        echo "<p>";
        echo "<br>";
        echo  "请立即<a href = $login>登录</a>。享受服务";
        echo "</FONT>";
        echo "</br>";
        echo "</p>";
        echo "</b>";
	    echo "</center>";
 Session_start(); 
 $_SESSION["name"] = $name;
 $_SESSION["userid"] = $userid;
 $_SESSION["usertel"] = $usertel;
 $_SESSION["cardid"] = $cardid;
 $_SESSION["username"] = $username;
	}
}
//pg_close($conn);
}
?>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
        <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>

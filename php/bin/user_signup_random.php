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
Session_start(); 
$name  = $_SESSION["name"];
$userid  = $_SESSION["userid"];
$usertel  = $_SESSION["usertel"];
$cardid = $_SESSION["cardid"];
$username =$_SESSION["username"];
//echo $name;

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
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";


	$ins = <<<EOF
		INSERT INTO 
		MyUser(U_ICNum,U_TelNum,U_UName,U_Name,U_CCNum) 
		VALUES ('$userid','$usertel','$username','$name','$cardid');
EOF;

	$insert = pg_query($dbconn, $ins);

//$insert=1;
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
	}
}
pg_close($dbconn);

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

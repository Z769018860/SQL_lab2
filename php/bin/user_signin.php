<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-老用户登录</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b>老用户登录</b></p></div>

<?php 
// 用户登录
$username = $_POST["username"];

/*
$conn = pg_connect("host=localhost port=5432 dbname=train user=fenglv password=nopasswd");
if (!$conn){
	echo "连接失败";
}

$sql = <<<EOF
	SELECT u_uname FROM userinfo WHERE u_uname = '$username';
EOF;
$ret = pg_query($conn, $sql);
$sum = pg_num_rows($ret);
*/
$sum=($username=="123");
if (!$sum){
	echo "<center>";
    echo "<b>";
	$local_href = "../index.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "用户不存在！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $local_href>返回</a>重新登录/注册。";
    echo "</br>";
    echo "</p>";
    echo "</b>";
	echo "</center>";
	session_destroy();
}
else{
	$_SESSION["username"] = $_POST["username"];
	$trainS_href = "../serve/train-search.php";
	$distS_href  = "../serve/dist-search.php";
	$bookS_href  = "../serve/book.php";
    echo "<center>";
	echo "尊敬的乘客$username" . " ,欢迎访问果壳12306售票网站，我们价格公道童叟无欺！";
	echo "<br>";
	echo "<br>";
	echo "请在下面点击选择您需要的服务：";
    echo "<br>";
	echo "<ul>";
	echo "<div><p>
             <a href = \"../serve/train-search.php\"><input type=\"button\" value = \"查询具体车次\" onclick=\"location.href='./serve/train-search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../serve/dist-search.php\"><input type=\"button\" value = \"查询两地间车次\" onclick=\"location.href='./serve/dist-search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../serve/book.php\"><input type=\"button\" value = \"订单查询\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";
	echo "</ul>";
    echo "</center>";
}
//pg_close($conn);
?>

    <div>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
	</center>
</body>
</html>

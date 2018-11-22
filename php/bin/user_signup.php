<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-新用户注册</title>
</head>

<body background="../image/123.jpg">
	<center>
<div class="container">

 <h1 class="row skew-title"> <span>欢</span><span>迎</span><span>访</span><span>问</span><span>果</span><span class="last">壳</span>   <span>1</span><span>2</span><span>3</span><span class="last">0</span>   <span class="alt">6</span><span class="alt">网</span><span class="alt">站</span><span class="alt last">!</span> </h1>

 <p class="row row--intro"></p>

</div>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><h3> <b>新用户注册</b></h3></div>
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
else
{
//输入均合法，检查用户名是否重复
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$sql =<<<EOF
		SELECT U_UName 
		FROM MyUser
		WHERE U_UName='$username';
EOF;
$ret = pg_query($dbconn, $sql);
$sum = pg_num_rows($ret);

$sql_uid = <<<EOF
			SELECT U_ICNum 
			FROM MyUser
			WHERE U_ICNum = '$userid';
EOF;
$ret = pg_query($conn, $sql_uid);
$sum_uid = pg_num_rows($ret);

$sql_phone = <<<EOF
			SELECT U_TelNum
			FROM MyUser
			WHERE U_TelNum = '$usertel';
EOF;
$ret = pg_query($conn, $sql_phone);
$sum_phone = pg_num_rows($ret);
//$sum=($username=="123");
//$sum_uid=($userid=="111111111111111111");
//$sum_phone=($usertel=="11111111111");
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

	$ins = <<<EOF
		INSERT INTO 
		MyUser(U_ICNum,U_Name,U_TelNum, U_UName, U_CCNum) 
		VALUES ('$userid', '$name', '$usertel', '$username', '$cardid');
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
 Session_start(); 
 $_SESSION["name"] = $name;
 $_SESSION["userid"] = $userid;
 $_SESSION["usertel"] = $usertel;
 $_SESSION["cardid"] = $cardid;
 $_SESSION["username"] = $username;
	}
}
pg_close($dbconn);
}
?>
<script src="js/jquery.min.js"></script>

<script>

(function() {

  $('.skew-title').children('span').hover((function() {

    var $el, n;

    $el = $(this);

    n = $el.index() + 1;

    $el.addClass('flat');

    if (n % 2 === 0) {

      return $el.prev().addClass('flat');

    } else {

      if (!$el.hasClass('last')) {

        return $el.next().addClass('flat');

      }

    }

  }), function() {

    return $('.flat').removeClass('flat');

  });

}).call(this);

</script>

   <style type="text/css">
   <style type="text/css">
body { margin-top: 20px; background-color: #112; background-color: #0c2d41; font-family: Roboto, 'helvetica neue', Helvetica, Arial, sans-serif; }

.container { width: 800px; margin: auto; }

.row { position: relative; height: 30px; z-index: 1; clear: both; margin-bottom: 10px; text-align: center; }

.row--intro { padding-top: 20px; font-size: 16px; line-height: 28px; font-weight: 300; color: #fff; opacity: 0.4; }

.row--intro span { font-size: 11px; }

.skew-title { font-size: 25px; }

.skew-title span { position: relative; display: inline-block; width: 40px; height: 50px; margin: auto; z-index: 2; text-align: center; color: #fff; font-family: 'roboto condensed'; font-weight: 700; font-size: 35.714285714285715px; line-height: 50px; -webkit-transform: skewY(-15deg); transform: skewY(-15deg); -webkit-transform-origin: 0 100%; transform-origin: 0 100%; transition: all 0.2s; cursor: default; }

.skew-title span:after, .skew-title span:before { display: block; top: 0; left: 0; width: 40px; height: 50px; position: absolute; background: #185a81; content: ' '; z-index: -1; transition: all 0.2s; }

.skew-title span:before { background: rgba(0,0,0,0.1); -webkit-transform: skewY(15deg); transform: skewY(15deg); -webkit-transform-origin: 0 0; transform-origin: 0 0; }

.skew-title span:nth-child(even) { background-color: #144c6e; -webkit-transform: skewY(15deg); transform: skewY(15deg); -webkit-transform-origin: 100% 100%; transform-origin: 100% 100%; color: #d9d9d9; }

.skew-title span:nth-child(even):after { background-color: #144c6e; }

.skew-title span:nth-child(even):before { -webkit-transform-origin: 100% 0; transform-origin: 100% 0; -webkit-transform: skewY(-15deg); transform: skewY(-15deg); }

.skew-title span.flat { -webkit-transform: skewY(0); transform: skewY(0); color: #fff; }

.skew-title span.flat:before { -webkit-transform: skewY(0); transform: skewY(0); }

.skew-title span.flat:nth-child(even):after { background-color: #185a81; }

.skew-title span.alt:after { background-color: #b94a2c; }

.skew-title span.alt:nth-child(even):after { background-color: #9d3f25; }

.skew-title span.alt.flat:nth-child(even):after { background-color: #b94a2c; }

</style>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
        <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>

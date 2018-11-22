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

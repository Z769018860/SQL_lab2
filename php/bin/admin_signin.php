<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-管理员登录</title>
</head>

<body background="../image/123.jpg">
	<center>
<div class="container">

 <h1 class="row skew-title"> <span>欢</span><span>迎</span><span>访</span><span>问</span><span>果</span><span class="last">壳</span>   <span>1</span><span>2</span><span>3</span><span class="last">0</span>   <span class="alt">6</span><span class="alt">网</span><span class="alt">站</span><span class="alt last">!</span> </h1>

 <p class="row row--intro"></p>

</div>
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

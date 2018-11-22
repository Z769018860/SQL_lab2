<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-具体车次查询结果</title>
</head>

<body background="../image/123.jpg">
	<center>
<div class="container">

 <h1 class="row skew-title"> <span>欢</span><span>迎</span><span>访</span><span>问</span><span>果</span><span class="last">壳</span>   <span>1</span><span>2</span><span>3</span><span class="last">0</span>   <span class="alt">6</span><span class="alt">网</span><span class="alt">站</span><span class="alt last">!</span> </h1>

 <p class="row row--intro"></p>

</div>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>具体车次查询结果</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$trainid = $_POST["trainid"];
$train_date = $_POST["train_date"];

echo "<center>";
echo "<H3>尊敬的用户 $username ，您查询的车次 $trainid 信息如下：</H3>";

    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$sql = <<<EOF
	SELECT * FROM Train WHERE T_Name = '$trainid'
	ORDER BY T_StNum;
EOF;
$ret = pg_query($dbconn, $sql);
$row_num = pg_num_rows($ret);

//$row_num=1;
if ($row_num==0)
{
    echo "<b>";
	$back_href = "../serve/train_search.php";
    echo "<p>";
    echo "<br>";
    echo "<FONT color=#ff0000>";
	echo "无任何车次信息！" ;
    echo "</br>";
    echo "</p>";
    echo "<p>";
    echo "<br>";
    echo  "请<a href = $back_href>返回</a>重新输入查询";
    echo "</br>";
    echo "</p>";
    echo "</FONT>";
    echo "</b>";
}
else
{
$get_station_num = <<<EOF
				SELECT COUNT(T_StNum)
				FROM Train
				WHERE T_Name = '$trainid';
EOF;
$ret2 = pg_query($dbconn, $get_station_num);
$station_num = pg_fetch_row($ret2);
$sta_num = $station_num[0];

$get_first = <<<EOF
				SELECT T_Station
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_StNum = 1;
EOF;
$ret1 = pg_query($dbconn, $get_first);
$row = pg_fetch_row($ret1);
$first_name = $row[0];

$get_last = <<<EOF
				SELECT T_Station
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_StNum = $sta_num;
EOF;
$ret3 = pg_query($dbconn, $get_last);
$row = pg_fetch_row($ret3);
$last_name = $row[0];

function datadd($n, $date){
    return date("Y-m-d", strtotime($date ." +$n day"));
}

echo "<table border=\"4\"><tr>";
echo "<td>始发站</td>";
echo "<td>$first_name</td>";
echo "<td>终点站</td>";
echo "<td>$last_name</td>";
echo "</table>";

echo "<H4><p>列车 $trainid 的票价信息如下</p></H4>";
echo "<table border=\"4\"><tr>";
echo "<td>站名</td>" ;
echo "<td>站号</td>" ;
echo "<td>出发日期</td>";
echo "<td>到达日期</td>";
echo "<td>到达时间</td>" ;
echo "<td>出发时间</td>";
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";

while ($row = pg_fetch_row($ret)){
	////echo count($row);
	$num = count($row);
	echo "<tr>";
	for ( $i = 1; $i < 3; $i = $i + 1 ){
		echo "<td>" . "$row[$i]" . "</td>";
	}
		echo "<td>" . "$train_date" . "</td>";
//到达日期判断
	if (!$row[3])
		$to_date=$train_date;
	else if (($row[3]-$row[4])<0)
		$to_date=datadd(1,$train_date);
	else
		$to_date=$train_date;

		echo "<td>" . "$to_date" . "</td>";

	for ( $i = 3; $i < $num; $i = $i + 1 ){
		echo "<td>" . "$row[$i]" . "</td>";
	}
	echo "</tr>";
}

echo "</table>";


echo "<H4><p>$train_date ，列车 $trainid 的余票信息如下</p></H4>";
echo "<table border = \"4\">";
echo "<tr>";
echo "<td>站名</td>" ;
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";
echo "<tr>";


//获取余票信息
$all_type = array("YZ", "RZ", "YW1", "YW2", "YW3", "RW1", "RW2");

$get_train_station = <<<EOF
				SELECT T_Station
				From Train
				Where T_Name = '$trainid'
				ORDER BY T_StNum;
EOF;
$ret_t = pg_query($dbconn, $get_train_station);
while ($row = pg_fetch_row($ret_t)){
	echo "<td> $row[0] </td>";
$get_stnum=<<<EOF
				SELECT T_StNum
				FROM Train
				WHERE T_Name = '$trainid'
				and T_Station = '$row[0]';
EOF;
$ret_stnum = pg_query($dbconn, $get_stnum);
$row_stnum = pg_fetch_row($ret_stnum);
$to_stnum=$row_stnum[0]-1;
//echo $to_stnum;

for ($i = 0; $i <7; $i = $i + 1){
	for ($stnum=1;$stnum<=$to_stnum;$stnum=$stnum+1)
	{
$get_station=<<<EOF
			SELECT T_Station
			From Train
			WHERE T_Name='$trainid'
			and T_Stnum=$stnum;
EOF;
$ret_st=pg_query($dbconn,$get_station);
$row_st=pg_fetch_row($ret_st);
$station_temp=$row_st[0];
	$get_seat = <<<EOF
			SELECT Se_Num
			FROM Seat
			WHERE Se_Train = '$trainid'
			and Se_date = '$train_date'
			and Se_type = '$all_type[$i]'
			and Se_Station = '$station_temp';
EOF;
$ret_gs=pg_query($dbconn,$get_seat);
$row_gs_num=pg_num_rows($ret_gs);
if (!$row_gs_num)
{
$get_train_station = <<<EOF
				SELECT T_Station
				From Train
				Where T_Name = '$trainid'
				and T_StNum = $stnum;
EOF;
$ret_st = pg_query($dbconn, $get_train_station);
if (!$ret_st)
	echo "FAILED123!!!!";
$stnum_st=pg_fetch_row($ret_st);
	$ins_seat = <<<EOF
	INSERT INTO 
    	Seat(Se_Train,Se_Station,Se_Date,Se_Type,Se_Num)
	VALUES('$trainid', '$stnum_st[0]', '$train_date', '$all_type[$i]', 5);
EOF;
$ret_ins=pg_query($dbconn,$ins_seat);
if (!$ret_ins)
	echo "FAILED!!!!";
}

}
	$get_seat_num = <<<EOF
				SELECT MIN(Seat.Se_Num)
				FROM Train,Seat
				WHERE Train.T_Name = '$trainid'
    				AND Seat.Se_Train = Train.T_Name
    				AND Seat.Se_Date = '$train_date'
    				AND Seat.Se_Type = '$all_type[$i]'
    				AND Seat.Se_Station = Train.T_Station
    				AND Train.T_StNum BETWEEN 1 AND $to_stnum;
EOF;
$ret_s = pg_query($dbconn, $get_seat_num);
$row_s = pg_fetch_row($ret_s);
	$get_seat_money = <<<EOF
				SELECT *
				FROM Train
				WHERE T_Name = '$trainid'
				AND T_Station = '$row[0]';
EOF;
$ret_m = pg_query($dbconn, $get_seat_money);
$hastype = array();
$price = pg_fetch_row($ret_m);
$hastype = array($price[5], $price[6], $price[7],
 $price[8], $price[9], $price[10], $price[11]);
if (!$hastype[$i]||!$row_s[0])
	echo "<td> -- </td>";

else
	echo "<td><a href=\"../book/booking.php?date=$train_date&trainid=$trainid&date=$train_date&type=$all_type[$i]&price=$hastype[$i]&from_station=$first_name&to_station=$row[0]\">$row_s[0]</a></td>";
}
echo "</tr>";
}

echo "</table>";
    echo "<br>";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../serve/train_search.php'\">返回车次查询</a>
   </div> ";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../bin/user_signin.php'\">返回服务选择</a>
   </div> ";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../index.php'\">退出登录</a>
   </div> ";

echo "</center>";
pg_close($dbconn);

}


?>
   <style type="text/css">

* {
    margin: 10;
    padding: 10;
}

@font-face {
  font-family:League-Gothic;
  src:url("http://static.tumblr.com/unxjxmf/8oKm0yq2w/league-gothic.otf") format("opentype");
}
body{
    -webkit-transition: background-color 1s ease;
    -moz-transition: background-color 1s ease;
    -ms-transition: background-color 1s ease;
    -o-transition: background-color 1s ease;
    transition: background-color 1s ease;
}

#wrap      {width:80%;margin:auto;padding:20px 0px;}
/**
 * =======================================================
 * START CSS3 BUTTONS
 * To provide a convenient update, start a new button from top,
 * not from bottom
 * =======================================================
 */


/* 3D block button w/ hover transition */
/*     Would be much cleaner with a little .less */

a.three-dee-block {
    background: rgb(255,255,255); 
    background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(80%,rgba(215,215,215,0.2)), color-stop(100%,rgba(200,200,200,0.4))); 
    background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -o-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    box-shadow: 1px 1px 0 rgb(190,190,190),
        2px 2px 0 rgb(180,180,180),
        3px 3px 0 rgb(170,170,170),
        4px 4px 0 rgb(160,160,160),
        5px 5px 0 rgb(150,150,150),
        3px 6px 1px rgba(0,0,0,0.1),
        0 0 5px rgba(0,0,0,0.1),
        0 1px 3px rgba(0,0,0,0.3),
        1px 3px 5px rgba(0,0,0,0.2),
        2px 5px 10px rgba(0,0,0,0.25),
        5px 10px 10px rgba(0,0,0,0.2),
        10px 20px 20px rgba(0,0,0,0.15);
    color: rgba(70,70,70,0.6);
    cursor: pointer;
    display: block;
    font: normal 1em/1.1em arial, sans-serif;
    margin: 0 auto;
    padding: 0.3em 0.5em;
    -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -ms-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
    width: 8em;
}

a.three-dee-block:hover {
    background: rgb(235,235,235); 
    background: -moz-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,rgba(205,255,205,0.5)), color-stop(70%,rgba(255,255,255,0))), -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(80%,rgba(215,215,215,0.2)), color-stop(100%,rgba(200,200,200,0.4))); 
    background: -webkit-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -o-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -o-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    background: -ms-radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: radial-gradient(center, ellipse cover, rgba(205,255,205,0.5) 0%, rgba(255,255,255,0) 70%), linear-gradient(top, rgba(255,255,255,0) 0%, rgba(215,215,215,0.2) 80%, rgba(200,200,200,0.4) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    color: rgba(30,30,30,0.7);
    
    -moz-transform: translate(0px, -1px);
    -webkit-transform: translate(0px, -1px);
    -o-transform: translate(0px, -1px);
    -ms-transform: translate(0px, -1px);
    transform: translate(0px, -1px);
    
    -webkit-transition: all 300ms ease-out;
    -moz-transition: all 300ms ease-out;
    -ms-transition: all 300ms ease-out;
    -o-transition: all 300ms ease-out;
    transition: all 300ms ease-out;
}

a.three-dee-block:active {
    background: rgb(255,255,255); 
    background: -moz-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -webkit-gradient(linear, left bottom, left top, color-stop(0%,rgba(255,255,255,0)), color-stop(80%,rgba(200,200,200,0.3)), color-stop(100%,rgba(185,185,185,0.5))); 
    background: -webkit-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: -o-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    background: -ms-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top;
    background: linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(200,200,200,0.3) 80%, rgba(185,185,185,0.5) 100%), url(http://web.jstam.com/images/noise_pattern_with_crosslines.png) repeat left top; 
    box-shadow: 1px 1px 0 rgb(160,160,160),
        2px 2px 0 rgb(150,150,150),
        3px 3px 0 rgb(140,140,140),
        4px 4px 0 rgb(130,130,130),
        5px 5px 0 rgb(120,120,120),
        3px 6px 1px rgba(0,0,0,0.1),
        0 0 5px rgba(0,0,0,0.1),
        0 1px 6px rgba(0,0,0,0.3),
        1px 3px 7px rgba(0,0,0,0.2);
    color: rgba(60,60,60,0.7);
    
    -moz-transform: translate(0px, 1px);
    -webkit-transform: translate(0px, 1px);
    -o-transform: translate(0px, 1px);
    -ms-transform: translate(0px, 1px);
    transform: translate(0px, 1px);
    
    -webkit-transition: all 200ms ease-out;
    -moz-transition: all 200ms ease-out;
    -ms-transition: all 200ms ease-out;
    -o-transition: all 200ms ease-out;
    transition: all 200ms ease-out;
}


/**
 * =======================================================
 * END CSS3 BUTTONS
 * =======================================================
 */

body.light    {background-color:whitesmoke;}
body.light h1,
body.light h2 {text-shadow:0px 1px 4px rgba(0,0,0,0.2);}
a#toggler {
  position:fixed !important;
  position:absolute;
  bottom:10px;
  right:10px; 
  font:bold 11px Arial;
  color:gold;    
}
   </style>

    <div>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
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
	    <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>

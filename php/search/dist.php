<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-两地间车次查询结果</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>两地间车次查询结果</h2></b></p></div>
<br>
<?php

session_start();
$username = $_SESSION["username"];
$from_city = $_POST["from_city"];
$to_city = $_POST["to_city"];
$from_date = $_POST["from_date"];
$from_time = $_POST["from_time"];

echo "<center>";
echo "<H3>尊敬的用户 $username ，您查询的相应车次余票信息如下：</H3>";
    $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";

$get_passby=<<<EOF
-- 换乘

-- 先搜过北京的列车
    WITH T1(T1_Name,T1_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$from_city'
    ),
-- 再搜过上海的列车
    T2(T2_Name,T2_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$to_city'
    ),
-- 搜北京->某地->上海的列车
    T_Nonstop(TN_Name) AS
    (
        SELECT T1.T1_Name
        FROM T1,T2
        WHERE T1.T1_Name = T2.T2_Name
            AND T1.T1_StNum < T2.T2_StNum
    ),
-- 搜满足出发时间的列车
    T_Nonstop2(TN2_Name) AS
    (
        SELECT T_Nonstop.TN_Name
        FROM T_Nonstop,Train,Station 
        WHERE Train.T_Name = T_Nonstop.TN_Name
            AND Train.T_Station = Station.St_Name
            AND Station.St_City = '$from_city'
            AND Train.T_ArrivalTime >= '$from_time'
    ),
-- 搜出所有票价（未做减法）
    T_Money(TM_Name,TM_Station,TM_YZ,TM_RZ,TM_YW1,TM_YW2,TM_YW3,TM_RW1,TM_RW2) AS
    (
        SELECT Train.T_Name,Train.T_Station,Train.T_YZMoney,Train.T_RZMoney,Train.T_YW1Money,Train.T_YW2Money,Train.T_YW3Money,Train.T_RW1Money,Train.T_RW2Money
        FROM T_Nonstop2,Train,Station 
        WHERE Train.T_Name = T_Nonstop2.TN2_Name
            AND (Station.St_City = '$from_city' 
                 OR Station.St_City = '$to_city')
            AND Station.St_Name = Train.T_Station
    ),
-- 做减法并获得每次列车各种座位的票价
    T_MinMoney(TMM_Name,TMM_YZ,TMM_RZ,TMM_YW1,TMM_YW2,TMM_YW3,TMM_RW1,TMM_RW2) AS
    (
        SELECT TM_Name,MAX(TM_YZ)-MIN(TM_YZ),MAX(TM_RZ)-MIN(TM_RZ),MAX(TM_YW1)-MIN(TM_YW1),MAX(TM_YW2)-MIN(TM_YW2),MAX(TM_YW3)-MIN(TM_YW3),MAX(TM_RW1)-MIN(TM_RW1),MAX(TM_RW2)-MIN(TM_RW2)
        FROM T_Money
        GROUP BY TM_Name
    )
-- 为了插入余票强行断WITH    
    SELECT *
    FROM  T_MinMoney;
EOF;
$ret=pg_query($dbconn,$get_passby);
$row_num = pg_num_rows($ret);
//$row_num=1;
if (!$row_num)
{
    echo "<b>";
	$back_href = "../serve/dist_search.php";
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
echo "<FONT color=#ff0000>";
echo "<h4>直达车次信息（按票价从小到大排序取前10）</h4>";
echo "</FONT>";
echo "<table border=\"4\"><tr>";
echo "<td>车次</td>" ;
/*
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达日期</td>";
echo "<td>到达时间</td>";*/
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";

for ($x = 0; $x < min($row_num, 10); $x++){
    $a_row = pg_fetch_row($ret);
    echo "<tr>";
    for ($y = 0; $y < 8; $y++){
        echo "<td>$a_row[$y]</td>";
    }
    echo "</tr>";
}
echo "</table>";
    echo "<br>";
echo "<FONT color=#ff0000>";
echo "<h4>换乘一次车次信息（按票价从小到大排序取前10）</h4>";
echo "</FONT>";
echo "<table border=\"4\"><tr>";
echo "<td>车次</td>" ;
/*
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达日期</td>";
echo "<td>到达时间</td>";*/
echo "<td>硬座</td>" ;
echo "<td>软座</td>" ; 
echo "<td>硬卧上</td>";
echo "<td>硬卧中</td>" ;
echo "<td>硬卧下</td>" ;
echo "<td>软卧上</td>" ;
echo "<td>软卧下</td>";
echo "</tr>";

for ($x = 0; $x < min($row_num, 10); $x++){
    $a_row = pg_fetch_row($ret);
    echo "<tr>";
    for ($y = 0; $y < 8; $y++){
        echo "<td>$a_row[$y]</td>";
    }
    echo "</tr>";
}
echo "</table>";
    echo "<br>";
	echo "<div><p>
             <a href = \"../serve/dist_search.php\"><input type=\"button\" value = \"返回车次查询\" onclick=\"location.href='./serve/dist_search.php'\"> </a></p></div>";
	echo "<div><p>
             <a href = \"../bin/user_signin.php\"><input type=\"button\" value = \"返回服务选择\" onclick=\"location.href='./serve/book.php'\"> </a></p></div>";
    echo "<div><p>
             <a href = \"../index.php\"><input type=\"button\" value = \"退出登录\" onclick=\"location.href=''\"></a> </p></div>";
echo "</center>";
pg_close($dbconn);

}


?>

    <div>
    <a href="../index.php"><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif" /></a>
    <p style="background:url('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1541069446753&di=de93c02b9660f67fa00bbfd2f950c0da&imgtype=0&src=http%3A%2F%2Fimage3.cnpp.cn%2Fupload%2Fimages%2F20170708%2F15472435643_210x210.gif') no-repeat;"></p>
    <b><MARQUEE onmouseover=this.stop() onmouseout=this.start() scrollAmount=10><FONT color=#0080ff>新用户现在注册绑定银行卡，将会获得满200减100特别优惠；老用户邀请新用户将会获得往返雁栖湖免费车票两张！！！机不可失，时不再来！</MARQUEE></b>
    </div>
	    <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>

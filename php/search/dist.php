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
-- 搜北京->上海的列车
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
            AND Train.T_StartTime > '$from_time'
    ),
-- 获得每次列车各种座位类型
    T_Type(TTP_Name,TTP_Type) AS
    (
        SELECT TN2_Name,CAST('YZ' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('RZ' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('YW1' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('YW2' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('YW3' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('RW1' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('RW2' AS se_type)
        FROM T_Nonstop2
    ),
    TS_Num1(TS_train,TS_fromNum) AS
    (
				SELECT Train.T_Name,Train.T_StNum
                From Train,T_Nonstop2,Station
                WHERE Train.T_Name = T_Nonstop2.TN2_Name
                AND Train.T_Station = Station.St_Name
                AND Station.St_City = '$from_city'
    ),
    TS_Num2(TS_train,TS_toNum) AS
    (
				SELECT Train.T_Name,Train.T_StNum
                From Train,T_Nonstop2,Station
                WHERE Train.T_Name = T_Nonstop2.TN2_Name
                AND Train.T_Station = Station.St_Name
                AND Station.St_City = '$to_city'
    )
    SELECT DISTINCT T_Type.*,TS_Num1.TS_fromNum,TS_Num2.TS_toNum
    FROM T_Type,TS_Num1,TS_Num2
    WHERE T_Type.TTP_Name = TS_Num1.TS_train
        AND T_Type.TTP_Name = TS_Num2.TS_train;
EOF;
$ret=pg_query($dbconn,$get_passby);
$row_num = pg_num_rows($ret);
$seat   = array("YZ"=>"硬座", "RZ"=>"软座", "YW1"=>"硬卧上", "YW2"=>"硬卧中", "YW3"=>"硬卧下", "RW1"=>"软卧上", "RW2"=>"软卧下");

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
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达时间</td>";
echo "<td>行程总时间（分钟）</td>";
echo "<td>座位类型</td>" ;
echo "<td>价格</td>" ;
echo "<td>余票</td>" ;

echo "</tr>";

while ($row=pg_fetch_row($ret))
{
$trainid=$row[0];
$type=$row[1];
$from_stnum=$row[2];
$to_stnum=$row[3];

	for ($stnum=$from_stnum;$stnum<$to_stnum;$stnum=$stnum+1)
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
			and Se_date = '$from_date'
			and Se_type = '$type'
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

	VALUES('$trainid', '$stnum_st[0]', '$from_date', '$type', 5);
EOF;
$ret_ins=pg_query($dbconn,$ins_seat);
if (!$ret_ins)
	echo "FAILED!!!!";
}

}
}

$get_train_ordered=<<<EOF

-- 先搜过北京的列车
    WITH T1(T1_Name,T1_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$from_city'
    ),
-- 再搜过常州的列车
    T2(T2_Name,T2_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$to_city'
    ),
-- 搜北京->常州的列车
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
            AND Train.T_StartTime > '$from_time'
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
-- 获得每次列车各种座位类型
    T_Type(TTP_Name,TTP_Type) AS
    (
        SELECT TN2_Name,CAST('YZ' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('RZ' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('YW1' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('YW2' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('YW3' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('RW1' AS se_type)
        FROM T_Nonstop2
        UNION
        SELECT TN2_Name,CAST('RW2' AS se_type)
        FROM T_Nonstop2
    ),
-- 做减法并获得每次列车各种座位的票价
    T_MinMoney(TMM_Name,TMM_Type,TMM_Money) AS
    (
        SELECT T_Type.TTP_Name,T_Type.TTP_Type,
            (CASE T_Type.TTP_Type
            WHEN 'YZ' THEN MAX(T_Money.TM_YZ)-MIN(T_Money.TM_YZ)
            WHEN 'RZ' THEN MAX(T_Money.TM_RZ)-MIN(T_Money.TM_RZ)
            WHEN 'YW1' THEN MAX(T_Money.TM_YW1)-MIN(T_Money.TM_YW1)
            WHEN 'YW2' THEN MAX(T_Money.TM_YW2)-MIN(T_Money.TM_YW2)
            WHEN 'YW3' THEN MAX(T_Money.TM_YW3)-MIN(T_Money.TM_YW3)
            WHEN 'RW1' THEN MAX(T_Money.TM_RW1)-MIN(T_Money.TM_RW1)
            WHEN 'RW1' THEN MAX(T_Money.TM_RW2)-MIN(T_Money.TM_RW2)
            ELSE null
            END
            )TMM_Money
        FROM T_Money,T_Type 
        GROUP BY T_Type.TTP_Name,T_Type.TTP_Type
    ),
-- 开始算余票    
    TS_Num1(TS_train,TS_Station,TS_fromNum) AS
    (
				SELECT Train.T_Name,Train.T_Station,Train.T_StNum
                From Train,T_Nonstop2,Station
                WHERE Train.T_Name = T_Nonstop2.TN2_Name
                AND Train.T_Station = Station.St_Name
                AND Station.St_City = '$from_city'
    ),
    TS_Num2(TS_train,TS_Station,TS_toNum) AS
    (
				SELECT Train.T_Name,Train.T_Station,Train.T_StNum
                From Train,T_Nonstop2,Station
                WHERE Train.T_Name = T_Nonstop2.TN2_Name
                AND Train.T_Station = Station.St_Name
                AND Station.St_City = '$to_city'
    ),
-- 得到每次列车的座位类型及其余票
    TS_Seat(TS_Train,TS_Type,TS_Num) AS
    (
				SELECT T_Nonstop2.TN2_Name,Seat.Se_Type,MIN(Seat.Se_Num)
				FROM Train,Seat,TS_Num1,TS_Num2,T_Nonstop2
				WHERE Train.T_Name = T_Nonstop2.TN2_Name
    				AND Seat.Se_Train = Train.T_Name
    				AND Seat.Se_Date = '$from_date'
    				AND Seat.Se_Station = Train.T_Station
    				AND TS_Num1.TS_fromNum < Train.T_StNum
                    AND Train.T_StNum > TS_Num2.TS_toNum-1
                GROUP BY T_Nonstop2.TN2_Name,Seat.Se_Type
    ),
-- 得到每次列车**有余票**的座位类型、价格及其余票数
    TS_leftseat(TSL_Train,TSL_Type,TSL_Money,TSL_Num) AS
    (
				SELECT TS_Seat.TS_Train,TS_Seat.TS_Type,T_MinMoney.TMM_Money,TS_Seat.TS_Num
				FROM TS_Seat,T_MinMoney
				WHERE TS_Seat.TS_Num <> 0
                    AND T_MinMoney.TMM_Name = TS_Seat.TS_Train
                    AND T_MinMoney.TMM_Type = TS_Seat.TS_Type
    ),
-- 获得每次列车的最低票价所对应的座位类型、价格及其余票数
    T_MinMoney2(TMM2_Name,TMM2_Type,TMM2_Money,TMM2_Num) AS
    (
        SELECT TSL_Train,TSL_Type,MIN(TSL_Money),TSL_Num
        FROM TS_leftseat
        GROUP BY TSL_Train,TSL_Type,TSL_Num
    ),
-- 获得出发信息
    T11(T11_Name,T11_St,T11_Time) AS
    (
        SELECT TS_Num1.TS_train,TS_Num1.TS_Station,Train.T_StartTime
        FROM TS_Num1,Train
        WHERE TS_Num1.TS_train = Train.T_Name
            AND TS_Num1.TS_Station = Train.T_Station
    ),
--获得到达信息
    T12(T12_Name,T12_St,T12_Time) AS
    (
        SELECT TS_Num2.TS_train,TS_Num2.TS_Station,Train.T_StartTime
        FROM TS_Num2,Train
        WHERE TS_Num2.TS_train = Train.T_Name
            AND TS_Num2.TS_Station = Train.T_Station
    ),
-- 计算历时
    TTime(TT_Name,AllTime) AS 
    (
        SELECT  T11.T11_Name,
        (CASE 
            WHEN DATE_PART('hour', T12.T12_Time::time - T11.T11_Time::time) * 60 + DATE_PART('minute', T12.T12_Time::time - T11.T11_Time::time) > 0 
                THEN DATE_PART('hour', T12.T12_Time::time - T11.T11_Time::time) * 60 + DATE_PART('minute', T12.T12_Time::time - T11.T11_Time::time)
            ELSE DATE_PART('hour', '24:00'::time - T11.T11_Time::time) * 60 + DATE_PART('minute', '24:00'::time - T11.T11_Time::time) + 
                 DATE_PART('hour', T12.T12_Time::time - '00:00'::time) * 60 + DATE_PART('minute', T12.T12_Time::time - '00:00'::time)
            END
            )AllTime 
        FROM T11,T12
        WHERE T11.T11_Name = T12.T12_Name
    )
-- 按照先票价、再行程总时间、最后起始时间排序
    SELECT DISTINCT TMM2_Name,T11_St,T11_Time,T12_St,T12_Time,TTime.AllTime,TMM2_Type,TMM2_Money,TMM2_Num
    FROM T_MinMoney2,T11,T12,TTime
    WHERE TMM2_Money <> 0
        AND T_MinMoney2.TMM2_Name = T11.T11_Name
        AND T_MinMoney2.TMM2_Name = T12.T12_Name
        AND T_MinMoney2.TMM2_Name = TTime.TT_Name
    ORDER BY T_MinMoney2.TMM2_Money,TTime.AllTime,T11.T11_Time;
EOF;
$ret_o=pg_query($dbconn,$get_train_ordered);
if (!$ret_o)
	echo "ERROR!!!!!!!!";
else
{
$line=0;
while ($row=pg_fetch_row($ret_o))
{
	echo "<tr>";
$line++;
if ($line>10)
	break;
$trainid=$row[0];
$from_station=$row[1];
$go_time=$row[2];
$to_station=$row[3];
$got_time=$row[4];
$during_time=$row[5];
$type=$row[6];
$price=$row[7]+5;
$leftnum=$row[8];

	echo "<td>$row[0]</td>";
	echo "<td>$from_station</td>";
	echo "<td>$from_date</td>";
	echo "<td>$go_time</td>";
	echo "<td>$to_station</td>";
	echo "<td>$got_time</td>";
	echo "<td><center>$during_time</center></td>";
	echo "<td><center>$seat[$type]</center></td>";
	echo "<td>$row[7]</td>";
	echo "<td><a href=\"../book/booking.php?date=$from_date&trainid=$trainid&type=$type&price=$price&from_station=$from_station&to_station=$to_station\">$leftnum</a></td>";
	
echo "</tr>";
}
}
echo "</table>";

    echo "<br>";
echo "<FONT color=#ff0000>";
echo "<h4>换乘一次车次信息（两表对应换乘）</h4>";
echo "</FONT>";
echo "<table border=\"4\"><tr>";
echo "<td>车次</td>" ;
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达时间</td>";
echo "<td>行程总时间（分钟）</td>";
echo "<td>座位类型</td>" ;
echo "<td>价格</td>" ;
echo "<td>余票</td>" ;
echo "<td>车次</td>" ;
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达时间</td>";
echo "<td>行程总时间（分钟）</td>";
echo "<td>座位类型</td>" ;
echo "<td>价格</td>" ;
echo "<td>余票</td>" ;
echo "</tr>";

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

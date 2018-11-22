<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-两地间车次查询结果</title>
</head>

<body background="../image/123.jpg">
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

function datadd($n, $date){
    return date("Y-m-d", strtotime($date ." +$n day"));
}


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
echo "<td>到达日期</td>" ;
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

	if (($got_time-$go_time)<0)
		$to_date=datadd(1,$from_date);
	else
		$to_date=$from_date;

	echo "<td>$row[0]</td>";
	echo "<td>$from_station</td>";
	echo "<td>$from_date</td>";
	echo "<td>$go_time</td>";
	echo "<td>$to_station</td>";
	echo "<td>$to_date</td>";
	echo "<td>$got_time</td>";
	echo "<td><center>$during_time</center></td>";
	echo "<td><center>$seat[$type]</center></td>";
	echo "<td>$row[7]</td>";
	echo "<td><a href=\"../book/booking.php?date=$from_date&trainid=$trainid&type=$type&price=$price&from_station=$from_station&to_station=$to_station\" target=\"_blank\">$leftnum</a></td>";
	
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
echo "<td>到达日期</td>";
echo "<td>到达时间</td>";
echo "<td>座位类型</td>" ;
echo "<td>价格</td>" ;
echo "<td>余票</td>" ;
echo "<td>车次</td>" ;
echo "<td>出发站</td>" ;
echo "<td>出发日期</td>" ;
echo "<td>出发时间</td>" ;
echo "<td>到达站</td>" ;
echo "<td>到达日期</td>";
echo "<td>到达时间</td>";
echo "<td>座位类型</td>" ;
echo "<td>价格</td>" ;
echo "<td>余票</td>" ;
echo "<td>行程总时间（分钟）</td>";
echo "</tr>";


$get_info=<<<EOF

-- 输入出发地城市名、到达地城市名、出发日期和出发时间,查询两地之间换乘一次的列车和余票信息。

-- 查询两地之间换乘一次的列车和余票信息的SQL语句如下，其中'北京'、'常州'、'2018-11-20'、'00:00'是可改变的参数。


-- 先搜过北京的列车
    WITH T0(T0_Name,T0_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$from_city'
    ),
-- 剔除过北京不符合出发时间要求的列车
    T1(T1_Name,T1_StNum) AS
    (
        SELECT T0.T0_Name,T0.T0_StNum
        FROM T0,Train,Station 
        WHERE Train.T_Name = T0.T0_Name
            AND Train.T_Station = Station.St_Name
            AND Station.St_City = '$from_city'
            AND Train.T_StartTime > '$from_time'
    ),
-- 再搜过常州的列车
    T2(T2_Name,T2_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '常州'
    ),
-- 搜过北京和过常州的列车
    T3(T3_Name,T3_StNum) AS
    (
        SELECT T1.*
        FROM T1
        UNION
        SELECT T2.*
        FROM T2
    ),
-- 列出筛选后的过北京的列车、站名及站号
    S1(Name1,St1,StNum1,Time1) AS
    (
        SELECT T3.T3_Name,Train.T_Station,T1.T1_StNum,Train.T_StartTime
        FROM T1,T3,Train
        WHERE T1.T1_Name = T3.T3_Name
            AND Train.T_Name = T3.T3_Name
            AND Train.T_StNum = T1.T1_StNum
    ),
-- 列出筛选后的过常州的列车、站名及站号、时间
    S2(Name2,St2,StNum2,Time2) AS
    (
        SELECT T3.T3_Name,Train.T_Station,T2.T2_StNum,Train.T_ArrivalTime
        FROM T2,T3,Train
        WHERE T2.T2_Name = T3.T3_Name
            AND Train.T_Name = T3.T3_Name
            AND Train.T_StNum = T2.T2_StNum
    ),
-- 搜北京->常州存在换乘站的列车及其换乘站
    -- 北京->终点站的所有
    TEMP1(Name1,St0,St1,StNum1,City1,Time1) AS
    (
        SELECT Train.T_Name,S1.St1,Train.T_Station,Train.T_StNum,Station.St_City,Train.T_ArrivalTime
        FROM Train,S1,Station
        WHERE Train.T_Name = S1.Name1
            AND Train.T_StNum > S1.StNum1
            AND Station.St_Name = Train.T_Station
            AND Station.St_City != '$from_city'
    ),
    -- 始发站->常州的所有
    TEMP2(Name2,St0,St2,StNum2,City2,Time2) AS
    (
        SELECT Train.T_Name,S2.St2,Train.T_Station,Train.T_StNum,Station.St_City,Train.T_ArrivalTime
        FROM Train,S2,Station
        WHERE Train.T_Name = S2.Name2
            AND Train.T_StNum < S2.StNum2
            AND Station.St_Name = Train.T_Station
            AND Train.T_StNum > 1
            AND Station.St_City != '$to_city' 
    ),
    -- 所有同地换乘站及其换乘时间
    T4(Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime) AS 
    (
        SELECT TEMP1.Name1,TEMP1.St0,TEMP1.St1,TEMP1.Time1,TEMP2.Name2,TEMP2.St0,TEMP2.St2,TEMP2.Time2,
        (CASE 
            WHEN DATE_PART('hour', TEMP2.Time2::time - TEMP1.Time1::time) * 60 + DATE_PART('minute', TEMP2.Time2::time - TEMP1.Time1::time) > 0 
                THEN DATE_PART('hour', TEMP2.Time2::time - TEMP1.Time1::time) * 60 + DATE_PART('minute', TEMP2.Time2::time - TEMP1.Time1::time)
            ELSE DATE_PART('hour', '24:00'::time - TEMP1.Time1::time) * 60 + DATE_PART('minute', '24:00'::time - TEMP1.Time1::time) + 
                 DATE_PART('hour', TEMP2.Time2::time - '00:00'::time) * 60 + DATE_PART('minute', TEMP2.Time2::time - '00:00'::time)
            END
            )AllTime
        FROM TEMP1,TEMP2
        WHERE TEMP1.City1 = TEMP2.City2
        AND TEMP1.Name1 != TEMP2.Name2
    ),
-- 计算第一段旅程历时
    TTime1(TT_Name,TT_St,AllTime) AS 
    (
        SELECT DISTINCT T4.Name1,T4.St1,
        (CASE 
            WHEN DATE_PART('hour', T4.Time1::time - S1.Time1::time) * 60 + DATE_PART('minute', T4.Time1::time - S1.Time1::time) > 0 
                THEN DATE_PART('hour', T4.Time1::time - S1.Time1::time) * 60 + DATE_PART('minute', T4.Time1::time - S1.Time1::time)
            ELSE DATE_PART('hour', '24:00'::time - S1.Time1::time) * 60 + DATE_PART('minute', '24:00'::time - S1.Time1::time) + 
                 DATE_PART('hour', T4.Time1::time - '00:00'::time) * 60 + DATE_PART('minute', T4.Time1::time - '00:00'::time)
            END
            )AllTime 
        FROM S1,T4
        WHERE S1.Name1 = T4.Name1
    ),
-- 计算第二段旅程历时
    TTime2(TT_Name,TT_St,AllTime) AS 
    (
        SELECT  T4.Name2,T4.St2,
        (CASE 
            WHEN DATE_PART('hour', S2.Time2::time - T4.Time2::time) * 60 + DATE_PART('minute', S2.Time2::time - T4.Time2::time) > 0 
                THEN DATE_PART('hour', S2.Time2::time - T4.Time2::time) * 60 + DATE_PART('minute', S2.Time2::time - T4.Time2::time)
            ELSE DATE_PART('hour', '24:00'::time - T4.Time2::time) * 60 + DATE_PART('minute', '24:00'::time - T4.Time2::time) + 
                 DATE_PART('hour', S2.Time2::time - '00:00'::time) * 60 + DATE_PART('minute', S2.Time2::time - '00:00'::time)
            END
            )AllTime
        FROM S2,T4
        WHERE S2.Name2 = T4.Name2
    ),
-- 找出符合换乘时间要求的路线
    T5(Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime) AS
    (
        SELECT Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime
        FROM T4
        WHERE (St1 = St2 AND 60 <= AllTime AND AllTime <= 240)
            OR (St1 != St2 AND 120 <= AllTime AND AllTime <= 240)
    ),
-- 计算第一段旅程票价
    -- 搜出所有票价（未做减法）
    T_Money1(Name1,St1,St2,YZ,RZ,YW1,YW2,YW3,RW1,RW2) AS
    (
        SELECT T5.Name1,T5.St01,T5.St1,Train.T_YZMoney,Train.T_RZMoney,Train.T_YW1Money,Train.T_YW2Money,Train.T_YW3Money,Train.T_RW1Money,Train.T_RW2Money
        FROM Train,T5
        WHERE Train.T_Name = T5.Name1
            AND (Train.T_Station = T5.St01 OR Train.T_Station = T5.St1)
    ),
    -- 获得每次列车各种座位类型,做减法并获得每次列车各种座位的票价
    T_Type1(Name1,St1,St2,Type1,Money1) AS
    (
        SELECT Name1,St1,St2,CAST('YZ' AS se_type),MAX(T_Money1.YZ)-MIN(T_Money1.YZ)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('RZ' AS se_type),MAX(T_Money1.RZ)-MIN(T_Money1.RZ)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('YW1' AS se_type),MAX(T_Money1.YW1)-MIN(T_Money1.YW1)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('YW2' AS se_type),MAX(T_Money1.YW2)-MIN(T_Money1.YW2)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('YW3' AS se_type),MAX(T_Money1.YW3)-MIN(T_Money1.YW3)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('RW1' AS se_type),MAX(T_Money1.RW1)-MIN(T_Money1.RW1)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('RW2' AS se_type),MAX(T_Money1.RW2)-MIN(T_Money1.RW2)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
    ),
    -- 获得每次列车的最低票价所对应的座位类型、价格及其余票数
    T_MinMoney21(Name1,St1,St2,Type1,Money1) AS
    (
        SELECT Name1,St1,St2,Type1,MIN(Money1)
        FROM T_Type1
        WHERE Money1 <> 0
        GROUP BY Name1,Type1,St1,St2
    ),
-- 计算第二段旅程票价
    -- 搜出所有票价（未做减法）
    T_Money2(Name2,St1,St2,YZ,RZ,YW1,YW2,YW3,RW1,RW2) AS
    (
        SELECT T5.Name2,T5.St02,T5.St2,Train.T_YZMoney,Train.T_RZMoney,Train.T_YW1Money,Train.T_YW2Money,Train.T_YW3Money,Train.T_RW1Money,Train.T_RW2Money
        FROM Train,T5
        WHERE Train.T_Name = T5.Name2
            AND (Train.T_Station = T5.St02 OR Train.T_Station = T5.St2)
    ),
    -- 获得每次列车各种座位类型,做减法并获得每次列车各种座位的票价
    T_Type2(Name2,St1,St2,Type2,Money2) AS
    (
        SELECT Name2,St1,St2,CAST('YZ' AS se_type),MAX(T_Money2.YZ)-MIN(T_Money2.YZ)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('RZ' AS se_type),MAX(T_Money2.RZ)-MIN(T_Money2.RZ)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('YW1' AS se_type),MAX(T_Money2.YW1)-MIN(T_Money2.YW1)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('YW2' AS se_type),MAX(T_Money2.YW2)-MIN(T_Money2.YW2)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('YW3' AS se_type),MAX(T_Money2.YW3)-MIN(T_Money2.YW3)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('RW1' AS se_type),MAX(T_Money2.RW1)-MIN(T_Money2.RW1)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('RW2' AS se_type),MAX(T_Money2.RW2)-MIN(T_Money2.RW2)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
    ),
    -- 获得每次列车的最低票价所对应的座位类型、价格及其余票数
    T_MinMoney22(Name2,St1,St2,Type2,Money2) AS
    (
        SELECT Name2,St1,St2,Type2,MIN(Money2)
        FROM T_Type2
        WHERE Money2 <> 0
        GROUP BY Name2,Type2,St1,St2
    ),
-- T5(Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime)    
-- 获得两次列车的最低票价所对应的座位类型、价格及其余票数，并将两最低价格相加
    T_MinMoneyFinal(Name1,St11,St12,Type1,Name2,St21,St22,Type2,MoneySum) AS
    (
        SELECT T_MinMoney21.Name1,T_MinMoney21.St1,T_MinMoney21.St2,T_MinMoney21.Type1,T_MinMoney22.Name2,T_MinMoney22.St1,T_MinMoney22.St2,T_MinMoney22.Type2,T_MinMoney21.Money1 + T_MinMoney22.Money2
        FROM T_MinMoney21,T_MinMoney22,T5
        WHERE T_MinMoney21.Name1 = T5.Name1
            AND T_MinMoney21.St1 = T5.St01
            AND T_MinMoney21.St2 = T5.St1
            AND T_MinMoney22.Name2 = T5.Name2
            AND T_MinMoney22.St1 = T5.St02
            AND T_MinMoney22.St2 = T5.St2
    )
    SELECT DISTINCT *
    FROM T_MinMoneyFinal
    ORDER BY MoneySum;
EOF;
$ret=pg_query($dbconn,$get_info);
if (!$ret)
	echo "AAAAAAAA!!!!";
$line=0;
while ($row=pg_fetch_row($ret))
{
$line++;
if ($line>200)
	break;
$trainid=$row[0];
//echo "$trainid";
$type=$row[3];
$from_st=$row[1];
//echo "$from_st";
$to_st=$row[2];
//echo "$to_st";

$get_stnum=<<<EOF
			SELECT T_Stnum
			From Train
			WHERE T_Name='$trainid'
			and T_Station='$from_st';
EOF;
$ret_st=pg_query($dbconn,$get_stnum);
$row_st=pg_fetch_row($ret_st);
$from_stnum=$row_st[0];

$get_stnum=<<<EOF
			SELECT T_Stnum
			From Train
			WHERE T_Name='$trainid'
			and T_Station='$to_st';
EOF;
$ret_st=pg_query($dbconn,$get_stnum);
$row_st=pg_fetch_row($ret_st);
$to_stnum=$row_st[0];


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
$trainid=$row[4];
$type=$row[7];
$from_st=$row[6];
$to_st=$row[5];

$get_stnum=<<<EOF
			SELECT T_Stnum
			From Train
			WHERE T_Name='$trainid'
			and T_Station='$from_st';
EOF;
$ret_st=pg_query($dbconn,$get_stnum);
$row_st=pg_fetch_row($ret_st);
$from_stnum=$row_st[0];

$get_stnum=<<<EOF
			SELECT T_Stnum
			From Train
			WHERE T_Name='$trainid'
			and T_Station='$to_st';
EOF;
$ret_st=pg_query($dbconn,$get_stnum);
$row_st=pg_fetch_row($ret_st);
$to_stnum=$row_st[0];


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

$get_order=<<<EOF

-- 先搜过北京的列车
    WITH T0(T0_Name,T0_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$from_city'
    ),
-- 剔除过北京不符合出发时间要求的列车
    T1(T1_Name,T1_StNum) AS
    (
        SELECT T0.T0_Name,T0.T0_StNum
        FROM T0,Train,Station 
        WHERE Train.T_Name = T0.T0_Name
            AND Train.T_Station = Station.St_Name
            AND Station.St_City = '$from_city'
            AND Train.T_StartTime > '$from_time'
    ),
-- 再搜过常州的列车
    T2(T2_Name,T2_StNum) AS
    (
        SELECT Train.T_Name,Train.T_StNum
        FROM Train,Station
        WHERE Train.T_Station = Station.St_Name
            AND St_City = '$to_city'
    ),
-- 搜过北京和过常州的列车
    T3(T3_Name,T3_StNum) AS
    (
        SELECT T1.*
        FROM T1
        UNION
        SELECT T2.*
        FROM T2
    ),
-- 列出筛选后的过北京的列车、站名及站号
    S1(Name1,St1,StNum1,Time1) AS
    (
        SELECT T3.T3_Name,Train.T_Station,T1.T1_StNum,Train.T_StartTime
        FROM T1,T3,Train
        WHERE T1.T1_Name = T3.T3_Name
            AND Train.T_Name = T3.T3_Name
            AND Train.T_StNum = T1.T1_StNum
    ),
-- 列出筛选后的过常州的列车、站名及站号、时间
    S2(Name2,St2,StNum2,Time2) AS
    (
        SELECT T3.T3_Name,Train.T_Station,T2.T2_StNum,Train.T_ArrivalTime
        FROM T2,T3,Train
        WHERE T2.T2_Name = T3.T3_Name
            AND Train.T_Name = T3.T3_Name
            AND Train.T_StNum = T2.T2_StNum
    ),
-- 搜北京->常州存在换乘站的列车及其换乘站
    -- 北京->终点站的所有
    TEMP1(Name1,St0,St1,StNum1,City1,Time1) AS
    (
        SELECT Train.T_Name,S1.St1,Train.T_Station,Train.T_StNum,Station.St_City,Train.T_StartTime
        FROM Train,S1,Station
        WHERE Train.T_Name = S1.Name1
            AND Train.T_StNum > S1.StNum1
            AND Station.St_Name = Train.T_Station
            AND Station.St_City != '$from_city'
    ),
    -- 始发站->常州的所有
    TEMP2(Name2,St0,St2,StNum2,City2,Time2) AS
    (
        SELECT Train.T_Name,S2.St2,Train.T_Station,Train.T_StNum,Station.St_City,Train.T_ArrivalTime
        FROM Train,S2,Station
        WHERE Train.T_Name = S2.Name2
            AND Train.T_StNum < S2.StNum2
            AND Station.St_Name = Train.T_Station
            AND Train.T_StNum > 1
            AND Station.St_City != '$to_city' 
    ),
    -- 所有同地换乘站及其换乘时间
    T4(Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime) AS 
    (
        SELECT TEMP1.Name1,TEMP1.St0,TEMP1.St1,TEMP1.Time1,TEMP2.Name2,TEMP2.St0,TEMP2.St2,TEMP2.Time2,
        (CASE 
            WHEN DATE_PART('hour', TEMP2.Time2::time - TEMP1.Time1::time) * 60 + DATE_PART('minute', TEMP2.Time2::time - TEMP1.Time1::time) > 0 
                THEN DATE_PART('hour', TEMP2.Time2::time - TEMP1.Time1::time) * 60 + DATE_PART('minute', TEMP2.Time2::time - TEMP1.Time1::time)
            ELSE DATE_PART('hour', '24:00'::time - TEMP1.Time1::time) * 60 + DATE_PART('minute', '24:00'::time - TEMP1.Time1::time) + 
                 DATE_PART('hour', TEMP2.Time2::time - '00:00'::time) * 60 + DATE_PART('minute', TEMP2.Time2::time - '00:00'::time)
            END
            )AllTime
        FROM TEMP1,TEMP2
        WHERE TEMP1.City1 = TEMP2.City2
        AND TEMP1.Name1 != TEMP2.Name2
    ),
-- 计算第一段旅程历时
    TTime1(TT_Name,St1,St2,AllTime) AS 
    (
        SELECT DISTINCT T4.Name1,T4.St01,T4.St1,
        (CASE 
            WHEN DATE_PART('hour', T4.Time1::time - S1.Time1::time) * 60 + DATE_PART('minute', T4.Time1::time - S1.Time1::time) > 0 
                THEN DATE_PART('hour', T4.Time1::time - S1.Time1::time) * 60 + DATE_PART('minute', T4.Time1::time - S1.Time1::time)
            ELSE DATE_PART('hour', '24:00'::time - S1.Time1::time) * 60 + DATE_PART('minute', '24:00'::time - S1.Time1::time) + 
                 DATE_PART('hour', T4.Time1::time - '00:00'::time) * 60 + DATE_PART('minute', T4.Time1::time - '00:00'::time)
            END
            )AllTime 
        FROM S1,T4
        WHERE S1.Name1 = T4.Name1
    ),
-- 计算第二段旅程历时
    TTime2(TT_Name,St1,St2,AllTime) AS 
    (
        SELECT  T4.Name2,T4.St02,T4.St2,
        (CASE 
            WHEN DATE_PART('hour', S2.Time2::time - T4.Time2::time) * 60 + DATE_PART('minute', S2.Time2::time - T4.Time2::time) > 0 
                THEN DATE_PART('hour', S2.Time2::time - T4.Time2::time) * 60 + DATE_PART('minute', S2.Time2::time - T4.Time2::time)
            ELSE DATE_PART('hour', '24:00'::time - T4.Time2::time) * 60 + DATE_PART('minute', '24:00'::time - T4.Time2::time) + 
                 DATE_PART('hour', S2.Time2::time - '00:00'::time) * 60 + DATE_PART('minute', S2.Time2::time - '00:00'::time)
            END
            )AllTime
        FROM S2,T4
        WHERE S2.Name2 = T4.Name2
    ),
-- 找出符合换乘时间要求的路线
    T5(Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime) AS
    (
        SELECT Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime
        FROM T4
        WHERE (St1 = St2 AND 60 <= AllTime AND AllTime <= 240)
            OR (St1 != St2 AND 120 <= AllTime AND AllTime <= 240)
        GROUP BY Name1,St01,St1,Time1,Name2,St02,St2,Time2,AllTime
    ),
-- 计算第一段旅程票价
    -- 搜出所有票价（未做减法）
    T_Money1(Name1,St1,St2,YZ,RZ,YW1,YW2,YW3,RW1,RW2) AS
    (
        SELECT T5.Name1,T5.St01,T5.St1,Train.T_YZMoney,Train.T_RZMoney,Train.T_YW1Money,Train.T_YW2Money,Train.T_YW3Money,Train.T_RW1Money,Train.T_RW2Money
        FROM Train,T5
        WHERE Train.T_Name = T5.Name1
            AND (Train.T_Station = T5.St01 OR Train.T_Station = T5.St1)
    ),
    -- 获得每次列车各种座位类型,做减法并获得每次列车各种座位的票价
    T_Type1(Name1,St1,St2,Type1,Money1) AS
    (
        SELECT Name1,St1,St2,CAST('YZ' AS se_type),MAX(T_Money1.YZ)-MIN(T_Money1.YZ)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('RZ' AS se_type),MAX(T_Money1.RZ)-MIN(T_Money1.RZ)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('YW1' AS se_type),MAX(T_Money1.YW1)-MIN(T_Money1.YW1)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('YW2' AS se_type),MAX(T_Money1.YW2)-MIN(T_Money1.YW2)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('YW3' AS se_type),MAX(T_Money1.YW3)-MIN(T_Money1.YW3)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('RW1' AS se_type),MAX(T_Money1.RW1)-MIN(T_Money1.RW1)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
        UNION
        SELECT Name1,St1,St2,CAST('RW2' AS se_type),MAX(T_Money1.RW2)-MIN(T_Money1.RW2)
        FROM T_Money1
        GROUP BY T_Money1.Name1,T_Money1.St1,T_Money1.St2
    ),
    -- 开始算余票
    TS_Num11(train,St1,St2,fromNum) AS
    (
				SELECT Train.T_Name,T5.St01,T5.St1,Train.T_StNum
                From Train,T5
                WHERE Train.T_Name = T5.Name1
                AND Train.T_Station = T5.St01
    ),
    TS_Num21(train,St1,St2,toNum) AS
    (
				SELECT Train.T_Name,T5.St01,T5.St1,Train.T_StNum
                From Train,T5
                WHERE Train.T_Name = T5.Name1
                AND Train.T_Station = T5.St1
    ),
    TS_Num1(train,St1,St2,fromNum,toNum) AS
    (
                SELECT TS_Num11.train,TS_Num11.St1,TS_Num11.St2,TS_Num11.fromNum,TS_Num21.toNum
                FROM TS_Num11,TS_Num21
                WHERE TS_Num11.train = TS_Num21.train
                    AND TS_Num21.St1 = TS_Num11.St1
                    AND TS_Num21.St2 = TS_Num11.St2
    ),
    -- 得到每次列车的座位类型及其余票
    TS_Seat1(Train1,St1,St2,Type1,Num1) AS
    (
				SELECT TS_Num1.train,TS_Num1.St1,TS_Num1.St2,Seat.Se_Type,MIN(Seat.Se_Num)
				FROM Train,Seat,TS_Num1
				WHERE Train.T_Name = TS_Num1.train
    				AND Seat.Se_Train = Train.T_Name
    				AND Seat.Se_Date = '$from_date'
    				AND Seat.Se_Station = Train.T_Station
    				AND TS_Num1.fromNum < Train.T_StNum
                    AND Train.T_StNum > TS_Num1.toNum-1
                GROUP BY TS_Num1.train,TS_Num1.St1,TS_Num1.St2,Seat.Se_Type
    ),
    -- 得到每次列车**有余票**的座位类型、价格及其余票数
    TS_leftseat1(Train1,St1,St2,Type1,Money1,Num1) AS
    (
				SELECT TS_Seat1.Train1,TS_Seat1.St1,TS_Seat1.St2,TS_Seat1.Type1,T_Type1.Money1,TS_Seat1.Num1
				FROM TS_Seat1,T_Type1
				WHERE TS_Seat1.Num1 <> 0
                    AND T_Type1.Money1 <> 0
                    AND T_Type1.Name1 = TS_Seat1.Train1
                    AND T_Type1.Type1 = TS_Seat1.Type1
    ),
    -- 获得每次列车的最低票价所对应的座位类型、价格及其余票数
    T_MinMoney21(Name1,St1,St2,Type1,Money1,Num1) AS
    (
        SELECT Train1,St1,St2,Type1,MIN(Money1),Num1
        FROM TS_leftseat1
        GROUP BY Train1,Type1,Num1,St1,St2
    ),
-- 计算第二段旅程票价
    -- 搜出所有票价（未做减法）
    T_Money2(Name2,St1,St2,YZ,RZ,YW1,YW2,YW3,RW1,RW2) AS
    (
        SELECT T5.Name2,T5.St02,T5.St2,Train.T_YZMoney,Train.T_RZMoney,Train.T_YW1Money,Train.T_YW2Money,Train.T_YW3Money,Train.T_RW1Money,Train.T_RW2Money
        FROM Train,T5
        WHERE Train.T_Name = T5.Name2
            AND (Train.T_Station = T5.St02 OR Train.T_Station = T5.St2)
    ),
    -- 获得每次列车各种座位类型,做减法并获得每次列车各种座位的票价
    T_Type2(Name2,St1,St2,Type2,Money2) AS
    (
        SELECT Name2,St1,St2,CAST('YZ' AS se_type),MAX(T_Money2.YZ)-MIN(T_Money2.YZ)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('RZ' AS se_type),MAX(T_Money2.RZ)-MIN(T_Money2.RZ)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('YW1' AS se_type),MAX(T_Money2.YW1)-MIN(T_Money2.YW1)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('YW2' AS se_type),MAX(T_Money2.YW2)-MIN(T_Money2.YW2)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('YW3' AS se_type),MAX(T_Money2.YW3)-MIN(T_Money2.YW3)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('RW1' AS se_type),MAX(T_Money2.RW1)-MIN(T_Money2.RW1)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
        UNION
        SELECT Name2,St1,St2,CAST('RW2' AS se_type),MAX(T_Money2.RW2)-MIN(T_Money2.RW2)
        FROM T_Money2
        GROUP BY T_Money2.Name2,T_Money2.St1,T_Money2.St2
    ),
    -- 开始算余票
    TS_Num12(train,St1,St2,fromNum) AS
    (
				SELECT Train.T_Name,T5.St02,T5.St2,Train.T_StNum
                From Train,T5
                WHERE Train.T_Name = T5.Name2
                AND Train.T_Station = T5.St2
    ),
    TS_Num22(train,St1,St2,toNum) AS
    (
				SELECT Train.T_Name,T5.St02,T5.St2,Train.T_StNum
                From Train,T5
                WHERE Train.T_Name = T5.Name2
                AND Train.T_Station = T5.St02
    ),
    TS_Num2(train,St1,St2,fromNum,toNum) AS
    (
                SELECT TS_Num12.train,TS_Num12.St1,TS_Num12.St2,TS_Num12.fromNum,TS_Num22.toNum
                FROM TS_Num12,TS_Num22
                WHERE TS_Num12.train = TS_Num22.train
                    AND TS_Num22.St1 = TS_Num12.St1
                    AND TS_Num22.St2 = TS_Num12.St2
    ),          
    -- 得到每次列车的座位类型及其余票
    TS_Seat2(Train2,St1,St2,Type2,Num2) AS
    (
				SELECT TS_Num2.train,TS_Num2.St1,TS_Num2.St2,Seat.Se_Type,MIN(Seat.Se_Num)
				FROM Train,Seat,TS_Num2,T5
				WHERE Train.T_Name = TS_Num2.train
    				AND Seat.Se_Train = Train.T_Name
    				AND Seat.Se_Date = '$from_date'
    				AND Seat.Se_Station = Train.T_Station
    				AND TS_Num2.fromNum < Train.T_StNum
                    AND Train.T_StNum > TS_Num2.toNum-1
                GROUP BY TS_Num2.train,TS_Num2.St1,TS_Num2.St2,Seat.Se_Type
    ),
    -- 得到每次列车**有余票**的座位类型、价格及其余票数
    TS_leftseat2(Train2,St1,St2,Type2,Money2,Num2) AS
    (
				SELECT TS_Seat2.Train2,TS_Seat2.St1,TS_Seat2.St2,TS_Seat2.Type2,T_Type2.Money2,TS_Seat2.Num2
				FROM TS_Seat2,T_Type2
				WHERE TS_Seat2.Num2 <> 0
                    AND T_Type2.Money2 <> 0 
                    AND T_Type2.Name2 = TS_Seat2.Train2
                    AND T_Type2.Type2 = TS_Seat2.Type2
    ),
    -- 获得每次列车的最低票价所对应的座位类型、价格及其余票数
    T_MinMoney22(Name2,St1,St2,Type2,Money2,Num2) AS
    (
        SELECT Train2,St1,St2,Type2,MIN(Money2),Num2
        FROM TS_leftseat2 
        GROUP BY Train2,Type2,Num2,St1,St2
    ),
-- 获得两次列车的最低票价所对应的座位类型、价格及其余票数，并将两最低价格相加(附加时间)
    T_MinMoneyFinal(Name1,St11,Time11,St12,T12,Type1,Money1,Num1,Name2,St21,Time21,St22,Time22,Type2,Money2,Num2,AllTime,MoneySum) AS
    (
        SELECT T_MinMoney21.Name1,T_MinMoney21.St1,S1.Time1,T_MinMoney21.St2,T5.Time1,T_MinMoney21.Type1,T_MinMoney21.Money1,T_MinMoney21.Num1,
               T_MinMoney22.Name2,T_MinMoney22.St1,S2.Time2,T_MinMoney22.St2,T5.Time2,T_MinMoney22.Type2,T_MinMoney22.Money2,T_MinMoney22.Num2,
                (CASE 
                    WHEN DATE_PART('hour', S2.Time2::time - S1.Time1::time) * 60 + DATE_PART('minute', S2.Time2::time - S1.Time1::time) > 0 
                    THEN DATE_PART('hour', S2.Time2::time - S1.Time1::time) * 60 + DATE_PART('minute', S2.Time2::time - S1.Time1::time)
                    ELSE DATE_PART('hour', '24:00'::time - S1.Time1::time) * 60 + DATE_PART('minute', '24:00'::time - S1.Time1::time) + 
                    DATE_PART('hour', S2.Time2::time - '00:00'::time) * 60 + DATE_PART('minute', S2.Time2::time - '00:00'::time)
                    END
                )AllTime,
                T_MinMoney21.Money1 + T_MinMoney22.Money2
        FROM T_MinMoney21,T_MinMoney22,T5,S1,S2
        WHERE T_MinMoney21.Name1 = T5.Name1
            AND T_MinMoney21.St1 = T5.St01
            AND T_MinMoney21.St2 = T5.St1
            AND T_MinMoney22.Name2 = T5.Name2
            AND T_MinMoney22.St1 = T5.St02
            AND T_MinMoney22.St2 = T5.St2
            AND S1.Name1 = T5.Name1
            AND S1.St1 = T5.St01
            AND S2.Name2 = T5.Name2
            AND S2.St2 = T5.St02
   )
    SELECT DISTINCT *
    FROM T_MinMoneyFinal
    ORDER BY MoneySum,AllTime,Time11;

EOF;
$ret=pg_query($dbconn,$get_order);
if (!$ret)
	echo "AAAAAAAAAAAAAAAAA!!!";
else
{
	$line=0;
	while ($row=pg_fetch_row($ret))
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
//$during_time=$row[5];
$type=$row[5];
$price=$row[6]+5;
$leftnum=$row[7];

	if (($got_time-$go_time)<0)
		$to_date=datadd(1,$from_date);
	else
		$to_date=$from_date;

	echo "<td>$row[0]</td>";
	echo "<td>$from_station</td>";
	echo "<td>$from_date</td>";
	echo "<td>$go_time</td>";
	echo "<td>$to_station</td>";
	echo "<td>$to_date</td>";
	echo "<td>$got_time</td>";
	//echo "<td><center>$during_time</center></td>";
	echo "<td><center>$seat[$type]</center></td>";
	echo "<td>$row[6]</td>";
	echo "<td><a href=\"../book/booking.php?date=$from_date&trainid=$trainid&type=$type&price=$price&from_station=$from_station&to_station=$to_station\" target=\"_blank\">$leftnum</a></td>";

$trainid=$row[8];
$from_station=$row[11];
$go_time=$row[12];
$to_station=$row[9];
$got_time=$row[10];
//$during_time=$row[5];
$type=$row[13];
$price=$row[14]+5;
$leftnum=$row[15];
$during_time=$row[16];

	echo "<td>$trainid</td>";
	echo "<td>$from_station</td>";
	echo "<td>$from_date</td>";
	echo "<td>$go_time</td>";
	echo "<td>$to_station</td>";
	echo "<td>$to_date</td>";
	echo "<td>$got_time</td>";
	//echo "<td><center>$during_time</center></td>";
	echo "<td><center>$seat[$type]</center></td>";
	echo "<td>$row[14]</td>";
	echo "<td><a href=\"../book/booking.php?date=$from_date&trainid=$trainid&type=$type&price=$price&from_station=$from_station&to_station=$to_station\">$leftnum</a></td>";
	echo "<td><center>$during_time</center></td>";

	
echo "</tr>";

}
}
echo "</table>";


    echo "<br>";
	echo "<div id=\"wrap\">
        <a class=\"three-dee-block\" onclick=\"location.href='../serve/dist_search.php'\">返回车次查询</a>
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
	    <br>
	    <p><FONT type="楷体" size=2>Copyright © 2018 UCAS My 12306. All Rights Reserved. deep dark fantasy · King 版权所有</FONT></p>
	</center>
</body>
</html>


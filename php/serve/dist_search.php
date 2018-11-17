<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306-两地间车次查询</title>
</head>

<body>
	<center>
	<p><H1 id="h1"> 欢迎访问果壳12306网站</H1></p>
            <a href="../index.php"><img src="../image/ad.png" /></a>
    <p style="background:url('../image/ad.png') no-repeat;"></p>
	<div><p> <b><H2>两地间车次查询</h2></b></p></div>
<br>
<?php
function datadd($n, $date){
    return date("Y-m-d", strtotime($date ." +$n day"));
}
?>
 <b>请输入您需要查询的起止信息</b>
	<form action="../search/dist.php" method="post">
    <div><p>出发站：<input type="text" name = "from_station" value="北京" required = "required"></p></div>
    <div><p>到达站：<input type="text" name = "to_station" value="常州" required = "required"></p></div>
　	<div><p>出发日期：<input type="date" name = "from_date"  value="<?php echo datadd(1,date("Y/m/d")); ?>"required = "required"></p></div>
	<div><p>出发时刻：  <input type="time" name = "from_time" value="00:00"></p></div>
			 <div><p><input type="submit" name = "查询" value="查询" ></p></div><br>
</form>

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

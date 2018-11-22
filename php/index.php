<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>果壳12306</title>
</head>

<body background="../image/123.jpg">

	<center>
	<p><h1> 欢迎访问果壳12306网站</h1></p>
        <a href="../index.php"><img src="../image/ad.png" /></a>

	<div><h3>请先注册或登录（或以游客身份浏览）</h3></div>

<br>
<br>
	<span>
			<div id="wrap">
        <a class="three-dee-block" onclick="location.href='./sign/sign_up.php'">注册</a>
   </div> 
			<div id="wrap">
        <a class="three-dee-block" onclick="location.href='./sign/sign_in.php'">登录</a>
   </div> 
<div id="wrap">
        <a class="three-dee-block" onclick="location.href='./sign/sign_random.php'">游客</a>
   </div> 
<div id="wrap">
        <a class="three-dee-block" onclick="location.href='./sign/sign_admin.php'">管理员</a>
   </div> 

	</span>
<br>
<br>
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

# 数据库系统Lab2-12306

标签（空格分隔）： PHP SQL 12306 closed

---

## 代码更新日志


----------


update-2018.11.17

连接psql成功，写入部分SQL语句，但是对db的操作失败……


update-2018.11.18

连入成功，写入成功！注册登录成功！


update-2018.11.19 5:00

除需求5外全部实现！余票功能顺利实现！继续肝需求5……

update-2018.11.19 10:00

修正了一些跳转bug、显示bug等等……

update-2018.11.19 23:00

修补了余票的bug，把余票信息插入放在查询中，完成需求5-1……

修复订票userid未获取bug，修饰排版……5-2待完成（我人工智能还没复习我要死了）

update-2018.11.21 00:00

修补了到达日期没写的问题……等5-2优化……今天看了哲哲的后现代美工设计网站，瞬间懒得美工了QAQ

update-2018.11.21 04:00

更新5-2的seat表插入操作……别问我为什么又没有睡觉……我想睡觉orz

update-2018.11.21 09:00

更新背景……更新按钮……修正链接问题……

update-2018.11.21 12:00

5-2pass！美工优化完成！背景图、标题、按钮美化完成！背景图的含义就是数据库打爆我的狗头！

## 文件架构
```
SQL_lab2
├─php
│  ├─bin
│  │   ├─admin_signin
│  │   ├─user_signin
│  │   ├─user_signup
│  │   └─user_signup_random
│  ├─book
│  │   ├─book_admin
│  │   ├─book_back
│  │   ├─book_cancel
│  │   ├─book_confirm
│  │   ├─book_info
│  │   └─booking
│  ├─data
│  │   ├─station_data
│  │   └─train_data
│  ├─image
│  │   ├─ad
│  │   ├─background
│  │   ├─background
│  │   └─index-03
│  ├─search
│  │   ├─book_searc
│  │   ├─train
│  │   └─dist
│  ├─search
│  │   ├─book
│  │   ├─train_search
│  │   └─dist_search
│  ├─ign
│  │   ├─sign_admin
│  │   ├─sign_in
│  │   ├─sign_random
│  │   └─sign_up
│  ├─db
│  ├─index
│  └─test
└─README

```

## 使用说明


----------


·环境：支持php和psql,装好驱动，通过localhost访问网页
·php与psql连接：

```php

   $connection_string = "host=localhost port=5432 dbname=lab2 user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo "<script>alert('哦豁，数据库连接成功！')</script>";
    
```

·psql建表语句
·见db文件，逐段复制即可
·启动环境webserv start
脚本如下：

```shell
#!/bin/bash

if [ "$1" != "" ]; then
   cmd="sudo service apache2 $1; sudo service postgresql $1"
   eval $cmd
else
   echo "No option was provided"
fi


```
·将所有php中的文件拷贝到www/html文件目录下
`最后在浏览器中输入localhost/index.php即可正常浏览
*ps：数据库连接成功会有弹窗提醒


## 具体功能


----------


1. 用户功能（注册、登录、游客）
2. 管理员功能（查看订单、用户）
3. 查询功能——包括两地间查询（含一次换乘）和具体车次查询
4. 订单功能——（包括余票连接预订和订单查看、订单取消功能）
.




<<<<<<< HEAD

=======
>>>>>>> 4465556709ec8bc63540fb72645e3a6b196bb678


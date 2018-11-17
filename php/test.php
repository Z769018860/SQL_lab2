<?php

    //其中参数的含义是
    //host=localhost，本地计算机，默认就是本地计算机
    //port=5432，默认端口号
    //dbname=mydb，指定要连接的数据库
    //user=dbuser，连接数据库的用户
    //password=dbpassword，连接数据库用户的密码

    $connection_string = "host=localhost port=5432 dbname=test user=root password=111111";

    $dbconn = pg_connect( $connection_string );

    if(! $dbconn )
    {
        exit('数据库连接失败！');
    }
    echo '数据库连接成功！';

    pg_close($dbconn);

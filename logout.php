<?php
    //记录用户退出的日志
    $date = date(DATE_RFC822);
    $daylog = "logs/".date('Y-m-d').".log"; 
    if (!file_exists($daylog))
    {
        $log = fopen($daylog, "w") or die("Unable to open file!");
        fwrite($log,
            "=================Date:$date=============\n");
        fwrite($log,"Create&Logout:--Date:$date--stuid:".
            "$username--username:$turename\n");
        fclose($log);
        chmod($log, 0666);
    }
    else
    {
        $log = fopen($daylog, "a") or die("Unable to open file!");
        fwrite($log,"Logout----Date:$date----stuid:".$_COOKIE['username']
            ."----username:".$_COOKIE['turename']."\n");
        fclose($log);
    }
    setcookie('username', NULL);
    setcookie('turename', NULL);
    echo "<meta http-equiv='refresh' content='0;index.html'/>";
?>

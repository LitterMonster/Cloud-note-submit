<?php
//这里的username就是学号sno
$username = $_POST['username'];
$password = md5($_POST['password']);

//连接数据库
$con = mysql_connect("localhost", "root", "12345678") 
    or die("Could not connect!");
mysql_select_db("cloud_note_db", $con);

mysql_query('set names utf8');
$result = mysql_query("SELECT * FROM user WHERE sno = '$username'");

$statue = 0;
while($row = mysql_fetch_array($result))
{
    if($row['password'] == $password)
    {
        $turename = $row['turename'];
        $statue = 1;
        break;
    }
}
mysql_close($con);

if ($statue == 1)
{
    setcookie('username', $username, time() + 3600);
    setcookie('turename', $turename, time() + 3600);
    echo "<meta http-equiv='refresh' content='0;share.php'/>";
}
else {
    echo "<meta charset='utf-8'>";
    echo "<script>alert('用户名或密码错误！')</script>";
    echo "<meta http-equiv='refresh' content='0;index.html'/>";
}
?>

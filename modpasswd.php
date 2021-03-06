<?php
if(empty($_COOKIE['username']))
{
    echo "<meta charset='utf-8'>";
    echo "<script>alert('请先登陆！')</script>";
    echo "<meta http-equiv='refresh' content='0;index.html'/>";
    die;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen">
    <link rel="stylesheet" type="text/css" href="stylesheets/pygment_trac.css" media="screen">
    <link rel="stylesheet" type="text/css" href="stylesheets/print.css" media="print">

    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

      <title>云笔记-修改密码</title>
  </head>

  <body>
    <header>
      <div class="inner">
        <h1>云笔记</h1>
        <h2>Let's note any time.</h2>
    <a href="#" class="button"><small>当前用户:</small><?=$_COOKIE['turename']?></a>
      </div>
    </header>

    <div class="menu-wrap">
      <nav class="menu">
        <ul class="clearfix">
          <li>
            <a href="share.php">分享中心<span class="arrow">&#9660;</span></a>
            <ul class="sub-menu">
              <li> <a href="share_mng.php">分享管理</a></li>
            </ul>
          </li>
              <li><a href="home.php">我的笔记</a></li>
              <li><a href="write.php">新建笔记</a></li>
              <li><a href="search.php">搜索笔记</a></li>
          <li>
            <a href="#">设置<span class="arrow">&#9660;</span></a>
            <ul class="sub-menu">
              <li> <a href="modpasswd.php">修改密码</a></li>
              <li> <a href="about.php">关于网站</a></li>
              <li> <a href="logout.php">退出系统</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>

    <div id="content-wrapper">
      <div class="inner clearfix">
        <section id="main-content">

<?php
if (empty($_POST)) {
    echo "<h1>修改密码</h1>";
?>
  <form method='post' action='modpasswd.php'>
  <table  border = '1'>
<tr><td>原密码:</td><td><input type="password" name="passwd_old"
placeholder="请输入原密码" align="left" size='60'/></td></tr>
<tr><td>新密码:</td><td><input type="password" name="passwd_new1"
placeholder="请输入新密码" align="left" size='60'/></td></tr>
<tr><td>确认密码:</td><td><input type="password" name="passwd_new2"
placeholder="请确认新密码" align="left" size='60'/></td></tr>
<tr><td colspan="2"><input type="submit" value="确认修改" onclick="
if(passwd_old.value.length==0){alert('旧密码不能为空!');return false;}
else if(passwd_new1.value.length==0 || passwd_new2.value.length == 0){
    alert('新密码不能为空!');return false;}else if
        (passwd_new1.value!=passwd_new2.value){alert
        ('两次密码不一样，请重新输入!');return false;}
else{return true;}"/></td></tr>
</table>
  </form>
<hr/>
<?php
} else {
    $sno = $_COOKIE['username'];
    $passwd_old = md5($_POST['passwd_old']);
    $passwd_new1 = md5($_POST['passwd_new1']);

    //连接数据库
    $con = mysql_connect("localhost", "root", "12345678") 
        or die("Could not connect!");
    mysql_select_db("cloud_note_db", $con);

    mysql_query('set names utf8');
    $result = mysql_query("SELECT * FROM user WHERE sno = '$sno'");

    $statue = 0;
    while($row = mysql_fetch_array($result))
    {
        if($row['password'] == $passwd_old)
        {
            $statue = 1;
            break;
        }
    }

    if($statue == 0)
    {
        echo "<script>alert('旧密码错误,禁止修改密码！')</script>";
        echo "<meta http-equiv='refresh' content='0;modpasswd.php'/>";
        die;
    } else {
        mysql_query("UPDATE user SET password = '$passwd_new1' 
            WHERE sno = '$sno'");
        echo "<script>alert('密码修改成功!')</script>";
        echo "<meta http-equiv='refresh' content='0;modpasswd.php'/>";
    }
    mysql_close($con);
}
?>
        </section>

        <aside id="sidebar">
          <a href="home.php" class="button">
            <small>View all notes</small>
查看笔记
          </a>

        <aside id="sidebar">
          <a href="write.php" class="button">
            <small>Create new note</small>
新建笔记
          </a>
        <aside id="sidebar">
          <a href="search.php" class="button">
            <small>Search notes</small>
搜索笔记
          </a>

        </aside>
      </div>
    </div>

  </body>
</html>

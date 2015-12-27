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

      <title>云笔记-关于</title>
  </head>

  <body>
    <header>
      <div class="inner">
        <h1>云笔记</h1>
        <h2>Let's note anywhere.</h2>
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

	  <h1>关于网站</h1>
    <p><h2>云笔记v0.01</h2></p>

	  <h1>关于作者</h1>
    <p><h2>张涛 13 软工A2 XML大作业</h2></p>

	  <h1>项目源码</h1>
    <p><a href="https://github.com/LitterMonster/Cloud-note-submit">
<h2>点击这里</h2></a></p>

	</section>
	<aside id="sidebar">
          <a href="index.php" class="button">
            <small>View all notes</small>
            查看笔记
          </a>
          <a href="write.php" class="button">
            <small>Create new note</small>
            新建笔记
          </a>
          <a href="search.php" class="button">
            <small>Search note</small>
            搜索笔记
          </a>

        </aside>
      </div>
    </div>

  </body>
 </html>

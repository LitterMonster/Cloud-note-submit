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

      <title>云笔记-新建笔记</title>
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
if( $_GET['mode'] == "edit"){
    echo "<h1>编辑笔记</h1>";
    $doc = new DOMDocument();
    $filename = "data/".$_COOKIE['username'].".xml";

    if( $doc->load($filename) ){
        $editMessage = $doc->getElementsByTagName('message')
            ->item((int)$_GET['a']);
        $name = $editMessage->getElementsByTagName('name')
            ->item(0)->nodeValue;
        $content = $editMessage->getElementsByTagName('content')
            ->item(0)->nodeValue;
        $picture = $editMessage->getElementsByTagName('picture')
            ->item(0)->nodeValue;
    }
}
else echo "<h1>新建笔记</h1>";
?>
      <br/>
      <div>
      <form action = "process.php?old_pic=<?=$picture?>&a=<?=$_GET['a']?>" method = "post" enctype="multipart/form-data">
            <strong>标题：</strong><br/><input type = "text" name = "name1"
 value = "<?php echo $name; ?>" size='70%'/><br/>
            <strong>内容：</strong><br/><textarea name = "content" style
 = "width: 580px; height: 200px;"><?php echo $content; ?></textarea><br/>
            <strong>图片:</strong></br>
<?php
if (!empty($picture) && $picture != "no_pic.jpg")
    echo "<a href='upload_file/".$_COOKIE['username']."/$picture'><img src='upload_file/".$_COOKIE['username']."/$picture' width='805px'/></a>"
?>
<input type="file" name="file"/>
<input type="reset" name="res" value="重置"/></br>
<br/>
<?php 
    if( $_GET['mode'] == "edit" ){ 
        echo '<input type = "hidden" name = "mode" value = "edit">'; 
        echo '<input type = "hidden" name = "a" value = "'. 
            $_GET['a'] .'">'; 
    }  
?>
            <button type = "submit" name="sub" onclick="
                if(name1.value.length==0 && content.value.length ==0)
                {alert('标题和内容不能都为空！');return false;}else{return true;}">完成</button>
        </form>
      </div>

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

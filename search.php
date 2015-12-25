<?php
if(empty($_COOKIE['username']))
{
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

      <title>云笔记-搜索笔记</title>
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
          <li><a href="home.php">主目录</a></li>
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
if (empty($_GET)) {
    echo "<h1>搜索笔记</h1>";
?>
  <form method='get' action='search.php'>
  <table  border = '1'>
    <tbody>
    <div>关键字:<input type = 'text' name = 'keyword' value='' size = '60'
         placeholder='标题或内容关键字/日期'/><button  type = 'submit' onclick="if(keyword.value.length==0){alert('搜索内容不能为空!');return false;}else{return true;}">查找</button>
</div><hr/>
    </tbody>
  </table>
  </form>
<?php
} else {
    function avoid($value){
        $value = str_replace("<", "&lt;", $value);
        $value = str_replace(">", "&gt;", $value);
        $value = nl2br($value);
        return $value;
    }

    $doc = new DOMDocument();

    if( $doc->load("data/".$_COOKIE['username'].".xml") ) {
        $messages = $doc->getElementsByTagName('message');
    }

    $keyword = trim($_GET['keyword']);
    $count = 0;

    echo "<h1>搜索结果</h1>";
    echo "<table border = '1' class = 'bbs'>";
    echo "<tr><th style = 'width: 20%'>标题</th>
        <th style = 'width: 30%'>图片</th>
        <th style = 'width: 30%'>
        內容</th><th style = 'width: 10%'>日期</th><th>操作</th></tr>";

    foreach($messages as $message)
    {
        $name = $message->getElementsByTagName("name")->item(0);
        $content = $message->getElementsByTagName("content")->item(0);
        $time = $message->getElementsByTagName("time")->item(0);
        $picture = $message->getElementsByTagName("picture")->item(0);

        $name = avoid($name->nodeValue);
        $content = avoid($content->nodeValue);
        $time = date("l dS \of F Y h:i:s A", avoid($time->nodeValue));
        $picture = avoid($picture->nodeValue);

        $contain_name = stristr($name, $keyword);
        $contain_content = stristr($content, $keyword);
        $contain_time = stristr($time, $keyword);
        $contain_picture = stristr($picture, $keyword);

        if (!empty($contain_name) || !empty($contain_content)
            || !empty($contain_time || !empty($contain_picture)))
        {
            $count++;
            echo "<tr><td> $name </td>";
            echo "<td><a href='upload_file/$picture'>
                <img src='upload_file/".$_COOKIE['username']."/$picture' width='100%'/></a></td>";
            echo "<td>" . $content . "</td>";
            echo "<td>" . $time . "</td>";
            echo "<td><a href = 'write.php?mode=edit&a=".$count."'>编辑</a>
                <br/><a href = 'delete.php?a=".$count."'>刪除</a>";
        }
    }

    if ($count == 0)
    {
        echo "<tr><td colspan='5'>未搜索到符合条件的笔记！</td></tr>";
    }
    echo "</table>";
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

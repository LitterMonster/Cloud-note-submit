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

      <title>云笔记-分享管理</title>
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

          <h1>我的分享</h1>
<?php
function avoid($value)
{
    $value = str_replace("<", "&lt;", $value);
    $value = str_replace(">", "&gt;", $value);
    $value = nl2br($value);
    return $value;
}
echo "<table border = '1' class = 'bbs'>";
echo "<tr><th style = 'width: 20%'>标题</th>
    <th style = 'width: 30%'>图片</th>
    <th style = 'width: 30%'>
    內容</th><th style = 'width: 10%'>日期</th><th>操作</th></tr>";
$doc = new DOMDocument();

$filename = "data/share.xml";
if (!file_exists($filename))
{
    $userxml = fopen($filename, "w") or die("Unable to open file!");
    fwrite($userxml, 
"<?xml version='1.0'?>\n<!DOCTYPE notes SYSTEM 'restrict.dtd'>\n<notes></notes>");
    fclose($userxml);
    chmod($filename, 0666);
}

$count = 0;
if( $doc->load($filename) ){
    $messages = $doc->getElementsByTagName('message');
    $count = 0;
    $hasmine = false;

    foreach( $messages as $message ){

        $name = $message->getElementsByTagName("name")->item(0);
        $content = $message->getElementsByTagName("content")->item(0);
        $time = $message->getElementsByTagName("time")->item(0);
        $picture = $message->getElementsByTagName("picture")->item(0);
        $author = $message->getElementsByTagName("author")->item(0);
        $stuid = $message->getElementsByTagName("stuid")->item(0);

        $name = avoid($name->nodeValue);
        $content = trim(avoid($content->nodeValue));
        $time = avoid($time->nodeValue);
        $picture = avoid($picture->nodeValue);
        $author = avoid($author->nodeValue);
        $stuid = avoid($stuid->nodeValue);


        if ($stuid == $_COOKIE['username'])
        {
            $save_array[$count] = array(
                    "name" => $name,
                    "content" => $content,
                    "time" => $time,
                    "picture" => $picture,
                    "author" => $author,
                    "stuid" => $stuid
            );
            $hasmine = true;
        }
        $count++;
    }

    for ($temp = $count - 1; !empty($save_array[$temp]); $temp--)
    {
        $name = $save_array[$temp]["name"];
        $content = $save_array[$temp]["content"];
        $time = $save_array[$temp]["time"];
        $picture = $save_array[$temp]["picture"];
        $author = $save_array[$temp]["author"];
        $stuid = $save_array[$temp]["stuid"];

        echo "<tr><td>$name</td>";
        echo "<td><a href='upload_file/$stuid/$picture'>
            <img src='upload_file/$stuid/$picture' width='100%'/></a></td>";
        if (strlen($content) > 100)
        {
            if ($content[99] > 127)
            {
                $content[96] = '';
                $content[97] = '';
                $content[98] = '';
                $content[99] = '';
                $content[100] = '';
                $content[101] = '';
                $content[102] = '';
                $content[103] = '';
            }
            $content = substr($content, 0, 99);
            $content = $content."......";
        }

        echo "<td>$content</td>";
        echo "<td>" . date("l dS \of F Y h:i:s A", $time) . "</td>";
        echo "<td><a href = 'write_share.php?mode=edit&a=".$temp."'>编辑</a>".
            "<br/><a href = 'delete_share.php?mode=share&id=".$temp."'>取消分享</a>";
    }
}
if ($hasmine == false)
{
    echo "<tr><td colspan='5'>当前无您分享的笔记！</td></tr>";
}
echo "</table>";
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

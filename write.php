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

      <title>云笔记</title>
  </head>

  <body>
    <header>
      <div class="inner">
        <h1>云笔记</h1>
        <h2>Let's note anywhere.</h2>
        <a href="https://github.com/LitterMonster/Cloud-note-submit" class="button"><small>View project on</small> GitHub</a>
      </div>
    </header>

    <div class="menu-wrap">
      <nav class="menu">
        <ul class="clearfix">
          <li><a href="index.php">主目录</a></li>
          <!--
          <li>
            <a target="_blank" href="tutorials.html">Tutorials <span class="arrow">&#9660;</span></a>

            <ul class="sub-menu">
              <li> <a href="tutorials.html#t1">the EULA</a></li>
              <li> <a href="tutorials.html#t2">Hello, World!</a></li>
              <li> <a href="tutorials.html#t3">Send for Signature!</a></li>
              <li> <a href="tutorials.html#t4">A Real Nondisclosure Agreement</a></li>
              <li> <a href="tutorials.html#t5">What Docsets Are Available?</a></li>
              <li> <a href="tutorials.html#t6">Generating Multiple Documents &ndash; Incorporation</a></li>
              <li> <a href="tutorials.html#t7">Developing Your Own Templates</a></li>
            </ul>
          </li>
          -->
          <li><a href="write.php">新建笔记</a></li>
          <li><a href="search.php">搜索笔记</a></li>
          <li><a href="about.html">关于</a></li>
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
        if( $doc->load("data/bbs.xml") ){
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
      <form action = "process.php?old_pic=<?=$picture?>" method = "post" enctype="multipart/form-data">
            <strong>标题：</strong><br/><input type = "text" name = "name"
 value = "<?php echo $name; ?>" size='70%'/><br/>
            <strong>内容：</strong><br/><textarea name = "content" style
 = "width: 580px; height: 200px;"><?php echo $content; ?></textarea><br/>
            <strong>图片:</strong></br>
<?php
    if (!empty($picture) && $picture != "no_pic.jpg")
        echo "<a href='upload_file/$picture'><img src='upload_file/$picture' width='805px'/></a>"
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
                if(content.value.length ==0)
                {alert('内容不能都为空！');return false;}else{return true;}">完成</button>
        </form>
      </div>

        </section>

        <aside id="sidebar">
          <a href="index.php" class="button">
            <small>View all notes</small>
            查看笔记
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

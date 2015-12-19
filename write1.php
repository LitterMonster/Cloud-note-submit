<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>云笔记</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <!--[if lt IE 9]>
    <script src="dist/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
    <header>
      <!--<img alt="Sonic" src="images/logo.png" />-->
    </header>
    <nav>
      <ul>
        <li>
          <a href="index.php">笔记首页</a>
        </li>
        <li>
          <a href="write.php">新建笔记</a>
        </li>
      </ul>
    </nav>
    <section id="content">
      <div id="sonic"></div>
     <!-- <div id="metal_sonic"></div>-->
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
      else echo "<h1>新建笔记!</h1>";
      ?>
      <br/>
      <div style = "padding-left: 50px;">
        <form action = "process.php" method = "post" enctype="multipart/form-data">
            <strong>标题：</strong><br/><input type = "text" name = "name"
 value = "<?php echo $name; ?>" size='67'/><br/>
            <strong>内容：</strong><br/><textarea name = "content" style
 = "width: 800px; height: 200px;"><?php echo $content; ?></textarea><br/>
            <strong>图片:</strong></br>
<?php
      if (!empty($picture) && $picture != "no_pic.jpg")
            echo "<img src='upload_file/$picture' width='805px'/>"
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
            <input type = "submit" name="sub" value = "完成"/>
        </form>
      </div>
    </section>
    <footer>Powered by ZhangTao （13软工A2 张涛)
    <br />
    <span style="color: yellow">XML大作业</span></footer>
  </body>
</html>

<?php
/*
//为了更新share.xml中的内容，这里需要先将id的内容取出来
//做对比，然后再同步
$doc = new DOMDocument();
$filename = "data/".$_COOKIE['username'].".xml";

if( $doc->load($filename) ){
    $editMessage = $doc->getElementsByTagName('message')
        ->item((int)$_GET['a']);
    $old_name = $editMessage->getElementsByTagName('name')
        ->item(0)->nodeValue;
    $old_time = $editMessage->getElementsByTagName('time')
        ->item(0)->nodeValue;
    $old_content = $editMessage->getElementsByTagName('content')
        ->item(0)->nodeValue;
    $old_picture = $editMessage->getElementsByTagName('picture')
        ->item(0)->nodeValue;
}

//将share.xml中的文件内容取出来做对比
$share_doc = new DOMDocument();
$share_doc->formatOutput = true;
$sharefile = "data/share.xml";

if( $share_doc->load($sharefile) ){
    $messages = $share_doc->getElementsByTagName('message');
    $state = false;
    $location = 0;
    foreach( $messages as $message ){
        $name = $message->getElementsByTagName("name")->item(0)->nodeValue;
        $content = $message->getElementsByTagName("content")->item(0)->nodeValue;
        $time = $message->getElementsByTagName("time")->item(0)->nodeValue;
        $picture = $message->getElementsByTagName("picture")->item(0)->nodeValue;
        if ($old_name == $name && $old_time == $time &&
            $old_content == $content && $old_picture == $picture)
        {
//echo "$old_name. $old_time, $old_content, $old_picture";
//echo "$name. $time, $content, $picture";
//die;
            $result_message = $message;
            $share_root = $share_doc->getElementsByTagName('notes')->item(0);
            $state = true;
            break;
        }
        $location++;
    }
}
 */
$doc = new DOMDocument();
$doc->formatOutput = true;

$xmlfile = "data/".$_COOKIE['username'].".xml";
if( $doc->load($xmlfile) ){
    $root = $doc->getElementsByTagName('notes')->item(0);
}
else{
    $root = $doc->createElement('notes');
    $root = $doc->appendChild($root);
}

$message = $doc->createElement('message');
$name = $doc->createElement('name');
$name->appendChild($doc->createTextNode($_POST['name1']));
$timestamp = time();
$time = $doc->createElement('time');
$time->appendChild($doc->createTextNode($timestamp));
$content = $doc->createElement('content');
$content->appendChild($doc->createTextNode($_POST['content']));

if (isset($_POST['sub']))
{
    if (!empty($_FILES["file"]["name"]))
    {
        $filename=$timestamp;
        $filetype = strrchr($_FILES["file"]["name"],".");
        $filename.=strrchr($_FILES["file"]["name"],".");//上传文件的名称

        $tmp_name = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["error"] > 0)
        {
            echo "<meta charset='utf-8'>";
            echo "<script>alert('上传文件超过了20M,上传终止！')</script>";
            //echo "上传文件有误:".$_FILES["file"]["error"]."<br/>";
            die;
        } else {
            if(move_uploaded_file($tmp_name, 
                "./upload_file/".$_COOKIE['username']."/$filename")){
                //echo "$filename上传成功!";
            } else {
                echo "<meta charset='utf-8'>";
                echo "<script>alert('上传失败！')</script>";
                die;
            }
        }
    } else {
        if (!empty($_GET['old_pic']))
        {
            $filename = $_GET['old_pic'];
        } else {
            $filename = "no_pic.jpg";
        }
    }
}

//添加图片
$picture = $doc->createElement('picture');
$picture->appendChild($doc->createTextNode($filename)); 

$name = $message->appendChild($name);
$time = $message->appendChild($time);
$content = $message->appendChild($content);
$picture = $message->appendChild($picture);
/*
if ($state == true)
{
    //var_dump($_POST);
    //die;
    //同样创建一份给share.xml准备
    $share_message = $share_doc->createElement('message');

    $share_name = $share_doc->createElement('name');
    $share_name->appendChild($share_doc->createTextNode($_POST['name1']));

    $timestamp = time();
    $share_time = $share_doc->createElement('time');
    $share_time->appendChild($share_doc->createTextNode($timestamp));

    $share_content = $share_doc->createElement('content');
    $share_content->appendChild($share_doc->createTextNode($_POST['content']));
    
    $share_picture = $share_doc->createElement('picture');
    $share_picture->appendChild($share_doc->createTextNode($filename)); 

    $author = $share_doc->createElement('author');
    $author->appendChild($share_doc->createTextNode($_COOKIE['turename']));

    $stuid = $share_doc->createElement('stuid');
    $stuid->appendChild($share_doc->createTextNode($_COOKIE['username']));

    $share_name = $share_message->appendChild($share_name);
    $share_time = $share_message->appendChild($share_time);
    $share_content = $share_message->appendChild($share_content);
    $share_picture = $share_message->appendChild($share_picture);
    $author = $share_message->appendChild($author);
    $stuid = $share_message->appendChild($stuid);

    if ( $_POST['mode'] == "edit" ) {
        echo "Here";
        die;
        $replaceMessage = $share_doc->getElementsByTagName('message')
            ->item($location);
        $replaceMessage = $replaceMessage->parentNode->replaceChild
            ($share_message, $replaceMessage);
    }
    else{
        $share_message = $share_root->appendChild($share_message);
    }

    $doc->save($sharefile);
}
 */
if ( $_POST['mode'] == "edit" ) {
    $replaceMessage = $doc->getElementsByTagName('message')
        ->item((int)$_POST['a']);
    $replaceMessage = $replaceMessage->parentNode->replaceChild
        ($message, $replaceMessage);
}
else{
    $message = $root->appendChild($message);
}

$doc->save($xmlfile);
echo "<meta http-equiv='refresh' content='0;home.php'/>";
?>

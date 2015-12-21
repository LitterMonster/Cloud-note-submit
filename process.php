<?php
$doc = new DOMDocument();
$doc->formatOutput = true;

$xmlfile = "data/".$_COOKIE['username'].".xml";
if( $doc->load($xmlfile) ){
    $root = $doc->getElementsByTagName('bbs')->item(0);
}
else{
    $root = $doc->createElement('bbs');
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
        $filename.=strrchr($_FILES["file"]["name"],".");//上传文件的名称

        $tmp_name = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["error"] > 0)
        {
            echo "上传文件有误:".$_FILES["file"]["error"]."<br/>";
            die;
        } else {
            if(move_uploaded_file($tmp_name, 
                "./upload_file/".$_COOKIE['username']."/$filename")){
                //echo "$filename上传成功!";
            } else {
                echo $filename."上传失败";
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

if( $_POST['mode'] == "edit" ){
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

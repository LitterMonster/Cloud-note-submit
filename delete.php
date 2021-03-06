<?php
function avoid($value){
    $value = str_replace("<", "&lt;", $value);
    $value = str_replace(">", "&gt;", $value);
    $value = nl2br($value);
    return $value;
}

$doc = new DOMDocument();
$doc->formatOutput = true;
$filename = "data/".$_COOKIE['username'].".xml";

if( $doc->load($filename) ){
    $deleteMessage = $doc->getElementsByTagName('message')->item((int)$_GET['a']);
    $picture = $deleteMessage->getElementsByTagName("picture")->item(0);
    $picture = avoid($picture->nodeValue);
    if ($picture != "no_pic.jpg")
    {
        if (unlink("upload_file/".$_COOKIE['username']."/$picture") == false)
        {
            echo "<meta charset='utf-8'>";
            echo "<script>alert('笔记删除错误！')</script>";
            echo "<meta http-equiv='refresh' content='0;home.html'/>";
        }
    }
    $deleteMessage = $doc->documentElement->removeChild($deleteMessage);
    $doc->save($filename);
}

//将share.xml中的文件也删除
$doc = new DOMDocument();
$doc->formatOutput = true;
$filename = "data/share.xml";

if( $doc->load($filename) ){
    $messages = $doc->getElementsByTagName('message');

    foreach( $messages as $message ){
        $stuid = $message->getElementsByTagName("stuid")->item(0);
        $stuid = avoid($stuid->nodeValue);
        if ($stuid == $_COOKIE['username'])
        {
            $message = $doc->documentElement->removeChild($message);
        }
    }
    $doc->save($filename);
}
echo "<meta http-equiv='refresh' content='0;home.php'/>";
?>

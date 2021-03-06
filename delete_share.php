<?php
function avoid($value){
    $value = str_replace("<", "&lt;", $value);
    $value = str_replace(">", "&gt;", $value);
    $value = nl2br($value);
    return $value;
}

$doc = new DOMDocument();
$doc->formatOutput = true;
$filename = "data/share.xml";

//将记录从share.xml中删除
if( $doc->load($filename) ){
    $deleteMessage = $doc->getElementsByTagName('message')->item((int)$_GET['id']);
    $picture = $deleteMessage->getElementsByTagName("picture")->item(0);
    $picture = avoid($picture->nodeValue);
    if ($picture != "no_pic.jpg")
    {
        if (stristr($picture, "_share"))
        {
            if (unlink("upload_file/".$_COOKIE['username']."/$picture") == false)
            {
                echo "<meta charset='utf-8'>";
                echo "<script>alert('笔记删除错误！')</script>";
                echo "<meta http-equiv='refresh' content='0;home.html'/>";
            }
        }
    }
    $deleteMessage = $doc->documentElement->removeChild($deleteMessage);
    $doc->save($filename);
}

echo "<meta http-equiv='refresh' content='0;share_mng.php'/>";
?>

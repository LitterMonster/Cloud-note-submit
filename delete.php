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
        unlink("upload_file/$picture");
    }
    $deleteMessage = $doc->documentElement->removeChild($deleteMessage);
    $doc->save($filename);
  }
  
  echo "<meta http-equiv='refresh' content='0;home.php'/>";
?>

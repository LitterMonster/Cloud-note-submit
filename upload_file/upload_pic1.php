<?php
////////上传文件////////////
if(isset($_POST["sub"])){
//$upfile="../upload_file/".$_FILES["file"]["name"];
$name=time();//定义变量，保存图片名，以防图片的名字相同
echo $name;
$name.=strrchr($_FILES["file"]["name"],".");//上传文件的名称
echo $name;
$num=rand(1,10);
$type=$_FILES["file"]["type"];
$size=$_FILES["file"]["size"];
$tmp_name=$_FILES["file"]["tmp_name"];
if($_FILES["file"]["error"]>0){
echo "上传文件有误:".$_FILES["file"]["error"]."<br/>";
}else{
echo "上传文件名为：".$name."<br>";
echo "上传文件类型为：".$type."<br>";
echo "上传文件大小为：".($size/1024)."<br>";
echo "上传到：".$tmp_name."<br>";
if(file_exists("../upload_file/$name")){
echo "已经存在";
}else{
if(move_uploaded_file($tmp_name, "../upload_file/$name")){
echo $name."上传成功";
}else{
echo $name."上传失败";
}
}
}
}

?>
<form method="post" action="upload_pic1.php" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" name="sub" value="upload">
<input type="reset" name="res" value="reset"/>
</form>

<?php
$meta = "<meta charset='utf-8'>";
echo $meta;
echo "<br/>-----------</br>";
$originFile = "http://bokix-domain1.stor.sinaapp.com/mini1393988685.jpg";
list($width, $height, $type, $attr) = getimagesize($originFile);

echo("width:$width,height:$height,type:$type");
echo "<br/>-----------</br>";
$data = $originFile;
$destWidth = 80;
$destHeight = 80;
$data = new SaeImage(file_get_contents($data));
$arr = $data->getImageAttr();
print_r($arr);

echo "<br/>-----------</br>";
/**
while (max($width, $height) > max($destWidth, $destHeight)) {
    echo("to resize...<br/>");

    $data->resizeRatio(0.75);
    $data = $data->exec();
    if($data===false){

    }
    $img = new SaeImage($data);
    list($width, $height, $type, $attr) = $img->getImageAttr();
    echo("2width:$width,2height:$height,type:$type");
}
echo("result:$width,$height");
echo "<br/>----2222-------</br>";
 */
$s = new SaeStorage();
$data = $data->exec();
$b = $s->write('domain1', '/test342/test234.jpg', $data);

echo $b;


?>
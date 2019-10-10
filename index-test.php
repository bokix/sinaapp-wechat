<?php

//phpinfo();
$mem = memcache_init();
if($mem==false){
    exit("init false.");
}

$v = memcache_get($mem,"key1");
echo "get key1:". "<br/>";
if($v==false){
    echo "false"."<br/>";
}
if($v==null){
    echo "null"."<br/>";
}
print_r($v);//
echo "<br/>";

$arr = array(
    "1" => "v1",
    "2" => "v2",
);

$b = array(1,2,3);

memcache_set($mem,"key1", $arr);
echo "done.";
?>

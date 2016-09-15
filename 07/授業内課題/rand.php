<?php
//POSTの情報を変数に格納
$name = $_POST["name"];
$age = $_POST["age"];

//random関数rand(min, max)でOK
$r = rand(1,5);

//おみくじ結果
if($r == 1){
    $result = "大吉";
}elseif($r == 2){
    $result = "中吉";
}elseif($r == 2){
    $result = "小吉";
}elseif($r == 2){
    $result = "吉";
}else{
    $result = "凶";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <title>おみくじ結果発表</title>
</head>
<body>
    <h2 style="text-align:center"><?= $name ?>さん　<?= $age ?>歳の運勢は？？？</h2>
    <br><br>
    <h1 style="text-align:center"><?= $result ?>です！</h1>
</body>
</html>




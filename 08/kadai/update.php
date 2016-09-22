<?php
include("functions.php");

$id = $_POST["id"];
$name = $_POST["name"];
$url = $_POST["url"];
$cmt = $_POST["cmt"];

$pdo = db_con();

$stmt = $pdo->prepare("UPDATE gs_bm_table SET book_name=:name, book_url=:url, book_cmt=:cmt WHERE id=:id");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':cmt', $cmt, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

if($status=false){
    queryError($stmt);
}else{
    header("Location: initialize.php");
    exit;
}

?>
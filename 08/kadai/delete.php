<?php
include("functions.php");
//引数取得
$id = $_GET["id"];
//DBへの接続
$pdo = db_con();

//SQL
$stmt = $pdo->prepare("DELETE FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();
if($status=false){
    queryError($stmt);
}else{
    header("Location: initialize.php");
    exit;
}

?>
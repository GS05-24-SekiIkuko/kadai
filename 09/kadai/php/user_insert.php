<?php

$name = $_POST["name"];
$loginId = $_POST["loginId"];
$loginPw = $_POST["loginPw"];

include("common.php");

$pdo = db_con();

$stmt = $pdo->prepare("INSERT INTO gs_user_table(id, name, lid, lpw, kanri_flg, life_flg) VALUE(NULL, :name, :lid, :lpw , 0, 0)");
$stmt->bindValue(':name', $name,   PDO::PARAM_STR);
$stmt->bindValue(':lid', $loginId,  PDO::PARAM_STR);
$stmt->bindValue(':lpw', $loginPw, PDO::PARAM_STR);
$status = $stmt->execute();

if($Status=false){
    queryError($stmt);
}


?>
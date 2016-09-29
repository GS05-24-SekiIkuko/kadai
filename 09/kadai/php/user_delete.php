<?php
//ユーザー情報を削除する（論理削除）

include("common.php");
//1.POSTでParamを取得
$id = $_POST["id"];

//2.DB接続など
$pdo = db_con();

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
$stmt = $pdo->prepare("UPDATE gs_user_table SET life_flg=1 WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($Status=false){
    queryError($stmt);
}

?>

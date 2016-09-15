<?php
//DBへの接続
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
}catch(PDOException $e){
    exit("データベースに接続できませんでした。".$e->getMessage());
}

//データ一覧表示用SQL作成
$stmt = $pdo->prepare("SELECT indate, book_name, book_url FROM gs_bm_table");
$status = $stmt->execute();

//データ表示
$viewContainer = array();
if($status == false){
    //SQL実行時にエラーの場合
    $error = $stmt->errorInfo();
    exit("ErrorQuery: ".$error[2]);
}else{
    //データの数だけループする
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $viewContainer[] = array("indate"=>$result["indate"], "name"=>$result["book_name"], "url"=>$result["book_url"],);
    }
    include "bm_list_view.php";
}

?>
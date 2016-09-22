<?php
include("functions.php");

//DBへの接続
$pdo = db_con();

//データ一覧表示用SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
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
        $viewContainer[] = array("id"=>$result["id"], "indate"=>$result["indate"], "name"=>$result["book_name"], "url"=>$result["book_url"],);
    }
?>
<!DOCTYPE html>
<html lang="ja">
<body>
    <div class="search main">
        <p class="searchTitle">〜全件表示中〜</p>
    </div>
</body>
</html>
<?php
    include "listView.php";
}

?>

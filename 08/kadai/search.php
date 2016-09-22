<?php
include("functions.php");

//POSTの内容を取得する
if($_POST["bookName"]){
    $name = $_POST["bookName"];
}else{
    $name = "";
};
if($_POST["startDate"]){
    $start = $_POST["startDate"];
}else{
    $start = "1970-01-01";
};
if($_POST["endDate"]){
    $end = $_POST["endDate"];
}else{
    $end = date("Y-m-d");
};

//DBへの接続
$pdo = db_con();

//データ一覧表示用SQL作成
$sqlStr = "book_name LIKE :name AND indate >= :start AND indate <= :end";

if("" !== $sqlStr){
    $stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE $sqlStr");
    $stmt->bindValue(":name", "%$name%", PDO::PARAM_STR);
    $stmt->bindValue(":start", $start, PDO::PARAM_STR);
    $stmt->bindValue(":end", $end, PDO::PARAM_STR);

}else{
    $stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
}
//var_dump($stmt);
$status = $stmt->execute();

//データ表示
$viewContainer = array();
if($status == false){
    queryError($stmt);
}else{
    //データの数だけループする
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $viewContainer[] = array("id"=>$result["id"], "indate"=>$result["indate"], "name"=>$result["book_name"], "url"=>$result["book_url"], "cmt"=>$result["book_cmt"],);
    };
    if("" == $name){
        $name = "指定なし";
    };
    if("1970-01-01" == $start){
        $date = "〜";
    }else{
        $date = $start."〜";   
    };
    if(date("Y-m-d") == $end){
        $date .= "";
    }else{
        $date .= $end;   
    };
    if("1970-01-01" == $start and date("Y-m-d") == $end){
        $date = "指定なし";
    }
?>    
<!DOCTYPE html>
<html lang="ja">
<body>
    <div class="search main">
        <p class="searchTitle">以下の条件で検索しました</p>
        <p>書籍名：<?=$name?></p>
        <p>登録日：<?=$date?></p>
    </div>
</body>
</html>
    
    
<?php

    include "listView.php";    
}

?>
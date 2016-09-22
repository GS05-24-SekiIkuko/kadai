<?php
include("functions.php");

$id = $_GET["id"];
$pdo = db_con();

$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status=false){
    queryError($stmt);
}else{
    $row = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    
</head>
<body>
    <form method="post" action="update.php">
       <div class="jumbotron">
        <fieldset>
            <legend>編集画面</legend>
             <label>書籍名：<input type="text" name="name" value="<?=$row["book_name"]?>"></label><br>
             <label>URL：<input type="text" name="url" value="<?=$row["book_url"]?>"></label><br>
             <label>コメント：<textArea name="cmt" rows="4" cols="40"><?=$row["book_cmt"]?></textArea></label><br>
        <!--     ブラウザ上には表示されないが、送信したときにはデータを送ることができるようにしておく-->
             <input type="hidden" name="id" value="<?=$id?>">
             <input type="submit" value="送信">
             <input type="button" value="削除" onClick="location.href='delete.php?id=<?=$id?>'">
        </fieldset>
        </div>
    </form>
</body>
</html>

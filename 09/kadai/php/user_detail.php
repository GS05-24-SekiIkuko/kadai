<?php
//現在ログインしているユーザーの情報を表示する
session_start();
include("common.php");
ssidCheck();

$userId = $_SESSION["userId"];

//DB接続
$pdo = db_con();

$sql = "SELECT * FROM gs_user_table WHERE id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$res = $stmt->execute();

//SQL実行時エラー
if($res==false){
    queryError($stmt);
}

$val = $stmt->fetch();
if($val["id"] != ""){
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー情報</title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
    <h2>ユーザー情報の更新、削除</h2>
    <a href="main.php">メイン画面に戻る</a>
    
    <input type="hidden" id="id" value="<?=$val["id"]?>">
    <p>名前：</p><input type="text" value="<?=$val["name"]?>" id="name">
    <p>ID：</p><input type="text" value="<?=$val["lid"]?>" id="loginId">
    <p>パスワード：</p><input type="text" value="<?=$val["lpw"]?>" id="loginPw">
<!--    <p>登録日：</p><input type="text" value=""-->

    <input type="button" value="更新" id="btnUpdate">
    <input type="button" value="削除" id="btnDelete">
    
    <script>
        $(document).ready(function(){
            $("#btnUpdate").on('click', function(){
                $.ajax({
                    type: "POST",
                    url: "user_update.php",
                    data: {
                        name: $("#name").val(),
                        loginId: $("#loginId").val(),
                        loginPw: $("#loginPw").val(),
                        id: $("#id").val()
                    }
                }).done(function(data){
                    console.log("done");
                    alert("更新しました!!");
                }).fail(function(err){
                    console.log("error");
                    alert("更新に失敗しました。");
                });
            });
            $("#btnDelete").on('click', function(){
                $.ajax({
                    type: "POST",
                    url: "user_delete.php",
                    data: {
                        id: $("#id").val()
                    }
                }).done(function(data){
                    console.log("done");
                    alert("削除しました。");                window.location.href = "logout.php";
                }).fail(function(err){
                    console.log("error");
                    alert("削除失敗しました。");
                });
            });
        });
    </script>
</body>
</html>
<?php
}else{
    header("Location: logout.php");
    exit();
}
?>
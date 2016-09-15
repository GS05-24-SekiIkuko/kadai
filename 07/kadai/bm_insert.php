<?php
//ブックマーク登録画面

//1. POSTデータ取得
$bookName = $_POST["bookName"];
$bookUrl = $_POST["bookUrl"];
$bookCmt = $_POST["bookCmt"];


//2. DB接続する
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
//prepareはsqlを格納して実行するもの。:a1, :a2, :a3はバインド変数。
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, book_name, book_url, book_cmt,
indate )VALUES(NULL, :a1, :a2, :a3, sysdate())");

//変数に値をバインドする。SQLインジェクション対策になる。このやり方であれば危険な文字列があったら変換してくれる。
$stmt->bindValue(':a1', $bookName, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $bookUrl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $bookCmt, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト(:の後に半角スペースを開けないと上手くいかないらしい)
  header("Location: bm_insert_view.php");
  exit;

}
?>

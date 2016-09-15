<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>BookMarkApp</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="initialize.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="bm_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>登録する本の内容を入力してください</legend>
     <label>書籍名：<input type="text" name="bookName"></label><br>
     <label>書籍URL：<input type="text" name="bookUrl"></label><br>
     <label>コメント：<textArea name="bookCmt" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="登録">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>

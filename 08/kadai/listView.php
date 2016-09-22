<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧表示</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!--    検索条件の設定-->
    <div class="main">
    <div class="search">
    <form method="post" action="search.php">
        <p class="searchTitle">検索条件入力</p>
        <p>書籍名：<input type="text" name="bookName"></p>
        <p>登録日：<input type="date" name="startDate"> ~ <input type="date" name="endDate"></p>
        <input type="submit" value="検索">
    </form>
    </div>
    <ul class="lineHeader">
        <li class="line-header"><p class="indate">登録日</p></li>
        <li class="line-header"><p class="name">書籍名</p></li>
        <li class="line-header"><div class="title">書籍URL</div></li>
    </ul>
    <div class="bookBox">
    <ul>
    <?php foreach($viewContainer as $viewLine):
    ?>
    <li>
    <ul class="line">
        <li class="line-inner"><p class="indate"><?= $viewLine["indate"]?></p></li>
        <li class="line-inner"><p class="name"><a href="detail.php?id=<?=$viewLine["id"]?>"><?= $viewLine["name"]?></a></p></li>
        <li class="line-inner"><p class="url"><a href="<?= $viewLine["url"]?>"><?= $viewLine["url"]?></a></p></li>
        </ul></li>
    <?php
        endforeach;
    ?>
        </ul></div>
    </div>
</body>
</html>
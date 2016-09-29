<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ログイン画面</title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>

<header>
  <nav class="navbar navbar-default">ログイン</nav>
</header>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form name="form1" action="login_act.php" method="post">
ID:<input type="text" name="lid" />
PW:<input type="password" name="lpw" />
<input type="submit" value="ログイン" />
<input type="button" value="新規登録" id="btnAddUser">
</form>
<script>
    $(document).ready(function(){
        $("#btnAddUser").on('click', function(){
            window.location.href = "user_add.php";
        });
        
    });
    
</script>
</body>
</html>
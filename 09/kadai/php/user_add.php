<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー新規登録</title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
    <h2>ユーザー新規登録</h2>
    <p>名前：</p><input type="text" value="" id="name">
    <p>ID：</p><input type="text" value="" id="loginId">
    <p>パスワード：</p><input type="text" value="" id="loginPw">
    <input type="button" value="登録" id="btnAdd">
    <script>
        $(document).ready(function(){
            $("#btnAdd").on('click', function(){
                $.ajax({
                    type: "POST",
                    url: "user_insert.php",
                    data: {
                        name: $("#name").val(),
                        loginId: $("#loginId").val(),
                        loginPw: $("#loginPw").val(),
                    }
                }).done(function(data){
                    console.log("done");
                    alert("登録しました!!");
                    window.location.href = "login.php";
                }).fail(function(err){
                    console.log("error");
                    alert("登録に失敗しました。");
                });
            });
        });
    </script>
</body>
</html>
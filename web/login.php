<?php
if(isset($_POST['userid']) && isset($_POST['pass'])){
    require_once '../DB/UserManager.php';
    $UM = new UserManager();
    $userID = htmlspecialchars($_POST['userid'] , ENT_QUOTES, 'UTF-8');
    $passwd = htmlspecialchars($_POST['pass'] , ENT_QUOTES, 'UTF-8');
    $UM->login($userID, $passwd);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ログイン画面 | mamoriO</title>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/vnd.microsoft.ico">
    <link rel="apple-touch-icon-precomposed" href="../favicon/favicon-152.png">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/smoke.min.css" rel="stylesheet">
    <link href="../css/glyphicon.css" rel="stylesheet">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/smoke.min.js"></script>
    <script src="../lang/ja.min.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <link href="../css/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/form_style.css">
    <link rel="stylesheet" href="../css/smoke_change.css">
</head>
<body>
    <div id="header">
        <div id="header-name">mamoriO</div>
    </div>
    <div id="head-blank"></div>
    <div class="card-field">

        <div class="card">
            <div class="card-block">
                <h4 class="card-title txt-title">ログイン</h4>
                <form id="formEmpty" data-smk-icon="glyphicon-remove-sign" action="./login.php" method="post">
                    <div class="form-group">
                        <label class="control-label">ユーザーID</label>
                        <input type="text" id="form-userid" class="form-control" name="userid" placeholder="ユーザーID" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">パスワード</label>
                        <input type="password" id="form-passwd" class="form-control" name="pass" placeholder="パスワード" data-smk-strongPass="medium" required>
                    </div>
                    <div class="button-grp">
                        <button type="button" id="btnEmpty" class="btn btn-warning" name="login">ログイン</button>
                        <button type="button" class="btn btn-warning" onClick="history.back();">戻る</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#btnEmpty').on('click',function(e) {
                if ($('#formEmpty').smkValidate()) {
                    formAjax();
                }
            });
        });
        function formAjax(){
            var userid = document.getElementById('form-userid').value;
            var passwd = document.getElementById('form-passwd').value;
            $.ajax({
                url: '../ajax/login.php',
                type: 'POST',
                dataType: 'json',
                data: {ParentID: userid,
                    Password: passwd}
                })
            .done(function(data) {
                if(data){
                    swal({
                        title: "ログインエラー",
                        text: "IDとパスワードが間違っている可能性があります。",
                        type: "error",
                        confirmButtonText: "戻る"
                    });
                } else {
                    var target = document.getElementById("formEmpty");
                    target.method = "post";
                    target.submit();
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert("通信エラーがおきました");
            });
        }
    </script>
</body>
</html>

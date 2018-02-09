<?php
if(isset($_POST["username"]) && isset($_POST["userid"]) && isset($_POST["pass"])){
    require_once '../DB/UserManager.php';
    $userName = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $userID = htmlspecialchars($_POST["userid"], ENT_QUOTES, 'UTF-8');
    $passwd = htmlspecialchars($_POST["pass"], ENT_QUOTES, 'UTF-8');
    $UM = new UserManager();
    $UM->registerUser($userID,$userName,$passwd);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登録完了 | mamoriO</title>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/vnd.microsoft.ico">
    <link rel="apple-touch-icon-precomposed" href="../favicon/favicon-152.png">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/form_style.css">
</head>
<body>

    <div id="header">
        <div id="header-name">mamoriO</div>
    </div>
    <div id="head-blank"></div>
    <div class="card-field">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title txt-title">登録完了</h4>
                <div class="txt-center">登録完了しました</div>
                <div class="button-grp">
                    <button type="button" class="btn btn-warning" onClick="location.href='./login.php'">ログイン画面へ</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

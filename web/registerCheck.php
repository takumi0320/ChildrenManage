<?php
    if(isset($_POST["username"]) && isset($_POST["userid"]) && isset($_POST["pass"])){
        $userName = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
        $userID = htmlspecialchars($_POST["userid"], ENT_QUOTES, 'UTF-8');
        $passwd = password_hash(htmlspecialchars($_POST["pass"]), PASSWORD_DEFAULT);
    }else{
        header('Location: ./register.php');
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登録確認 | mamoriO</title>
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
        <form action="./registerComp.php" method="post">
            <div id="form-border">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title txt-title">登録確認</h4>
                        <div class="form-group">
                            <label>ニックネーム</label>
                            <div><?php echo $userName; ?></div>
                            <input type="hidden" name="username" value="<?php echo $userName; ?>">
                        </div>
                        <div class="form-group">
                            <label>ユーザID</label>
                            <div><?php echo $userID; ?></div>
                            <input type="hidden" name="userid" value="<?php echo $userID; ?>">
                        </div>
                        <div class="form-group">
                            <label>パスワード</label>
                            <div>個人情報のため隠して表示しています。</div>
                            <input type="hidden" name="pass" value="<?php echo $passwd; ?>">
                        </div>
                        <div class="button-grp">
                            <button  type="submit" class="btn btn-warning">登録</button>
                            <button type="button" class="btn btn-warning" onClick="history.back();">戻る</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

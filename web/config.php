<?php
include '../include/login_check.php';
include '../include/child_check.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>設定 | mamoriO</title>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/vnd.microsoft.ico">
    <link rel="apple-touch-icon-precomposed" href="../favicon/favicon-152.png">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/drawer.min.css" rel="stylesheet">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
    <script src="../js/iscroll.js"></script>
    <script src="../js/drawer.min.js"></script>
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/form_style.css">
    <link rel="stylesheet" href="../css/config_style.css">

</head>
<body class="drawer drawer--left">
    <!-- ハンバーガーボタン -->
    <button type="button" class="drawer-toggle drawer-hamburger">
        <span class="sr-only">toggle navigation</span>
        <span class="drawer-hamburger-icon"></span>
    </button>

    <?php include './side_bar.php'; ?>
    
    <div id="header">
        <div id="header-name"><a class="a-header" href="./index.php">mamoriO</a></div>
    </div>
    <div id="head-blank"></div>
    <div class="card-field">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title txt-title">設定</h4>

                <div class="config-mode">
                    <button type="button" class="btn btn-warning" onclick="location.href=''">使い方</button>
                </div>

                <div class="config-mode">
                    <button type="button" class="btn btn-warning" onclick="location.href='./registerChild.php'">子供の登録</button>
                </div>

                <div class="config-mode">
                    <button type="button" class="btn btn-warning" onclick="location.href='./passChange.php'">パスワード変更</button>
                </div>

                <div class="config-mode">
                    <button type="button" class="btn btn-warning" onclick="location.href=''">利用規約</button>
                </div>


                <div class="config-mode">
                    <button type="button" class="btn btn-warning" onclick="history.back();">戻る</button>
                </div>
            </div>
        </div>

    </div>
    <script>
    $(document).ready(function() {
        $(".drawer").drawer();
    });
    </script>
</body>
</html>

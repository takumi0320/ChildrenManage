<?php
include '../include/login_check.php';
require_once '../DB/UserManager.php';
if(isset($_POST['ChildID'])){
    $UM = new UserManager();
    $childID = htmlspecialchars($_POST['ChildID'], ENT_QUOTES, 'UTF-8');
    $UM->setChildInfo($childID);
} else {
    $UM = new UserManager();
    $result = $UM->searchChildInfo($_SESSION['ParentID']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>子供の選択 | mamoriO</title>
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
                <h4 class="card-title txt-title">子供の選択</h4>
                <form id="formEmpty" data-smk-icon="glyphicon-remove-sign" action="./ChildSelect.php" method="post">

                    <?php
                    if(!empty($result)){
                        echo '<div class="button-grp">';
                        foreach ($result as $value) {
                            echo '<button type="submit" class="btn btn-warning" name="ChildID" value="' . $value['childID'] . '">' . $value['childName'] . '</button>';
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="txt-center">お子さんを登録してください。</div>';
                    }
                    ?>

                    <div class="button-grp">
                        <button type="button" class="btn btn-warning" onClick="location.href='./registerChild.php';">子供の追加登録</button>
                        <button type="button" class="btn btn-warning" onClick="history.back();">戻る</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

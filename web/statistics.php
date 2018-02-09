<?php
include '../include/login_check.php';
include '../include/child_check.php';
require_once '../DB/GPSManager.php';
if(isset($_GET['date'])){
    $GPSM = new GPSManager();
    $setDate = htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8');
    $date = date('Ym', $setDate);
    $result = $GPSM->getGPSDataMonthList($_SESSION['ChildID'], $date);
} else {
    $GPSM = new GPSManager();
    $setDate = time();
    $date = date('Ym', $setDate);
    $result = $GPSM->getGPSDataMonthList($_SESSION['ChildID'], $date);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>統計情報 | mamoriO</title>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/vnd.microsoft.ico">
    <link rel="apple-touch-icon-precomposed" href="../favicon/favicon-152.png">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/drawer.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
    <script src="../js/iscroll.js"></script>
    <script src="../js/drawer.min.js"></script>
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/statistics_style.css">

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

        <div class="date-title">
            <form action="./statistics.php" method="get">
                <button type="submit" name="date" class="btn btn-warning btn-prev-month" value="<?php echo strtotime('-1months', $setDate);?>"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;前の月</button>

                <div class="date-data txt-bold txt-color"><?php echo date('Y年m月', $setDate);?></div>

                <button type="submit" name="date" class="btn btn-warning btn-next-month" value="<?php echo strtotime('+1months', $setDate);?>">次の月&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></span></button>
            </form>
        </div>

        <div class="calendar-disp">
            <form action="./day_history.php" method="get">
                <?php
                if(!empty($result)){
                    $i = 0;
                    while($i < count($result)){
                        echo '<button type="submit" class="btn btn-warning" name="date" value="' . $result[$i] . '">' . date('j日', $result[$i]) . '</button>';
                        $i++;
                    }
                } else {
                    echo '<div class="txt-color txt-bold txt-center txt-size-25">データがありません。</div>';
                }
                ?>
            </form>
        </div>
        <div class="button-grp">
            <button type="button" class="btn btn-warning btn-back" onclick="history.back();">戻る</button>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $(".drawer").drawer();
        });
    </script>
</body>
</html>

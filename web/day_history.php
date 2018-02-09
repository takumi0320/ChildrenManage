<?php
include '../include/login_check.php';
include '../include/child_check.php';
if(isset($_GET['date'])){
    require_once '../DB/GPSManager.php';
    $GPSM = new GPSManager();
    $setDate = htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8');
    $childID = $_SESSION['ChildID'];
    $date = date("Ymd", $setDate);
    $result = $GPSM->getGPSDataDayList($childID,$date);
}else{
    header('Location: ./statistics.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo date('m月d日の', $setDate);?>行動履歴 | mamoriO</title>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWQzral_efJeXEiz2FYDYAJxnKqxF7j_Y"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/now_style.css">

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
        <h4 class="card-title txt-title"><?php echo date('m月d日の履歴', $setDate);?></h4>

        <div class="col-12 col-height">
            <div class="map-display">
                <div id="map-back"></div>
                <div id="result-msg" class="is-hide txt-bold txt-color txt-size-25 msg-result">No Result.</div>
                <div id="map-canvas"></div>
            </div>
        </div>

        <div class="button-grp">
            <button type="button" class="btn btn-warning" onclick="history.back();">戻る</button>
        </div>
    </div>
    <script>
                var mapFlg = <?php if($result == false){ echo "false"; } else { echo "true"; } ?>;
        $(document).ready(function(){
            $(".drawer").drawer();
            if(mapFlg){
                initMap();
            } else {
                $("#result-msg").removeClass("is-hide");
            }
        });
        function initMap(){
        // キャンパスの要素を取得する
        var canvas = document.getElementById( 'map-canvas' );
        var marker;

        <?php
        if($result != false){
            $cnt = 0;
            $latitudeSum = 0;
            $longitudeSum = 0;
            foreach ($result as $value) {
                echo 'var latlng'. $cnt . ' = new google.maps.LatLng(' . $value->Latitude. ', ' . $value->Longitude . ');';
                $latitudeSum += $value->Latitude;
                $longitudeSum += $value->Longitude;
                $cnt++;
            }

            $latitudeRatio = $latitudeSum / $cnt;
            $longitudeRatio = $longitudeSum / $cnt;

            echo 'var mapCenter = new google.maps.LatLng(' . $latitudeRatio . ', ' . $longitudeRatio . ');';

            echo '//マップオプションの追加
            var mapOptions = {
                zoom: 14 ,
                center: mapCenter ,
                disableDefaultUI: true
            };

            // [canvas]に、[mapOptions]の内容の、地図のインスタンス([map])を作成する
            var map = new google.maps.Map( canvas, mapOptions );
            ';

            unset($value);
            $cnt = 0;
            foreach ($result as $value) {
                echo 'var marker' . $cnt . ' = new google.maps.Marker({
                    position: latlng' . $cnt . ',
                    map: map
                });
                var infoWindow' . $cnt . ' = new google.maps.InfoWindow({
                    content: \'<div class="time-txt-size txt-color txt-bold txt-center">' . date('Y年n月j日', strtotime($value->Day)) . '<br>' . date('G時i分', strtotime($value->Time)) .'</div>\'
                });
                marker' . $cnt . '.addListener(\'click\', function() { // マーカーをクリックしたとき
                   infoWindow' . $cnt . '.open(map, marker' . $cnt . ');
                });
                ';
                $cnt++;
            }
        }
        ?>
    }
   </script>
</body>
</html>

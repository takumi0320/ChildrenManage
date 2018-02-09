<?php
include '../include/login_check.php';
include '../include/child_check.php';
require_once '../DB/GPSManager.php';
$GPSM = new GPSManager();
$childID = $_SESSION['ChildID'];
$today = date('Ymd');
$result = $GPSM->getGPSLastData($childID, $today);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mamoriO</title>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWQzral_efJeXEiz2FYDYAJxnKqxF7j_Y"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/maingrid_style.css">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-height">
                    <div class="main-card-button">
                        <div id="map-back"></div>
                        <div id="result-msg" class="is-hide txt-bold txt-color txt-size-25 msg-result">No Result.</div>
                        <div id="map-canvas"></div>
                        <div class="card-title-map">前回の行動履歴</div>
                    </div>
                </div>
                <div class="col-6 col-height col-left">
                    <div class="sub-left-card-button">
                        <a href="./statistics.php">
                            <div class="card-title">統計を見る</div>
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-height col-right">
                    <div class="sub-right-card-button">
                        <a href="./now.php">
                            <div class="card-title">今どうしてる？</div>
                            <i class="fa fa-street-view" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="sub-right-card-button">
                        <a href="./config.php">
                            <div class="card-title">設定</div>
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
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

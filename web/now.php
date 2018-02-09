<?php
include '../include/login_check.php';
include '../include/child_check.php';
require_once '../DB/GPSManager.php';
$GPSM = new GPSManager();
$childID = $_SESSION['ChildID'];
$today = date('Ymd');
$result = $GPSM->getGPSNowData($childID, $today);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>今なにしてる？ | mamoriO</title>
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
    <script src="../js/sweetalert.min.js"></script>
    <link href="../css/sweetalert.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWQzral_efJeXEiz2FYDYAJxnKqxF7j_Y"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/now_style.css">
    <link rel="stylesheet" href="../css/loading_style.css">

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
    <div class="loading">
        <div class="loading_icon"></div>
    </div>
    <div id="head-blank"></div>
    <div class="card-field">
        <h4 class="card-title txt-title txt-color">今日の現在状況</h4>
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
            setTimeout(mapFlugment ,1000);
        });
        var mapFlugment = function(){
            $(".loading").addClass("is-hide");
            if(mapFlg){
                initMap();
            } else {
                swal("見つかりませんでした。","GPSがONになっていない可能性があります。");
                $("#result-msg").removeClass("is-hide");
            }
        }
        function initMap(){
            // キャンパスの要素を取得する
            var canvas = document.getElementById( 'map-canvas' );
            var marker;

            // 中心の位置座標を指定する
            <?php
            if($result != false){
                echo 'var latlng = new google.maps.LatLng( ' . $result->Latitude . ', ' . $result->Longitude . ' );
                var mapOptions = {
                    zoom: 14 ,
                    center: latlng ,
                    disableDefaultUI: true
                };
                var map = new google.maps.Map( canvas, mapOptions );
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                var infoWindow = new google.maps.InfoWindow({
                    content: \'<div class="time-txt-size txt-color txt-bold txt-center">' . date('Y年n月j日', strtotime($result->Day)) . '<br>' .date('G時i分',strtotime($result->Time)) .'</div>\'
                });
                marker.addListener(\'click\', function() { // マーカーをクリックしたとき
                   infoWindow.open(map, marker);
               });';
           }
           ?>
       }
   </script>
</body>
</html>

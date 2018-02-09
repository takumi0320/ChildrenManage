<?php

    $json_string = file_get_contents('php://input');

    $json_obj = json_decode($json_string,true);

    $GparentID = $json_obj["gparentID"];
    $childID = $json_obj["childID"];
    $date = $json_obj["date"];
    $time = $json_obj["time"];
    $latitude = $json_obj["latitude"];
    $longitude = $json_obj["longitude"];

    require_once "../DB/GPSManager.php";

    $GPSManager = new GPSManager();

    $GPSManager->insertGPS($childID,$GparentID,$date,$time,$latitude,$longitude);

    echo $json_string;
    



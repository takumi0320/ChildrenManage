<?php
    require_once '../DB/DBManager.php';
    require_once '../DB/GPS.php';
    //require_once('debug.php');
    class GPSManager{

        public function insertGPS($childID,$gparentID,$day,$time,$latitude,$longitude){
            $DBM = new DBManager();
            $GPS = new GPS();
            $GPS->ChildID = $childID;
            $GPS->GparentID = $gparentID;
            $GPS->Day = $day;
            $GPS->Time = $time;
            $GPS->Latitude = $latitude;
            $GPS->Longitude = $longitude;
            $DBM->insertGPSInformation($GPS);
        }

        public function getGPSNowData($childID, $today){
            $DBM = new DBManager();
            $retList = $DBM->selectGPSNowData($childID, $today);
            return $retList;
        }
        public function getGPSLastData($childID, $today){
            $DBM = new DBManager();
            $retList = $DBM->selectGPSLastData($childID, $today);
            return $retList;
        }

        public function getGPSDataDayList($childID,$date){
            $DBManager = new DBManager();
            $retList = $DBManager->selectGPSDataDayList($childID,$date);
            return $retList;
        }

        public function getGPSDataMonthList($childID, $date){
            $DBM = new DBManager();
            $retList = $DBM->selectGPSDataMonthList($childID, $date);
            return $retList;
        }
    }
?>

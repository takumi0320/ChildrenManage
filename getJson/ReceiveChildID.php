<?php

    $json_string = file_get_contents('php://input');

    $json_obj = json_decode($json_string,true);

    $parentID = $json_obj["parentID"];

    require_once "../DB/DBManager.php";

    $DBManager = new DBManager();

    $retList = $DBManager->searchChildtInfomationList($parentID);


    $json = array();

    foreach($retList as $data){
        $json[] = array("ChildID"=>$data->ChildID,"ChildName"=>$data->ChildName);
        
    }
    echo json_encode($json);


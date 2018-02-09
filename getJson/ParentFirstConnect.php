<?php

    require_once "../DB/DBManager.php";

    $DBManager = new DBManager();

    $newID = $DBManager->insertGparentIDinfomation();

    echo $newID;

    

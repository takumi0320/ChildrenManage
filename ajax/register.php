<?php
require_once '../DB/AjaxManager.php';
$AM = new AjaxManager();
$parentID = $_POST['ParentID'];
$check = $AM->checkUserDuplication($parentID);
header('Content-type: application/json');
echo json_encode($check); 
?>

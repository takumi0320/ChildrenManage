<?php
require_once '../DB/AjaxManager.php';
$AM = new AjaxManager();
$parentID = $_POST['ParentID'];
$pass = $_POST['Password'];
$result = $AM->checkUserData($parentID, $pass);
header('Content-type: application/json');
echo json_encode($result);
?>
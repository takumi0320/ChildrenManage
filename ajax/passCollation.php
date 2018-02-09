<?php
require_once '../DB/AjaxManager.php';
$AM = new AjaxManager();
$parentID = $_POST['parentID'];
$currentPass = $_POST['currentPass'];
$result = $AM->checkPasswd($parentID, $currentPass);
header('Content-type: application/json');
echo json_encode($result);
?>

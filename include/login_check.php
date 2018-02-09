<?php
session_start();
if(!isset($_SESSION['ParentID']) && !isset($_SESSION['ParentName'])){
	header('Location: ./welecome.php');
}
?>
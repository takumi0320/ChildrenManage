<?php
session_start();
unset($_SESSION['ParentID']);
unset($_SESSION['ParentName']);
unset($_SESSION['ChildID']);
unset($_SESSION['ChildName']);
header('Location: ./welecome.php');
?>
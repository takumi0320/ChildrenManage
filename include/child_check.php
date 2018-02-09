<?php
if(!isset($_SESSION['ChildID']) && !isset($_SESSION['ChildName'])){
	header('Location: ./ChildSelect.php');
	exit();
}
?>
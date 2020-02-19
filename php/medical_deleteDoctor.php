<?php
session_start();
require_once 'dbcontroller.php';
$connection = new DBController();

$data = array();
$status="error";
$errorMsg="Error retrieving information from server";
if(isset($_SESSION['thisDetailID'])){
    $classID = $_SESSION['thisDetailID'];
}

if (!isset($_SESSION['loggedIn'])) {
    $status = "error";
    $errorMsg = "illegal access! You must login!";
} else if (!isset($_SESSION['thisDetailID'])) {
    $status = "error";
    $errorMsg = "You must select a cadet first!";
} else {
    $classDetailID = $_SESSION['thisDetailID'];
    $id = $_POST['DoctorID'];
	
	$sql = "DELETE
			FROM tblPrimaryDoctors
			WHERE fkClassDetailID = $classDetailID
			AND DoctorID = $id";
    
	$data = $connection->runDeleteQuery($sql);
    $status ="ok";
    $errorMsg="";
}
$output = array();
$output['status'] = $status;
$output['errorMsg'] = $errorMsg;
echo json_encode($output);
?>
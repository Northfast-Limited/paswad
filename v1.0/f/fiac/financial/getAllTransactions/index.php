<?php
include_once '../../config/config.php';
$conn = new config;
$updateProfile = new updateProfile;
$returnData = new returnData;

// $conn -> connection();
// $updateProfile -> profileUpdate('katra',1);

$returnData -> returnData();
?>
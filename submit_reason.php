<?php
include 'dbConnection.php'; // make sure $con is your connection variable

$eid = $_POST['eid'];
$reason = $_POST['reason'];

// Sanitize input
$eid = mysqli_real_escape_string($con, $eid);
$reason = mysqli_real_escape_string($con, $reason);

// Optional: get student email from session
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'unknown';

$query = "INSERT INTO blocked_reasons (eid, email, reason, submitted_at)
          VALUES ('$eid', '$email', '$reason', NOW())";
mysqli_query($con, $query);
?>

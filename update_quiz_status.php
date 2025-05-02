<?php
include 'dbConnection.php'; // Include your database connection file

$eid = $_POST['eid'];
$email = $_POST['email'];

// Check if a record already exists
$query = "SELECT * FROM quiz_status WHERE eid='$eid' AND email='$email'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
  // Update the existing record
  $updateQuery = "UPDATE quiz_status SET disqualified=1, disqualified_at=NOW() WHERE eid='$eid' AND email='$email'";
  mysqli_query($con, $updateQuery) or die('Error updating quiz status');
} else {
  // Insert a new record
  $insertQuery = "INSERT INTO quiz_status (eid, email, disqualified, disqualified_at) VALUES ('$eid', '$email', 1, NOW())";
  mysqli_query($con, $insertQuery) or die('Error inserting quiz status');
}
?>

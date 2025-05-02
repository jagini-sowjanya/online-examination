<?php
include 'dbConnection.php';  // Ensure you have the DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eid = $_POST['eid'];
    $email = $_POST['student_email'];
    $action = $_POST['action'];

    // Check if the action is "accept"
    if ($action == "accept") {
        // Delete the corresponding blocked quiz from the blocked_quizzes table
        mysqli_query($con, "DELETE FROM blocked_quizzes WHERE eid='$eid' AND email='$email'");

        // Optionally, you can add other logic here, like updating a status or performing additional actions

        // Example: updating the blocked_reasons table status (if needed)
        mysqli_query($con, "DELETE FROM blocked_reasons WHERE eid='$eid' AND email='$email'");
    }else{
        echo "<script> alert('Reason rejected'); window.location.href = 'dash.php'; </script>";
        mysqli_query($con, "DELETE FROM blocked_reasons WHERE eid='$eid' AND email='$email'");
exit();

    }

    // Redirect back to the teacher's dashboard after processing
    header("Location: dash.php");
    exit();
}
?>

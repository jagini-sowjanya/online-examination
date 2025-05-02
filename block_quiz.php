<?php
session_start();
include("dbConnection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['eid']) && isset($_SESSION['email'])) {
    $eid = $_POST['eid'];
    $student_email = $_SESSION['email'];

    // Insert into blocked_quizzes if not already blocked
    $stmt = $con->prepare("INSERT IGNORE INTO blocked_quizzes (email, eid) VALUES (?, ?)");
    $stmt->bind_param("ss", $student_email, $eid);
    $stmt->execute();
    $stmt->close();

    // Get teacher's email and quiz title
    $stmt2 = $con->prepare("SELECT email, title FROM quiz WHERE eid = ?");
    $stmt2->bind_param("s", $eid);
    $stmt2->execute();
    $stmt2->bind_result($teacher_email, $quiz_title);
    $stmt2->fetch();
    $stmt2->close();

    // Get student's reason
    $reason = '';
    $stmt3 = $con->prepare("SELECT reason FROM blocked_reasons WHERE eid = ? AND email = ?");
    $stmt3->bind_param("ss", $eid, $student_email);
    $stmt3->execute();
    $stmt3->bind_result($reason);
    $stmt3->fetch();
    $stmt3->close();

    // Send email to teacher
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sravanpotnuru24@gmail.com'; // 🔁 Your Gmail 
        $mail->Password   = 'ddnq gucs iduu uaow';       // 🔁 Gmail App Password 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('sravanpotnuru24@gmail.com', 'Online Exam System');
        $mail->addAddress($teacher_email);

        $mail->isHTML(true);
        $mail->Subject = 'Student Blocked for Tab Switch';
        $mail->Body    = "
            Dear Instructor,<br><br>
            The student with email <b>$student_email</b> has been blocked for switching tabs during the quiz titled <b>$quiz_title</b> (EID: $eid).<br><br>
            <b>Reason submitted by the student:</b><br>
            <i>$reason</i><br><br>
            Regards,<br>
            Online Exam System";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }
}
?>

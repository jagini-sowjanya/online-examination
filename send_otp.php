<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Manually include the PHPMailer classes
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$email = $_POST['email'];
$otp = rand(100000, 999999);
$_SESSION['signup_otp'] = $otp;
$_SESSION['signup_email'] = $email;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sravanpotnuru24@gmail.com'; // 🔁 Replace
    $mail->Password   = 'ddnq gucs iduu uaow';     // 🔁 Replace with Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('sravanpotnuru24@gmail.com', 'Online Exam System');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'OTP for Verification';
    $mail->Body    = 'Your OTP is: <b>' . $otp . '</b>';

    $mail->send();
    echo 'OTP sent to your email.';
} catch (Exception $e) {
    echo "Failed to send OTP. Error: {$mail->ErrorInfo}";
}
?>

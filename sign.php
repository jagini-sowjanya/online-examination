<?php
include_once 'dbConnection.php';
session_start();  // don't remove or move this
ob_start();
$name = $_POST['name'];
$name= ucwords(strtolower($name));
$gender = $_POST['gender'];
$email = $_POST['email'];
$college = $_POST['college'];
$mob = $_POST['mob'];
$password = $_POST['password'];
$password = md5($password);
$otp_input = $_POST['otp'];


if (!isset($_SESSION['signup_otp'])) {
    header("location:index.php?q7=OTP not sent. Please request OTP.");
    exit();
}
// alert('Entered OTP: " . $_POST['otp'] . "\\nSession OTP: " . $_SESSION['signup_otp'] . "');
if ($_POST['otp'] != $_SESSION['signup_otp']) {
    echo "<script>
        window.location.href = 'index.php?q7=Invalid OTP entered. Please try again.';
    </script>";
    exit();
}

// if ($_POST['otp'] !== $_SESSION['signup_otp']) {
//     header("location:index.php?q7=Invalid OTP entered. Please try again.");
//     exit();
// }


try {
    $q3 = mysqli_query($con, "INSERT INTO user VALUES ('$name', '$gender', '$college', '$email', '$mob', '$password')");

    $_SESSION["email"] = $email;
    $_SESSION["name"] = $name;
    unset($_SESSION['signup_otp']);
    header("location:account.php?q=1");

} catch (mysqli_sql_exception $e) {
    if (str_contains($e->getMessage(), 'Duplicate entry')) {
        echo "<script>alert('Email already registered!'); window.location.href='index.php';</script>";
        exit();
    } else {
        die("Error: " . $e->getMessage());
    }
}

// $q3=mysqli_query($con,"INSERT INTO user VALUES  ('$name' , '$gender' , '$college','$email' ,'$mob', '$password')");

// if ($q3) {
//     $_SESSION["email"] = $email;
//     $_SESSION["name"] = $name;
//     unset($_SESSION['signup_otp']);  // only clear on successful sign up
//     header("location:account.php?q=1");
// }

// else
// {
// header("location:index.php?q7=Email Already Registered!!!");
// }
ob_end_flush();
?>



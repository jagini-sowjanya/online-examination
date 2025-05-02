
<?php
include_once 'dbConnection.php';
$ref=@$_GET['q'];
//$name = $_POST['name'];
//$name= ucwords(strtolower($name));
//$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];


$q=mysqli_query($con, "INSERT INTO admin VALUES ('$email', '$password', 'admin')");


if ($q) {
    echo "<script>
        alert('Successfully registered');
        window.location.href = '$ref?q=Successfully registered';
    </script>";
} else {
    echo "<script>
        alert('Registration failed');
        window.location.href = '$ref?q=Registration failed';
    </script>";
}


?>
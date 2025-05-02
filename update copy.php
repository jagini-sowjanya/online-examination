<?php
include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
//delete feedback
if(isset($_SESSION['key'])){
if(@$_GET['fdid'] && $_SESSION['key']=='p') {
$id=@$_GET['fdid'];
$result = mysqli_query($con,"DELETE FROM feedback WHERE id='$id' ") or die('Error');
header("location:headdash.php?q=3");
}
}

//delete user
if(isset($_SESSION['key'])){
if(@$_GET['demail'] && $_SESSION['key']=='person') {
$demail=@$_GET['demail'];
$r1 = mysqli_query($con,"DELETE FROM rank WHERE email='$demail' ") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM history WHERE email='$demail' ") or die('Error');
$result = mysqli_query($con,"DELETE FROM user WHERE email='$demail' ") or die('Error');
header("location:headdash.php?q=1");
}
}

//delete admin

if(isset($_SESSION['key'])){
if(@$_GET['demail1'] && $_SESSION['key']=='person') {
$demail1=@$_GET['demail1'];

$result = mysqli_query($con,"DELETE FROM admin WHERE email='$demail1' and role ='admin' ") or die('Error');
header("location:headdash.php?q=5");
}
}



//remove quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'rmquiz' && $_SESSION['key']=='person') {
$eid=@$_GET['eid'];
$result = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid'") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$qid = $row['qid'];
$r1 = mysqli_query($con,"DELETE FROM options WHERE qid='$qid'") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM answer WHERE qid='$qid' ") or die('Error');
}
$r3 = mysqli_query($con,"DELETE FROM questions WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM quiz WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM history WHERE eid='$eid' ") or die('Error');

header("location:dash.php?q=5");
}
}

//add quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'addquiz' && $_SESSION['key']=='person') {
$name = $_POST['name'];
$name= ucwords(strtolower($name));
$total = $_POST['total'];
$sahi = $_POST['right'];
$wrong = $_POST['wrong'];
$time = $_POST['time'];
$tag = $_POST['tag'];
$desc = $_POST['desc'];
$id=uniqid();
// sravan changes
$start_time = $_POST['start_time']; // e.g., 2025-04-23T14:30
$end_time = $_POST['end_time'];     // e.g., 2025-04-23T15:30
$q3=mysqli_query($con,"INSERT INTO quiz VALUES  ('$id','$name' , '$sahi' , '$wrong','$total','$time' ,'$desc','$tag', NOW() ,'$email','$start_time','$end_time')");

header("location:dash.php?q=4&step=2&eid=$id&n=$total");
}
}

//add question
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'addqns' && $_SESSION['key']=='person') {
$n=@$_GET['n'];
$eid=@$_GET['eid'];
$ch=@$_GET['ch'];

for($i=1;$i<=$n;$i++)
 {
 $qid=uniqid();
 $qns=$_POST['qns'.$i];
$q3=mysqli_query($con,"INSERT INTO questions VALUES  ('$eid','$qid','$qns' , '$ch' , '$i')");
  $oaid=uniqid();
  $obid=uniqid();
$ocid=uniqid();
$odid=uniqid();
$a=$_POST[$i.'1'];
$b=$_POST[$i.'2'];
$c=$_POST[$i.'3'];
$d=$_POST[$i.'4'];
$qa=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$a','$oaid')") or die('Error61');
$qb=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$b','$obid')") or die('Error62');
$qc=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$c','$ocid')") or die('Error63');
$qd=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$d','$odid')") or die('Error64');
$e=$_POST['ans'.$i];
switch($e)
{
case 'a':
$ansid=$oaid;
break;
case 'b':
$ansid=$obid;
break;
case 'c':
$ansid=$ocid;
break;
case 'd':
$ansid=$odid;
break;
default:
$ansid=$oaid;
}


$qans=mysqli_query($con,"INSERT INTO answer VALUES  ('$qid','$ansid')");

 }
header("location:dash.php?q=0");
}
}

//sravan changes
//add lab exam

if (isset($_SESSION['key'])) {
  if (@$_GET['q'] == 'addlabexam' && $_SESSION['key'] == 'person') {
    $lab_name = $_POST['lab_name'];
    $lab_name = ucwords(strtolower($lab_name));
    $total = $_POST['total'];
    $right = $_POST['right'];
    $duration = $_POST['duration'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $desc = $_POST['desc'];
    $id = uniqid();

    $q = mysqli_query($con, "INSERT INTO lab_exam (eid, lab_name, total, `right`, duration, start_time, end_time, description, date, email) 
  VALUES ('$id', '$lab_name', '$total', '$right', '$duration', '$start_time', '$end_time', '$desc', NOW(), '$email')");


    header("location:dash.php?q=6&step=2&eid=$id&n=$total");
  }
}

//add lab question
if(isset($_SESSION['key'])){
  if(@$_GET['q']== 'addlabqns' && $_SESSION['key']=='person') {
  $n=@$_GET['n'];
  $eid=@$_GET['eid'];
  
  
  for($i=1;$i<=$n;$i++)
   {
   $qid=uniqid();
   $qns=$_POST['qns'.$i];
  $q3=mysqli_query($con,"INSERT INTO labquestions VALUES  ('$eid','$qid','$qns', '$i')");
  
   }
  header("location:dash.php?q=0");
  }
  }

//submit lab question


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (@$_GET['q'] == 'labquiz' && @$_GET['step'] == 3) {
    $eid = $_GET['eid'];
    $sn = $_GET['n'];
    $email = $_SESSION['email'];
    $language = $_POST['language'];
    $code = $_POST['code'];

    // Escape code to prevent SQL injection
    $code_escaped = mysqli_real_escape_string($con, $code);

    // Insert into lab_submissions
    $insert = mysqli_query($con, "INSERT INTO lab_submissions (eid, email, question_no, language, code, submitted_at) VALUES ('$eid', '$email', '$sn', '$language', '$code_escaped', NOW())");

    if ($insert) {
        // Fetch question
        $q = mysqli_query($con, "SELECT qns FROM labquestions WHERE eid='$eid' AND sn='$sn' LIMIT 1");
        $row = mysqli_fetch_assoc($q);
        $question = $row['qns'];

        // Get teacher info
        $getTeacher = mysqli_query($con, "SELECT email, lab_name FROM lab_exam WHERE eid='$eid' LIMIT 1");
        $labRow = mysqli_fetch_assoc($getTeacher);
        $teacher_email = $labRow['email'];
        $lab_name = $labRow['lab_name'];

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sravanpotnuru24@gmail.com'; // your Gmail
            $mail->Password   = 'ddnq gucs iduu uaow';       // Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('sravanpotnuru24@gmail.com', 'Online Exam System');
            $mail->addAddress($teacher_email);

            $mail->isHTML(true);
            $mail->Subject = "Lab Submission from $email for '$lab_name'";
            $mail->Body    = "
                <h3>Lab Submission Details</h3>
                <b>Lab Name:</b> $lab_name<br>
                <b>Lab ID:</b> $eid<br>
                <b>Question No:</b> $sn<br>
                <b>Question:</b> $question<br>
                <b>Submitted By:</b> $email<br>
                <b>Language:</b> $language<br><br>
                <b>Submitted Code:</b><br>
                <pre style='background:#f4f4f4;border:1px solid #ddd;padding:10px;font-family:monospace;'>"
                . htmlspecialchars($code) .
                "</pre>
            ";

            $mail->send();
            header("Location: account.php?q=labquiz_success&msg=Submitted and emailed to the teacher.");
            exit();
        } catch (Exception $e) {
            echo "Failed to send mail. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error submitting answer to database.";
    }
}


//quiz start
if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
$eid=@$_GET['eid'];
$sn=@$_GET['n'];
$total=@$_GET['t'];
$ans=$_POST['ans'];
$qid=@$_GET['qid'];
$q=mysqli_query($con,"SELECT * FROM answer WHERE qid='$qid' " );
while($row=mysqli_fetch_array($q) )
{
$ansid=$row['ansid'];
}
if($ans == $ansid)
{
$q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " );
while($row=mysqli_fetch_array($q) )
{
$sahi=$row['sahi'];
}
if($sn == 1)
{
$q=mysqli_query($con,"INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW())")or die('Error');
}
$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email' ")or die('Error115');

while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$r=$row['sahi'];
}
$r++;
$s=$s+$sahi;
$q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`sahi`=$r, date= NOW()  WHERE  email = '$email' AND eid = '$eid'")or die('Error124');

} 
else
{
$q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error129');

while($row=mysqli_fetch_array($q) )
{
$wrong=$row['wrong'];
}
if($sn == 1)
{
$q=mysqli_query($con,"INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW() )")or die('Error137');
}
$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email' " )or die('Error139');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$w=$row['wrong'];
}
$w++;
$s=$s-$wrong;
$q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE  email = '$email' AND eid = '$eid'")or die('Error147');
}
if($sn != $total)
{
$sn++;
header("location:account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total")or die('Error152');
}
else if( $_SESSION['key']!='person')
{
$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
$rowcount=mysqli_num_rows($q);
if($rowcount == 0)
{
$q2=mysqli_query($con,"INSERT INTO rank VALUES('$email','$s',NOW())")or die('Error165');
}
else
{
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$s+$sun;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
}
header("location:account.php?q=result&eid=$eid");
}
else
{
header("location:account.php?q=result&eid=$eid");
}
}

//restart quiz
if(@$_GET['q']== 'quizre' && @$_GET['step']== 25 ) {
$eid=@$_GET['eid'];
$n=@$_GET['n'];
$t=@$_GET['t'];
$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"DELETE FROM `history` WHERE eid='$eid' AND email='$email' " )or die('Error184');
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$sun-$s;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
header("location:account.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
}



?>




<!DzOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- sravan changes -->
<?php date_default_timezone_set('Asia/Kolkata') ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Online examiner</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>
<!-- Your Start button -->

<?php
 include_once 'dbConnection.php';
session_start();
  if(!(isset($_SESSION['email']))){
header("location:index.php");
}
else
{
$name = $_SESSION['name'];
$email=$_SESSION['email'];
include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Welcome,</span> <a href="account.php?q=1" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>
<script>


// Detect when the user tries to leave the current tab
// Get the full URL of the current page
const urlParams = new URLSearchParams(window.location.search);
const paramValue = urlParams.get('step'); // Read step value from query
let switchCount = 0;
const maxSwitches = 4;
let ignoreNextHidden = false;

// Prevent false positives on form submits or page navigation
document.querySelectorAll("form").forEach(form => {
  form.addEventListener("submit", () => {
    ignoreNextHidden = true;
  });
});
window.addEventListener("beforeunload", () => {
  ignoreNextHidden = true;
});

document.addEventListener("visibilitychange", function () {
  if (document.visibilityState === "hidden" && paramValue == 2) {
    if (ignoreNextHidden) {
      ignoreNextHidden = false;
      return;
    }

    switchCount++;
    alert(`Warning: You have switched tabs! ${switchCount} time(s). This may affect your test attempt.`);

    const quizId = urlParams.get('eid');
    if (switchCount >= maxSwitches) {
      alert("You have switched tabs too many times. Your test may be invalidated.");

      // fetch("block_quiz.php", {
      //   method: "POST",
      //   headers: { "Content-Type": "application/x-www-form-urlencoded" },
      //   body: `eid=${encodeURIComponent(quizId)}`
      // }).then(() => {
      //   // window.location.href = "account.php?q=1";
      //   const reasonForm = document.createElement("div");
      //   reasonForm.innerHTML = `
      //     <div style="padding: 20px; background: #fff; border: 1px solid #ccc;">
      //       <h3>Your test has been blocked.</h3>
      //       <p>Please enter a reason for switching tabs:</p>
      //       <textarea id="reasonInput" rows="4" style="width: 100%;"></textarea><br><br>
      //       <button onclick="submitReason()">Submit Reason</button>
      //     </div>
      //   `;
      //   document.body.innerHTML = "";
      //   document.body.appendChild(reasonForm);
      // });
      const reasonForm = document.createElement("div");
  reasonForm.innerHTML = `
    <div style="padding: 20px; background: #fff; border: 1px solid #ccc;">
      <h3>Your test has been blocked.</h3>
      <p>Please enter a reason for switching tabs:</p>
      <textarea id="reasonInput" rows="4" style="width: 100%;"></textarea><br><br>
      <button onclick="submitReason('${quizId}')">Submit Reason</button>
    </div>
  `;
  document.body.innerHTML = "";
  document.body.appendChild(reasonForm);
    }
  }
});

</script>
<!--quiz termination code-->
<script>
// Check if the quiz is disqualified and disable the Start button
window.onload = function() {
    const disqualified = localStorage.getItem("quizDisqualified");
    if (disqualified === "true") {
        const startButtons = document.querySelectorAll(".startButton");
        startButtons.forEach(button => {
            button.style.pointerEvents = "none"; // Disable clicking
            button.style.opacity = "0.5"; // Make the button look disabled
        });
    }
};
</script>

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
 <!--alert message-->
<?php if(@$_GET['w'])
{echo'<script>alert("'.@$_GET['w'].'");</script>';}
?>
<!--alert message end-->

</head>
<?php
include_once 'dbConnection.php';
?>
<body>
<div class="header">
<div class="row" style="background-color:#f4511e;">
<div class="col-lg-6" >
<span class="logo"></span></div>
<div class="col-md-4 col-md-offset-2">
 
</div>
</div></div>
<div class="bg">
<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="account.php?q=1"><b>Dashboard - Student</b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar left">
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?> ><a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="account.php?q=2"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;History</a></li>
    <li <?php if(@$_GET['q']==3) echo'class="active"'; ?>><a href="account.php?q=3"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Ranking</a></li>
    
  </ul>
  </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav><!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">


 



<!-- sravanchanges -->

<!--home start-->
<?php
if(@$_GET['q'] == 1) {
  $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
  echo '<div class="panel"><table class="table table-striped title1">
  <tr style="color:black"><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>positive</b></td><td><b>negative</b></td><td><b>Time limit</b></td><td><b>Start time</b></td><td><b>End time</b></td><td><b>Created By</b></td><td></td><td></td></tr>';
  
  $c = 1;
  while ($row = mysqli_fetch_array($result)) {
    $title = $row['title'];
    $total = $row['total'];
    $sahi = $row['sahi'];
    $wrong = $row['wrong'];
    $time = $row['time'];
    $eid = $row['eid'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
    $current_time = date("Y-m-d H:i:s");
    $teacher_mail = $row['email'];
    
    $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
    $rowcount = mysqli_num_rows($q12);
    
    $checkBlocked = mysqli_query($con, "SELECT * FROM blocked_quizzes WHERE email='$_SESSION[email]' AND eid='$eid'");
    if (mysqli_num_rows($checkBlocked) > 0) {
      echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td><td>'.$start_time.'</td><td>'.$end_time.'</td><td>'.$teacher_mail.'</td>
      <td><a title="Open quiz description" href="account.php?q=1&fid=' . $eid . '"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>
      <td><b><a class="pull-right btn sub1 disabled" style="margin:0px;background:gray;pointer-events: none; cursor: default;"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Blocked</b></span></a></b></td></tr>';
    }else{
      


      if ($rowcount == 0) {
        echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . ($sahi * $total) . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td><td>'.$start_time.'</td><td>'.$end_time.'</td><td>'.$teacher_mail.'</td>
        <td><a title="Open quiz description" href="account.php?q=1&fid=' . $eid . '"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
        
        if ($current_time >= $start_time && $current_time <= $end_time) {
          echo '<td><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn sub1" style="margin:0px;background:#99cc32" id="startButton"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
        } else {
          echo '<td><b><a class="pull-right btn sub1 disabled" style="margin:0px;background:gray;pointer-events: none; cursor: default;"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
        }
      }
       else {
      echo '<tr style="color:#99cc32"><td>' . $c++ . '</td><td>' . $title . '&nbsp;<span title="This quiz is already solved by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td><td>'.$start_time.'</td><td>'.$end_time.'</td></tr>';
    }
  }
}
  $c = 0;
  echo '</table></div>';

  // Display Lab Exams
$result_lab = mysqli_query($con, "SELECT * FROM lab_exam ORDER BY date DESC") or die('Error');
echo '<br><div class="panel"><span class="title1" style="margin-left:40%;font-size:25px;"><b>Lab Questions</b></span><br /><br />';
echo '<table class="table table-striped title1">
<tr style="color:black"><td><b>S.N.</b></td><td><b>Lab Name</b></td><td><b>Total Questions</b></td><td><b>Total Marks</b></td><td><b>Marks/Qn</b></td><td><b>Duration</b></td><td><b>Start time</b></td><td><b>End time</b></td><td><b>Created By</b></td><td></td><td></td></tr>';

$c = 1;
while ($row_lab = mysqli_fetch_array($result_lab)) {
    $lab_name = $row_lab['lab_name'];
    $total = $row_lab['total'];
    $right = $row_lab['right'];
    $duration = $row_lab['duration'];
    $start_time = $row_lab['start_time'];
    $end_time = $row_lab['end_time'];
    $eid = $row_lab['eid'];
    $current_time = date("Y-m-d H:i:s");

    $q12_lab = mysqli_query($con, "SELECT eid FROM lab_submissions WHERE eid='$eid' AND email='$email'") or die('Error98');
    $rowcount_lab = mysqli_num_rows($q12_lab);
    $checkBlockedLab = mysqli_query($con, "SELECT * FROM blocked_quizzes WHERE email='$_SESSION[email]' AND eid='$eid'");

    if (mysqli_num_rows($checkBlockedLab) > 0) {
        echo '<tr><td>' . $c++ . '</td><td>' . $lab_name . '</td><td>' . $total . '</td><td>' . $right * $total . '</td><td>' . $right . '</td><td>' . $duration . '&nbsp;min</td><td>'.$start_time.'</td><td>'.$end_time.'</td><td>'.$teacher_mail.'</td>
        <td><a title="Open lab description" href="account.php?q=1&fid=' . $eid . '"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>
        <td><b><a class="pull-right btn sub1 disabled" style="margin:0px;background:gray;pointer-events: none; cursor: default;"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Blocked</b></span></a></b></td></tr>';
    } else {
        if ($rowcount_lab == 0) {
            echo '<tr><td>' . $c++ . '</td><td>' . $lab_name . '</td><td>' . $total . '</td><td>' . $right * $total . '</td><td>' . $right . '</td><td>' . $duration . '&nbsp;min</td><td>'.$start_time.'</td><td>'.$end_time.'</td><td>'.$teacher_mail.'</td>
            <td><a title="Open lab description" href="account.php?q=1&fid=' . $eid . '"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
            if ($current_time >= $start_time && $current_time <= $end_time) {
                echo '<td><b><a href="account.php?q=labquiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn sub1" style="margin:0px;background:#99cc32"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
            } else {
                echo '<td><b><a class="pull-right btn sub1 disabled" style="margin:0px;background:gray;pointer-events: none; cursor: default;"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
            }
        } else {
            echo '<tr style="color:#99cc32"><td>' . $c++ . '</td><td>' . $lab_name . '&nbsp;<span title="This lab is already solved by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>' . $total . '</td><td>' . $right * $total . '</td><td>' . $right . '</td><td>' . $duration . '&nbsp;min</td></tr>';
        }
    }
}
echo '</table></div>';
}



?>

<!-- <script>
  // JavaScript to enable/disable all Start buttons based on time
  window.onload = function() {
    const startButtons = document.querySelectorAll("#startButton");
    const now = new Date();
    const currentHour = now.getHours();

    // Enable the buttons only if the current time is between 9 AM and 10 AM
    if (currentHour >= 17 && currentHour < 24) {
      startButtons.forEach(button => {
        button.style.pointerEvents = "auto";
        button.style.opacity = "1";
      });
    } else {
      startButtons.forEach(button => {
        button.style.pointerEvents = "none"; // Disable clicking
        button.style.opacity = "0.5"; // Make the button look disabled
      });
    }
  };
</script> -->

<!--home end -->
<!----quiz reading portion starts--->

<?php if(@$_GET['fid']) {
echo '<br />';
$eid=@$_GET['fid'];
$result = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' ") or die('Error');
while($row = mysqli_fetch_array($result)) {
 // $name = $row['name'];
  $title = $row['title'];
  $date = $row['date'];
  $date= date("d-m-Y",strtotime($date));
  //$time = $row['time'];
  $intro = $row['intro'];
  
echo '<div class="panel"<a title="Back to Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Ubuntu", sans-serif;"><b>'.$title.'</b></h1>';
 echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;'.$date.'</span>
<span style="line-height:35px;padding:5px;"></span><br />'.$intro.'</div></div>';}
}?>
<!--quiz reading portion closed-->

<!--<span id="countdown" class="timer"></span>
<script>
var seconds = 40;
    function secondPassed() {
    var minutes = Math.round((seconds - 30)/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    document.getElementById('countdown').innerHTML = minutes + ":" +    remainingSeconds;
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Buzz Buzz";
    } else {    
        seconds--;
    }
    }
var countdownTimer = setInterval('secondPassed()', 1000);
</script>-->

<!--home closed-->

<!--quiz start-->
<?php
if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
$eid=@$_GET['eid'];
$sn=@$_GET['n'];
$total=@$_GET['t'];
$q=mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' " );
echo '<div class="panel" style="margin:5%">';
while($row=mysqli_fetch_array($q) )
{
$qns=$row['qns'];
$qid=$row['qid'];
echo '<b>Question &nbsp;'.$sn.'&nbsp;::<br />'.$qns.'</b><br /><br />';
}
$q=mysqli_query($con,"SELECT * FROM options WHERE qid='$qid' " );
echo '<form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST"  class="form-horizontal">
<br />'
;

while($row=mysqli_fetch_array($q) )
{
$option=$row['option'];
$optionid=$row['optionid'];
echo'<input type="radio" name="ans" value="'.$optionid.'">'.$option.'<br /><br />';
}
echo'<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;Submit</button></form></div>';
//header("location:dash.php?q=4&step=2&eid=$id&n=$total");
}
//result display
if(@$_GET['q']== 'result' && @$_GET['eid']) 
{
$eid=@$_GET['eid'];
$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email' " )or die('Error157');
echo  '<div class="panel">
<center><h1 class="title" style="color:#660033">Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$w=$row['wrong'];
$r=$row['sahi'];
$qa=$row['level'];
echo '<tr style="color:#66CCFF"><td>Total Questions</td><td>'.$qa.'</td></tr>
      <tr style="color:#99cc32"><td>right Answer&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>'.$r.'</td></tr> 
    <tr style="color:red"><td>Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>'.$w.'</td></tr>
    <tr style="color:#66CCFF"><td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>'.$s.'</td></tr>';
}
$q=mysqli_query($con,"SELECT * FROM rank WHERE  email='$email' " )or die('Error157');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
echo '<tr style="color:#990000"><td>Overall Score&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>'.$s.'</td></tr>';
}
echo '</table></div>';

}
?>
<!--quiz end-->
<?php
//history start
if(@$_GET['q']== 2) 
{
$q=mysqli_query($con,"SELECT * FROM history WHERE email='$email' ORDER BY date DESC " )or die('Error197');
echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:black"><td><b>S.N.</b></td><td><b>Quiz</b></td><td><b>Question Solved</b></td><td><b>Right</b></td><td><b>Wrong<b></td><td><b>Score</b></td>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$eid=$row['eid'];
$s=$row['score'];
$w=$row['wrong'];
$r=$row['sahi'];
$qa=$row['level'];
$q23=mysqli_query($con,"SELECT title FROM quiz WHERE  eid='$eid' " )or die('Error208');
while($row=mysqli_fetch_array($q23) )
{
$title=$row['title'];
}
$c++;
echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
}
echo'</table></div>';
}

//ranking start
if(@$_GET['q']== 3) 
{
$q=mysqli_query($con,"SELECT * FROM rank  ORDER BY score DESC " )or die('Error223');
echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:black"><td><b>Rank</b></td><td><b>Name</b></td><td><b>Gender</b></td><td><b>College</b></td><td><b>Score</b></td></tr>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$e=$row['email'];
$s=$row['score'];
$q12=mysqli_query($con,"SELECT * FROM user WHERE email='$e' " )or die('Error231');
while($row=mysqli_fetch_array($q12) )
{
$name=$row['name'];
$gender=$row['gender'];
$college=$row['college'];
}
$c++;
echo '<tr><td style="color:#99cc32"><b>'.$c.'</b></td><td>'.$name.'</td><td>'.$gender.'</td><td>'.$college.'</td><td>'.$s.'</td><td>';
}
echo '</table></div>';}


?>


<!-- lab quiz start -->
<?php
if (@$_GET['q'] == 'labquiz' && @$_GET['step'] == 2) {
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];

    $q = mysqli_query($con, "SELECT * FROM labquestions WHERE eid='$eid' AND sn='$sn'");
    echo '<div class="panel" style="margin:5%">';
    while ($row = mysqli_fetch_array($q)) {
        $qns = $row['qns'];
        $qid = $row['qid'];
        echo '<b>Question &nbsp;' . $sn . '&nbsp;::<br />' . $qns . '</b><br /><br />';
    }

    // Code editor form
    echo '
    <form action="update.php?q=labquiz&step=3&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '" method="POST">
        <div class="form-group">
            <label for="language">Select Language:</label>
            <select name="language" class="form-control" required>
                <option value="c">C</option>
                <option value="cpp">C++</option>
                <option value="java">Java</option>
                <option value="python">Python</option>
            </select>
        </div>
        <div class="form-group">
            <label for="code">Write your code here:</label>
            <textarea name="code" rows="15" class="form-control" required placeholder="Type your solution here..."></textarea>
        </div>
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;Submit</button>
    </form>
    </div>';
}
?>


</div></div></div></div>
<script>
 function submitReason(quizId) {
  const reason = document.getElementById("reasonInput").value;

  // First, submit the reason
  fetch("submit_reason.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `eid=${encodeURIComponent(quizId)}&reason=${encodeURIComponent(reason)}`
  })
  .then(response => {
    if (response.ok) {
      // After storing the reason, block the quiz
      return fetch("block_quiz.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `eid=${encodeURIComponent(quizId)}`
      });
    } else {
      alert("Failed to submit your reason.");
    }
  })
  .then(response => {
    if (response.ok) {
      // Show success alert
      alert("Your request and reason have been sent to the instructor.");
      // Redirect to the account page after a short delay
      setTimeout(() => {
        window.location.href = "account.php?q=1";
      }, 2000);  // Delay 2 seconds for better UX
    } else {
      alert("Failed to block the quiz.");
    }
  });
}
</script>
</body>
</html>
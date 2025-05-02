<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

<script>
$(function () {
    $(document).on( 'scroll', function(){
        console.log('scroll top : ' + $(window).scrollTop());
        if($(window).scrollTop()>=$(".logo").height())
        {
             $(".navbar").addClass("navbar-fixed-top");
        }

        if($(window).scrollTop()<$(".logo").height())
        {
             $(".navbar").removeClass("navbar-fixed-top");
        }
    });
});</script>
</head>

<body  style="background:#eee;">
  <div class="header">
<div class="row">
<div class="col-lg-6">
</div>
<?php
include_once 'dbConnection.php';
session_start();
$email = $_SESSION['email'];
if (!(isset($_SESSION['email']))) {
    header("location:index.php");
} else {
    $name = $_SESSION['name'];
    include_once 'dbConnection.php';
    echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="dash.php" class="log log1">' . $email . '</a>&nbsp;|&nbsp;<a href="logout.php?q=dash.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
} ?>

</div></div>
<!-- admin start-->

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
      <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard - TEACHER</b></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if (@$_GET['q'] == 0) echo 'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
        <li <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?>><a href="dash.php?q=1">Scores</a></li>  
		<li <?php if (@$_GET['q'] == 2) echo 'class="active"'; ?>><a href="dash.php?q=2">Ranking</a></li>
		<li <?php if (@$_GET['q'] == 3) echo 'class="active"'; ?>><a href="dash.php?q=3">Feedback</a></li>
        <li class="dropdown <?php if (@$_GET['q'] == 4 || @$_GET['q'] == 5) echo 'active'; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quiz<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dash.php?q=4">Add Quiz</a></li>
            <li><a href="dash.php?q=5">Remove Quiz</a></li>
          </ul>
        </li>
    <li <?php if (@$_GET['q'] == 6) echo 'class="active"'; ?>><a href="dash.php?q=6">Lab Exam</a></li>
      </ul>
          </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">
<!--home start-->

<?php if (@$_GET['q'] == 0) {
    $result = mysqli_query($con, "SELECT * FROM quiz where email='$email' ORDER BY date DESC") or die('Error');
    echo '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>positive</b></td><td><b>negative</b></td><td><b>Time limit</b></td><td><b>Start time</td><td><b>End time</td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $wrong = $row['wrong'];
        $time = $row['time'];
        $eid = $row['eid'];
        $start_time = $row["start_time"];
        $end_time = $row["end_time"];
        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
        $rowcount = mysqli_num_rows($q12);
        if ($rowcount == 0) {
            echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td><td>' . $start_time . '</td><td>' . $end_time . '</td>
	</tr>';
        } else {
            echo '<tr style="color:#99cc32"><td>' . $c++ . '</td><td>' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $time . '&nbsp;min</td>
	</tr>';
        }
    }
    $c = 0;
    echo '</table></div>';
    // Display Lab Exams
    $result_lab = mysqli_query($con, "SELECT * FROM lab_exam WHERE email='$email' ORDER BY date DESC") or die('Error');
    echo '<br><div class="panel"><span class="title1" style="margin-left:40%;font-size:25px;"><b>Lab Questions</b></span><br /><br />';
    echo '<table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Lab Name</b></td><td><b>Total Questions</b></td><td><b>Total Marks</b></td><td><b>Marks per Qn</b></td><td><b>Duration</b></td><td><b>Start Time</b></td><td><b>End Time</b></td></tr>';
    $c = 1;
    while ($row_lab = mysqli_fetch_array($result_lab)) {
        $lab_name = $row_lab['lab_name'];
        $total = $row_lab['total'];
        $right = $row_lab['right'];
        $duration = $row_lab['duration'];
        $start_time = $row_lab['start_time'];
        $end_time = $row_lab['end_time'];
        $eid = $row_lab['eid'];
        $q12_lab = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
        $rowcount_lab = mysqli_num_rows($q12_lab);
        if ($rowcount_lab == 0) {
            echo '<tr><td>' . $c++ . '</td><td>' . $lab_name . '</td><td>' . $total . '</td><td>' . $right * $total . '</td><td>' . $right . '</td><td>' . $duration . '&nbsp;min</td><td>' . $start_time . '</td><td>' . $end_time . '</td></tr>';
        } else {
            echo '<tr style="color:#99cc32"><td>' . $c++ . '</td><td>' . $lab_name . '&nbsp;<span title="This lab exam is already attempted by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>' . $total . '</td><td>' . $right * $total . '</td><td>' . $right . '</td><td>' . $duration . '&nbsp;min</td><td>' . $start_time . '</td><td>' . $end_time . '</td></tr>';
        }
    }
    $c = 0;
    echo '</table></div>';
    // Get blocked students for this quiz
    $result = mysqli_query($con, "
  SELECT q.*, br.reason , br.email AS blocked_email
  FROM quiz q
  LEFT JOIN blocked_reasons br ON q.eid = br.eid
  WHERE q.email='$email'
  ORDER BY q.date DESC
") or die('Error');
    echo '<br><div class="panel"><span class="title1" style="margin-left:40%;font-size:25px;"><b>Blocked Exams</b></span><br /><br /><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>positive</b></td><td><b>negative</b></td><td><b>Time limit</b></td><td><b>Start time</b></td><td><b>End time</b></td><td><b>Action</b></td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $wrong = $row['wrong'];
        $time = $row['time'];
        $eid = $row['eid'];
        $start_time = $row["start_time"];
        $end_time = $row["end_time"];
        $reason = $row['reason'];
        $email = $row['blocked_email'];
        // Check if the quiz is blocked
        if ($reason) {
            echo '<tr style="background-color: #ffe6e6;"><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td><td>' . $start_time . '</td><td>' . $end_time . '</td>';
            echo '<td><b>Reason:</b><br>' . $reason . '<br><br>
            <form method="POST" action="handle_reason_action.php">
                <input type="hidden" name="eid" value="' . $eid . '">
                <input type="text" name="student_email" value="' . $email . '">
                <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">Accept</button>
                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
            </form></td></tr>';
            // } else {
            //     $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
            //     $rowcount = mysqli_num_rows($q12);
            //     if ($rowcount == 0) {
            //         echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$sahi*$total.'</td><td>'.$sahi.'</td><td>'.$wrong.'</td><td>'.$time.'&nbsp;min</td><td>'.$start_time.'</td><td>'.$end_time.'</td></tr>';
            //     } else {
            //         echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.'&nbsp;<span title="This quiz is already solved by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>'.$total.'</td><td>'.$sahi*$total.'</td><td>'.$time.'&nbsp;min</td></tr>';
            //     }
            
        }
    }
    $c = 0;
    echo '</table></div>';
}
//score details
if (@$_GET['q'] == 1) {
    $q = mysqli_query($con, "SELECT distinct q.title,u.name,u.college,h.score,h.date from user u,history h,quiz q where q.email='$email' and q.eid=h.eid and h.email=u.email order by q.eid DESC") or die('Error197');
    //$q=mysqli_query($con,"SELECT * FROM history WHERE email='$email' ORDER BY date DESC " )or die('Error197');
    echo '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:black"><td><b>S.N.</b></td><td><b>Title</b></td><td><b>Name</b></td><td><b>College</b></td><td><b>Score<b></td><td><b>Date</b></td>';
    $c = 0;
    while ($row = mysqli_fetch_array($q)) {
        $title = $row['title'];
        $name = $row['name'];
        $college = $row['college'];
        $score = $row['score'];
        $date = $row['date'];
        echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $name . '</td><td>' . $college . '</td><td>' . $score . '</td><td>' . $date . '</td></tr>';
    }
    //$q23=mysqli_query($con,"SELECT title FROM quiz WHERE  eid='$eid' " )or die('Error208');
    //while($row=mysqli_fetch_array($q23) )
    //{
    //$title=$row['title'];
    //}
    //$c++;
    //echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
    //}
    echo '</table></div>';
}
//ranking start
if (@$_GET['q'] == 2) {
    $q = mysqli_query($con, "SELECT * FROM rank  ORDER BY score DESC ") or die('Error223');
    echo '<div class="panel title">
<table class="table table-striped title1" >
<tr><td><b>Rank</b></td><td><b>Name</b></td><td><b>Gender</b></td><td><b>College</b></td><td><b>Score</b></td></tr>';
    $c = 0;
    while ($row = mysqli_fetch_array($q)) {
        $e = $row['email'];
        $s = $row['score'];
        $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e' ") or die('Error231');
        while ($row = mysqli_fetch_array($q12)) {
            $name = $row['name'];
            $gender = $row['gender'];
            $college = $row['college'];
        }
        $c++;
        echo '<tr><td style="color:#99cc32"><b>' . $c . '</b></td><td>' . $name . '</td><td>' . $gender . '</td><td>' . $college . '</td><td>' . $s . '</td><td>';
    }
    echo '</table></div>';
}
?>


<!--home closed-->
<!--users start-->



<!--user end-->

<!--feedback start-->

<!--feedback closed-->

<!--feedback reading portion start-->
<?php if (@$_GET['q'] == 3) {
    echo '<br />';
    $id = @$_GET['fid'];
    $result = mysqli_query($con, "SELECT * FROM feedback WHERE id='$id' ") or die('Error');
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $subject = $row['subject'];
        $date = $row['date'];
        $date = date("d-m-Y", strtotime($date));
        $time = $row['time'];
        $feedback = $row['feedback'];
        echo '<div class="panel"<a title="Back to Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Ubuntu", sans-serif;"><b>' . $subject . '</b></h1>';
        echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;' . $date . '</span>
<span style="line-height:35px;padding:5px;">&nbsp;<b>Time:</b>&nbsp;' . $time . '</span><span style="line-height:35px;padding:5px;">&nbsp;<b>By:</b>&nbsp;' . $name . '</span><br />' . $feedback . '</div></div>';
    }
} ?>
<!--Feedback reading portion closed-->

<!--add quiz start-->
<?php
if (@$_GET['q'] == 4 && !(@$_GET['step'])) {
    echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   <form class="form-horizontal title1" name="form" action="update.php?q=addquiz"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name"></label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
    
  </div>
</div>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="total"></label>  
  <div class="col-md-12">
  <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="right"></label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="wrong"></label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="tag"></label>  
  <div class="col-md-12">
  <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Start Time input -->
<div class="form-group">
  <label class="col-md-12 control-label" for="start_time"></label>  
  <div class="col-md-12">
    <input id="start_time" name="start_time" placeholder="Select start time of the quiz" class="form-control input-md" type="datetime-local" required>
  </div>
</div>

<!-- End Time input -->
<div class="form-group">
  <label class="col-md-12 control-label" for="end_time"></label>  
  <div class="col-md-12">
    <input id="end_time" name="end_time" placeholder="Select end time of the quiz" class="form-control input-md" type="datetime-local" required>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="desc"></label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
  </div>
</div>


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>


</fieldset>
</form></div>';
}
?>
<!--add quiz end-->

<!--add quiz step2 start-->
<?php
if (@$_GET['q'] == 4 && (@$_GET['step']) == 2) {
    echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '"  method="POST">
<fieldset>
';
    for ($i = 1;$i <= @$_GET['n'];$i++) {
        echo '<b>Question number&nbsp;' . $i . '&nbsp;:</><br /><!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..."></textarea>  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '1"></label>  
  <div class="col-md-12">
  <input id="' . $i . '1" name="' . $i . '1" placeholder="Enter option a" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '2"></label>  
  <div class="col-md-12">
  <input id="' . $i . '2" name="' . $i . '2" placeholder="Enter option b" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '3"></label>  
  <div class="col-md-12">
  <input id="' . $i . '3" name="' . $i . '3" placeholder="Enter option c" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '4"></label>  
  <div class="col-md-12">
  <input id="' . $i . '4" name="' . $i . '4" placeholder="Enter option d" class="form-control input-md" type="text">
    
  </div>
</div>
<br />
<b>Correct answer</b>:<br />
<select id="ans' . $i . '" name="ans' . $i . '" placeholder="Choose correct answer " class="form-control input-md" >
   <option value="a">Select answer for question ' . $i . '</option>
  <option value="a">option a</option>
  <option value="b">option b</option>
  <option value="c">option c</option>
  <option value="d">option d</option> </select><br /><br />';
    }
    echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';
}
?><!--add quiz step 2 end-->




<!--remove quiz-->
<?php if (@$_GET['q'] == 5) {
    $result = mysqli_query($con, "SELECT * FROM quiz where email='$email' ORDER BY date DESC") or die('Error');
    echo '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $time = $row['time'];
        $eid = $row['eid'];
        echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $time . '&nbsp;min</td>
	<td><b><a href="update.php?q=rmquiz&eid=' . $eid . '" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Remove</b></span></a></b></td></tr>';
    }
    $c = 0;
    echo '</table></div>';
}
?>

<!-- create lab exam -->
<?php if (@$_GET['q'] == 6 && !(@$_GET['step'])) { ?>
<div class="row">
  <span class="title1" style="margin-left:35%;font-size:30px;"><b>Create Lab Examination</b></span><br /><br />
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <form class="form-horizontal title1" name="lab_form" action="update.php?q=addlabexam" method="POST">
      <fieldset>

        <!-- Lab Name -->
        <div class="form-group">
          <label class="col-md-12 control-label" for="lab_name"></label>  
          <div class="col-md-12">
            <input id="lab_name" name="lab_name" placeholder="Enter Lab Name" class="form-control input-md" type="text" required>
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="total"></label>  
          <div class="col-md-12">
          <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
            
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="right"></label>  
          <div class="col-md-12">
          <input id="right" name="right" placeholder="Enter marks on each answer" class="form-control input-md" min="0" type="number">
            
          </div>
        </div>

        <!-- Duration -->
        <div class="form-group">
          <label class="col-md-12 control-label" for="duration"></label>  
          <div class="col-md-12">
            <input id="duration" name="duration" placeholder="Enter time limit for test in minute" class="form-control input-md" type="number" required>
          </div>
        </div>

        <!-- Start Time -->
        <div class="form-group">
          <label class="col-md-12 control-label" for="start_time"></label>  
          <div class="col-md-12">
            <input id="start_time" name="start_time" placeholder="Select Start Time" class="form-control input-md" type="datetime-local" required>
          </div>
        </div>

        <!-- End Time -->
        <div class="form-group">
          <label class="col-md-12 control-label" for="end_time"></label>  
          <div class="col-md-12">
            <input id="end_time" name="end_time" placeholder="Select End Time" class="form-control input-md" type="datetime-local" required>
          </div>
        </div>

        <!-- Text input-->
      <div class="form-group">
        <label class="col-md-12 control-label" for="desc"></label>  
        <div class="col-md-12">
        <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
        </div>
      </div>

        <!-- Submit Button -->
        <div class="form-group">
          <label class="col-md-12 control-label" for=""></label>
          <div class="col-md-12"> 
            <input type="submit" style="margin-left:35%" class="btn btn-primary" value="Create Lab Examination"/>
          </div>
        </div>

      </fieldset>
    </form>
  </div>
</div>
<?php
} ?>

<!-- create lab questions -->
 <!--create lab question step2 start-->
<?php
if (@$_GET['q'] == 6 && (@$_GET['step']) == 2) {
    echo ' 
<div class="row">
<span class="title1" style="margin-left:35%;font-size:30px;"><b>Enter Lab Question Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addlabqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '&ch=4 "  method="POST">
<fieldset>
';
    for ($i = 1;$i <= @$_GET['n'];$i++) {
        echo '<b>Question number&nbsp;' . $i . '&nbsp;:</><br /><!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..."></textarea>  
  </div>
</div>';
    }
    echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';
}
?>
<!--create lab question step 2 end-->

</div><!--container closed-->
</div></div>
</body>
</html>

<?php

// redirect
// Purpose: Re-directs to the provided page, relative to current page
function redirect($page) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/$page");
    exit;
}

// Check whether session created (is user logged in?)
// If not, re-direct to main index page.
session_start();
if(!isset($_SESSION['username']))
{
    // Not logged in, re-direct to the login page
    redirect('../../../index.php');
}

// This page should always be submitted with a GET request method
// If it is not, redirect to logged in home page
if(!isset($_GET['cid']))  {

    redirect('../../../home.php');

} else {
    
    // Get information for this course
    // Connect to database
    $host = "127.0.0.1";
    $user = "rgordonatrsgc";
    $pass = "";
    $db = "ct";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    // Get the provided course id
    $provided_id = htmlspecialchars($_GET['cid']);
    
    // Run the query
    $query = "SELECT id, code FROM course WHERE id = " . $provided_id . ";";
    $result = mysqli_query($connection, $query);
    
    // Verify that a result was obtained from the database
    if ($result == false) {
        
        // Something happened when talking to database, re-direct to logged-in home page
        // TODO: Implement proper error logging
        redirect('../../../home.php');
        
    } else {
        
        if (mysqli_num_rows($result) != 1) {
            
            // This shouldn't happen either, course-id should exist and return a single row, so,
            // re-direct to logged-in home page
            // TODO: Implement proper error logging
            redirect('../../../home.php');
            
        } else {
            
            // We have a valid result for this course
            $row = mysqli_fetch_assoc($result);
            $course_code = $row['code'];
            $course_id = $row['id'];

        }
    }


}


?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Curriculum Tracker</title>

  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <!-- A properly secured site would serve this page over HTTPS (secure HTTP). Why is that? -->
  
</head>

<body>
    <script src="js/scripts.js"></script>

    <p><a href="../../../home.php">Home</a> > <a href="../../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > <a href="../?cid=<?php echo $course_id; ?>">Curriculum</a> > Add...</p>

    <p><?php echo $_SESSION['username']; ?></p>

    <p><a href="../logout.php">logout</a></p>

    <p>What type?</p>
    <p>
        <ul>
            <li>
                <a href="./strand.php?cid=<?php echo $course_id; ?>">Strand</a>
            </li>
            <li>
                <a href="./overall.php?cid=<?php echo $course_id; ?>">Overall Expectation</a>
            </li>
            <li>
                <a href="./minor.php?cid=<?php echo $course_id; ?>">Minor Expectation</a>
            </li>
        </ul>
    </p>

</body>
</html>

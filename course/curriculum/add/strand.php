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

// This page should be submitted with a cid
// If it is not, redirect to logged in home page
if(!isset($_GET['cid']) && !isset($_POST['cid']))  {

    redirect('../../../home.php');

} else if (isset($_GET['cid'])) {
    
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

} else if (isset($_POST['cid'])) {
    
    // Validate input from form
    $provided_code = htmlspecialchars(trim($_POST['code']));
    $provided_title = htmlspecialchars(trim($_POST['title']));
    $provided_course_id = htmlspecialchars(trim($_POST['cid']));

    // Verify that all fields were provided
    if (strlen($provided_code) == 0) {
        $message['code'] = "Code is required, e.g.: A, B, C, etc.";
    }
    if (strlen($provided_title) == 0) {
        $message['title'] = "Title for strand is required, e.g.: Number Sense and Algebra";
    }

    // Verify that field data given is not too long
    if (strlen($provided_code) > 2) {
        $message['code'] = "Code provided is too long, maximum length is 2 characters.";
    }
    if (strlen($provided_title) > 255) {
        $message['title'] = "Title provided is too long, maximum length is 255 characters.";
    }

    // Get the provided course id (sanity check and for building page data on POST submission)
    $provided_id = htmlspecialchars($_POST['cid']);
    
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
    
    // If there were no errors on basic validation of input, proceed
    if (!isset($message)) {

        // We have a valid result for this course
        $query = "INSERT INTO strand (code, title, course_id) VALUES ('" . $provided_code . "', '" . $provided_title . "', " . $course_id . ");";

        // Check to see if query succeeded
        if (! mysqli_query($connection, $query)) {
            // Show an error message, something unexpected happened (query should succeed)
            $message['general'] = "We could not create the strand at this time. Please try again later.";
        } else {
            
            // All is well, re-direct to the logged-in curriculum page for this course
            redirect('../index.php?cid=' . $course_id);
        }

    }    
    
}

// Generate the CSS file link
$base = "http://" . $_SERVER['HTTP_HOST'] . "/curriculum-tracker/";
$csslink = $base . "css/style.css";

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Curriculum Tracker</title>

  <link rel="stylesheet" href="<?php echo $csslink; ?>?v=1.0">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <!-- A properly secured site would serve this page over HTTPS (secure HTTP). Why is that? -->
  
</head>

<body>
    <script src="js/scripts.js"></script>

    <header>
        <ul>
            <li><img src="<?php echo $base; ?>images/logo-small.png"/></li>
        </ul>
    </header>

    <nav>
        <ul>
            <li><a href="../../../home.php">Home</a> > <a href="../../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > <a href="../?cid=<?php echo $course_id; ?>">Curriculum</a> > Add strand...</li>
            <li><a href="<?php echo $base; ?>logout.php">logout</a></li>
            <li><?php echo $_SESSION['username']; ?></li>
        </ul>
    </nav>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            Code:<br/>
            <input type="text" name="code" value="<?php echo $_POST['code'] ?>" maxlength="2" size="2"> <?php echo $message['code']; ?><br/><br/>
            Title:<br/>
            <input type="text" name="title" value="<?php echo $_POST['title'] ?>" maxlength="255" size="80"> <?php echo $message['title']; ?><br/><br/>
            <input type="hidden" name="cid" value="<?php echo $course_id; ?>">
            <input type="submit" name="submit" value="Add">
        </form>
        <p><?php echo $message['general']; ?></p>
    </main>
    
</body>
</html>

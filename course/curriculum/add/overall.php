<?php

// redirect
// Purpose: Re-directs to the provided page, relative to current page
function redirect($page) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/$page");
    exit;
}

// get_strands
// Purpose: Poll the strands table and build the drop-down for the input form
function get_strands($db_connection, $cid) {
    
    // Get strands for this course
    $query = "SELECT id, code, title FROM strand WHERE course_id = " . $cid . ";";
    $result = mysqli_query($db_connection, $query);
    
    // Iterate over the result set
    $output = "<select name=\"strand_id\">";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<option ";
        $output .= "value=\"" . $row['id'] . "\">" . $row['code'] . ". " . $row['title'];
        $output .= "</option>";
    }
    $output .= "</select><br/><br/>";
    
    // Return the generated HTML
    return($output);
    
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
            
            // Generate the strands (needs to poll the database)
            $strand_dropdown_output = get_strands($connection, $course_id);

        }
    }

} else if (isset($_POST['cid'])) {
    
    // Validate input from form
    $provided_strand_id = htmlspecialchars(trim($_POST['strand_id']));          // TODO: Verify that strand ID is valid? Check DB first and re-direct if not reasonable? Similar to what is done with course ID?
    $provided_code = htmlspecialchars(trim($_POST['code']));
    $provided_title = htmlspecialchars(trim($_POST['title']));
    $provided_description = htmlspecialchars(trim($_POST['description']));
    $provided_course_id = htmlspecialchars(trim($_POST['cid']));

    // Verify that all fields were provided
    if (strlen($provided_code) == 0) {
        $message['code'] = "Code is required, e.g.: 1, 2, 3, etc.";
    }
    if (strlen($provided_title) == 0) {
        $message['title'] = "Title for strand is required, e.g.: Operating with Exponents";
    }
    if (strlen($provided_description) == 0) {
        $message['description'] = "A description is required, e.g.: demonstrate an understanding of the exponent rules of multiplication and division, and apply them to simplify expressions;";
    }

    // Verify that field data given is not too long
    if (strlen($provided_code) > 2) {
        $message['code'] = "Code provided is too long, maximum length is 2 characters.";
    }
    if (strlen($provided_title) > 255) {
        $message['title'] = "Title provided is too long, maximum length is 255 characters.";
    }
    if (strlen($description) > 500) {
        $message['description'] = "Description provided is too long, maximum length is 500 characters.";
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

            // Generate the strands (needs to poll the database)
            $strand_dropdown_output = get_strands($connection, $course_id);
        }
    }
    
    // If there were no errors on basic validation of input, proceed
    if (!isset($message)) {

        // We have a valid result for this course
        $query = "INSERT INTO overall_expectation (strand_id, code, title, description)
                                           VALUES (" . $provided_strand_id . ", '" . $provided_code . "', '" . $provided_title . "', '" . $provided_description . "');";

        // Check to see if query succeeded
        if (! mysqli_query($connection, $query)) {
            // Show an error message, something unexpected happened (query should succeed)
            $message['general'] = "We could not create the overall expectation at this time. Please try again later.";
        } else {
            
            // All is well, re-direct to the logged-in curriculum page for this course
            redirect('../index.php?cid=' . $course_id);
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

    <p><a href="../../../home.php">Home</a> > <a href="../../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > <a href="../?cid=<?php echo $course_id; ?>">Curriculum</a> > Add overall expectation...</p>

    <p><?php echo $_SESSION['username']; ?></p>

    <p><a href="../logout.php">logout</a></p>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Add to strand:<br/>
        <?php echo $strand_dropdown_output ?>
        Code:<br/>
        <input type="text" name="code" value="<?php echo $_POST['code'] ?>" maxlength="2" size="2"> <?php echo $message['code']; ?><br/><br/>
        Title:<br/>
        <input type="text" name="title" value="<?php echo $_POST['title'] ?>" maxlength="255" size="82"> <?php echo $message['title']; ?><br/><br/>
        Description:<br/>
        <textarea name="description" cols="80" rows="8" maxlength="500"><?php echo $_POST['description'] ?></textarea><br/><?php echo $message['description']; ?><br/><br/>
        <input type="hidden" name="cid" value="<?php echo $course_id; ?>">
        <input type="submit" name="submit" value="Add">
    </form>
    
    <p><?php echo $message['general']; ?></p>

</body>
</html>

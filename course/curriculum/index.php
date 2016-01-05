<?php

// redirect
// Purpose: Re-directs to the provided page, relative to current page
function redirect($page) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/$page");
    exit;
}

// get_overall_expectations
// Purpose: Poll the overall expectations table and get all expectations for the given strand id
//
//          $db_connection  - The active database connection.
//          $sid            - The id for this strand, from the strands table.
//          $scode          - The code for the given strand, e.g.: A, B, C...
function get_overall_expectations($db_connection, $sid, $scode) {
    
    // Get strands for this course
    $query = "SELECT id, code, title, description FROM overall_expectation WHERE strand_id = " . $sid . ";";
    $result = mysqli_query($db_connection, $query);
    
    // Iterate over the result set
    $output = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "\t\t\t<h3>" . $scode . $row['code'] . ". " . $row['title'] . "</h3>\n";
        $output .= "\t\t\t<p>" . $row['description'] . "</p>\n";

        // Now get the minor expectations for this overall expectation id
        $output .= get_minor_expectations($db_connection, $scode, $row['id'], $row['code']);

    }

    // Return the generated HTML
    return($output);
    
}

// get_minor_expectations
// Purpose: Poll the minor expectations table and get all expectations for the given overall expectation id
//
//          $db_connection  - The active database connection.
//          $scode          - The code for the given strand, e.g.: A, B, C...
//          $oid            - The id for this overall expectation, from the overall_expectation table.
//          $ocode          - The code for the given overall expectation, e.g.: A, B, C...
function get_minor_expectations($db_connection, $scode, $oid, $ocode) {
    
    // Get strands for this course
    $query = "SELECT code, description FROM minor_expectation WHERE overall_expectation_id = " . $oid . ";";
    $result = mysqli_query($db_connection, $query);
    
    // Iterate over the result set
    $output = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "\t\t\t\t<h4>" . $scode . $ocode . "." . $row['code'] . "</h3>\n";
        $output .= "\t\t\t\t<p>" . $row['description'] . "</p>\n";
    }

    // Return the generated HTML
    return($output);
    
}

// Check whether session created (is user logged in?)
// If not, re-direct to main index page.
session_start();
if(!isset($_SESSION['username']))
{
    // Not logged in, re-direct to the login page
    redirect('../../index.php');
}

// This page should always be submitted with a GET request method
// If it is not, redirect to logged in home page
if(!isset($_GET['cid']))  {

    redirect('../../home.php');

} else {
    
    // Get curriculum for this course
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
        redirect('../../home.php');
        
    } else {
        
        if (mysqli_num_rows($result) != 1) {
            
            // This shouldn't happen either, course-id should exist and return a single row, so,
            // re-direct to logged-in home page
            // TODO: Implement proper error logging
            redirect('../../home.php');
            
        } else {
            
            // We have a valid result for this course
            $row = mysqli_fetch_assoc($result);
            $course_code = $row['code'];
            $course_id = $row['id'];

            // Run query to get curriculum details for this course
            $query = "SELECT id, code, title FROM strand WHERE course_id = " . $course_id . ";";
            $result = mysqli_query($connection, $query);
            
            // Check for a result
            if ($result == false) {
                
                // Something happened when talking to database, re-direct to logged-in home page
                // TODO: Implement proper error logging
                redirect('../../home.php');
                
            } else {
                
                if (mysqli_num_rows($result) > 0) {
                    
                    // Iterate over the result set
                    $output = "";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $output .= "\t\t<h2>";
                        //$output .= "<a href=\"./course/?cid=" . urlencode($row['id']) . "\">" . $row['code'] . ": " . $row['name'] . "</a>";
                        $output .= $row['code'] . ". " . $row['title'];
                        $output .= "</h2>\n";
                        
                        // Now get the overall expectations for this strand id
                        $output .= get_overall_expectations($connection, $row['id'], $row['code']);
                    }
            
                } else {
                    
                    $output = "No curriculum expectations defined for this course.";
                    
                }
            }

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

    <p><a href="../../home.php">Home</a> > <a href="../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > Curriculum (list)</p>

    <p><?php echo $_SESSION['username']; ?></p>

    <p><a href="../logout.php">logout</a></p>

    <h1>Curriculum</h1>

    <p><a href="./add/?cid=<?php echo $course_id; ?>">add</a></p>
    <p>
<?php echo $output; ?>
    </p>

</body>
</html>

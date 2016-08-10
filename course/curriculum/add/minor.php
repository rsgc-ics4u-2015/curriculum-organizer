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
// Purpose: Poll the database and build the drop-down with overall expectations for the input form
function get_overall_expectations($db_connection, $cid) {
    
    // Get overall expectations for this course
    $query  = "SELECT s.id AS sid, s.code AS scode, s.title AS stitle, o.id AS oid, o.code AS ocode, o.title AS otitle ";
    $query .= "FROM course c ";
    $query .= "INNER JOIN strand s ";
    $query .= "ON s.course_id = c.id ";
    $query .= "INNER JOIN overall_expectation o ";
    $query .= "ON o.strand_id = s.id ";
    $query .= "WHERE c.id = " . $cid;

    // Run the query
    $result = mysqli_query($db_connection, $query);
    
    // Iterate over the result set
    $output = "<select name=\"overall_expectation_id\">";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<option ";
        $output .= "value=\"" . $row['oid'] . "\">" . $row['scode'] . $row['ocode'] . ". " . $row['otitle'];
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
// TO DO: Get rid of this course id checking. Should have been set in session when course page was navigated to.
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
            $overall_expectations_dropdown_output = get_overall_expectations($connection, $course_id);

        }
    }

} else if (isset($_POST['cid'])) {
    
    // Validate input from form
    $provided_overall_expectation_id = htmlspecialchars(trim($_POST['overall_expectation_id']));          // TODO: Verify that overall expectation ID is valid? Check DB first and re-direct if not reasonable? Similar to what is done with course ID?
    $provided_code = htmlspecialchars(trim($_POST['code']));
    $provided_description = htmlspecialchars(trim($_POST['description']));
    $provided_course_id = htmlspecialchars(trim($_POST['cid']));

    // Verify that all fields were provided
    if (strlen($provided_code) == 0) {
        $message['code'] = "Code is required, e.g.: 1, 2, 3, etc.";
    }
    if (strlen($provided_description) == 0) {
        $message['description'] = "A description is required, e.g.: <br/><br/>describe the relationship between the algebraic and geometric representations of a single-variable term up to degree three [i.e., length, which is one dimensional, can be represented by x; area, which is two dimensional, can be represented by (x)(x) or x2; volume, which is three dimensional, can be represented by (x)(x)(x), (x2)(x), or x3];";
    }

    // Verify that field data given is not too long
    if (strlen($provided_code) > 2) {
        $message['code'] = "Code provided is too long, maximum length is 2 characters.";
    }
    if (strlen($description) > 1000) {
        $message['description'] = "Description provided is too long, maximum length is 1000 characters.";
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
            $overall_expectations_dropdown_output = get_overall_expectations($connection, $course_id);
        }
    }
    
    // If there were no errors on basic validation of input, proceed
    if (!isset($message)) {

        // We have a valid result for this course
        $query = "INSERT INTO minor_expectation (overall_expectation_id, code, description)
                                           VALUES (" . $provided_overall_expectation_id . ", '" . $provided_code . "', '" . $provided_description . "');";
                                           
        // Check to see if query succeeded
        if (! mysqli_query($connection, $query)) {
            // Show an error message, something unexpected happened (query should succeed)
            $message['general'] = "We could not create the minor expectation at this time. Please try again later.";
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

  <title>Curriculum Organizer</title>

  <link rel="stylesheet" href="../../../css/style.css?v=1.0">

  <!-- A properly secured site would serve this page over HTTPS (secure HTTP). Why is that? -->
  
</head>

<body>

    <header>
        <ul>
            <li><img src="../../../images/logo-small.png"/></li>
        </ul>
    </header>

    <nav>
        <ul>
            <li><a href="../../../home.php">Home</a> > <a href="../../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > <a href="../?cid=<?php echo $course_id; ?>">Curriculum</a> > <a href="./?cid=<?php echo $course_id; ?>">Add</a> > Minor expectation...</li>
            <li><a href="../../../logout.php">logout</a></li>
            <li><?php echo $_SESSION['username']; ?></li>
        </ul>
    </nav>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <label>
                    <p>Add to overall expectation:</p>
                    <?php echo $overall_expectations_dropdown_output; ?>
                </label>                    
                <label>
                    <p>Code:</p>
                    <input type="text" name="code" value="<?php echo $_POST['code'] ?>" maxlength="2" size="2">
                    <p class="error"><?php echo $message['code']; ?></p>
                </label>                    
                <label>
                    <p>Description:</p>
                    <textarea name="description" cols="80" rows="8" maxlength="1000"><?php echo $_POST['description'] ?></textarea>
                    <p class="error"><?php echo $message['description']; ?></p>
                </label>                    
                <input type="hidden" name="cid" value="<?php echo $course_id; ?>">
                <input type="submit" name="submit" value="Add">
            </fieldset>            
        </form>
        <p><?php echo $message['general']; ?></p>
    </main>
    
</body>
</html>

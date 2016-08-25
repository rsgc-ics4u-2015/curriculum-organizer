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

            // Run query to get questions linked to curriculum for this course
            //       Populate the $output variable
            // Build query for questions count
            $query  = "SELECT q.id, q.shortlabel, q.title, q.url ";
            $query .= "FROM course c ";
            $query .= "INNER JOIN strand s ";            
            $query .= "ON s.course_id = c.id ";            
            $query .= "INNER JOIN overall_expectation o ";            
            $query .= "ON o.strand_id = s.id ";            
            $query .= "INNER JOIN minor_expectation m ";            
            $query .= "ON m.overall_expectation_id = o.id ";            
            $query .= "INNER JOIN question_has_minor_expectation qm ";
            $query .= "ON qm.minor_expectation_id = m.id "; 
            $query .= "INNER JOIN question q ";
            $query .= "ON qm.question_id = q.id ";
            $query .= "WHERE c.id = " . $course_id . " ";
            $query .= "GROUP BY q.id;";
            
            // Run the query
            $result = mysqli_query($connection, $query);

            // Check for a result
            if ($result == false) {
                
                // Something happened when talking to database, re-direct to logged-in home page
                // TODO: Implement proper error logging
                redirect('../home.php');
                
            } else {
                
                if (mysqli_num_rows($result) == 0) {
            
                    $output = "There are currently no questions defined for this course.";

                } else {
                    
                    // Iterate over results and build a list of questions
                    $output = "";
                    $output .= "<ul class=\"bare\">";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $output .= "\t\t<li>";
                        $output .= $row['shortlabel'] . ". ";
                        $output .= "<a href=\"" . $row['url'] . "\" target=\"_blank\">";
                        $output .= $row['title'];
                        $output .= "</a>";
                        $output .= "</li>\n";
                    }
                    $output .= "</ul>";

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

  <title>Curriculum Organizer</title>

  <link rel="stylesheet" href="../../css/style.css?v=1.0">

  <!-- A properly secured site would serve this page over HTTPS (secure HTTP). Why is that? -->
  
</head>

<body>

    <header>
        <ul>
            <li><img src="../../images/logo-small.png"/></li>
        </ul>
    </header>

    <nav>
        <ul>
            <li><a href="../../home.php">Home</a> > <a href="../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > Questions</li>
            <li><a href="../../logout.php">logout</a></li>
            <li><?php echo $_SESSION['username']; ?></li>
        </ul>
    </nav>

    <main>
        <p><a href="./add/?cid=<?php echo $course_id; ?>">add</a></p>
        <table>
            <tr>
                <th scope="col">Questions</th>
                <th scope="col">Heat Map</th>
            </tr>
            <tr>
                <td>
                    <?php echo $output; ?>
                </td>
                <td>heat map goes here</td>
        </table>
    </main>

</body>
</html>

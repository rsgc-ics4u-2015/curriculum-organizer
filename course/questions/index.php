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
        //$output .= "\t\t\t<h3>" . $scode . $row['code'] . ". " . $row['title'] . "</h3>\n";
        $output .= "<h3 style=\"margin-top: 0px;\"/>";
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
    
    // Get strands and counts
    $query = "SELECT m.id as expectation_id, m.description as description, COUNT(*) as expectation_hit_count, m.code as expectation_code  ";
    $query .= "FROM minor_expectation m ";
    $query .= "LEFT JOIN question_has_minor_expectation q ";
    $query .= "ON m.id = q.minor_expectation_id ";
    $query .= "WHERE overall_expectation_id = " . $oid . " ";
    $query .= "GROUP BY m.id ";
    $query .= "ORDER BY code ASC; ";

    $result = mysqli_query($db_connection, $query);
    
    // Iterate over the result set
    $output = "";
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $hit_count = $row['expectation_hit_count'] - 1;
        $output .= "\t\t\t\t<span class=\"heatmap-expectation\">\n";
        $output .= "\t\t\t\t<span class=\"chiclet\"/>" . $scode . $ocode . "." . $row['expectation_code'] . " (" . $hit_count . ")" . "</span>\n";
        $output .= "\t\t\t\t<span class=\"tooltip\">" . $row['description'] . "</span>\n";                
        $output .= "\t\t\t\t</span>\n";
    }

    // Return the generated HTML
    return($output);
    
}

// get_expectations
// Purpose: Populate the list of expectations to be shown on this page
function get_expectations($db_connection, $cid) {
    
    // Run query to get curriculum details for this course
    $query = "SELECT id, code, title FROM strand WHERE course_id = " . $cid . ";";
    $result = mysqli_query($db_connection, $query);
    
    // Check for a result
    if ($result == false) {
        
        // Something happened when talking to database, re-direct to logged-in home page
        // TODO: Implement proper error logging
        redirect('../../../home.php');
        
    } else {
        
        if (mysqli_num_rows($result) > 0) {
            
            // Iterate over the result set
            $output = "";
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "\t\t<h2>";
                $output .= $row['code'] . ". " . $row['title'];
                $output .= "</h2>\n";
                
                // Now get the overall expectations for this strand id
                $output .= get_overall_expectations($db_connection, $row['id'], $row['code']);
            }
    
        } else {
            
            $output = "No curriculum expectations defined for this course.";
            
        }
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
            
            // Now get expectations to build the heat map
            $heatmap_output = get_expectations($connection, $course_id);


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
                <td>
                    <?php echo $output; ?>
                </td>
                <td>
                    <?php echo $heatmap_output; ?>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </td>
            </tr>
        </table>
        
    </main>

</body>
</html>

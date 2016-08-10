<?php

// redirect
// Purpose: Re-directs to the provided page, relative to current page
function redirect($page) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/$page");
    exit;
}

// isChecked
// Purpose: Verifies whether a given checkbox was already checked.
//          Used to ensure that a checkbox remains checked after a page reload.
function isChecked($forName, $value) {
    // Only continue if the array is not empty
    if (!empty($_POST[$forName])) {
        // Look at each array element and see if it is the same as the one passed
        foreach($_POST[$forName] as $valueToCheck) {
            if ($valueToCheck == $value) {
                return true;
            }
        }
    }
    return false;
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

        }
    }

} else if (isset($_POST['cid'])) {
    
    // Validate input from form
    // TODO: Add support for tagging with curriculum expectation
    $provided_title = htmlspecialchars(trim($_POST['title']));
    $provided_short_label = htmlspecialchars(trim($_POST['shortlabel']));
    $provided_url = htmlspecialchars(trim($_POST['url']));
    $provided_evaluation_category_id = htmlspecialchars(trim($_POST['evaluation_category_id']));
    $provided_type_id = htmlspecialchars(trim($_POST['type_id']));
    $provided_year = htmlspecialchars(trim($_POST['year']));
    $provided_expectations = $_POST['expectations'];
    $provided_author_or_editor_id = htmlspecialchars(trim($_POST['author_or_editor_id']));
    $provided_course_id = htmlspecialchars(trim($_POST['cid']));

    // Verify that all fields were provided
    if (strlen($provided_title) == 0) {
        $message['title'] = "Question title is required, e.g.: 'Comparing rational numbers'";
    }
    if (strlen($provided_short_label) == 0) {
        $message['shortlabel'] = "Label for question is required. This should be the number assigned in the document.";
    }
    if (strlen($provided_url) == 0) {
        $message['url'] = "URL for question is required. This should be a direct link to the question (get from document table of contents).";
    }
    if (strlen($provided_evaluation_category_id) == 0) {
        $message['evaluationcategory'] = "Please select an evaluation category for this question.";
    }
    if (strlen($provided_type_id) == 0) {
        $message['type'] = "Please select a question type.";
    }
    if (strlen($provided_year) == 0) {
        $message['year'] = "Please select an academic year.";
    }
    // expectations (curriculum)
    // author_or_editor_id
    
    // Verify that field data given is reasonable
    if (strlen($provided_title) > 45) {
        $message['title'] = "Title provided is too long, maximum length is 45 characters.";
    }
    if (strlen($provided_short_label) > 255) {
        $message['shortlabel'] = "Short label provided is too long, maximum length is 10 characters.";
    }
    if (strlen($provided_url) > 2000) {
        $message['url'] = "URL provided is too long, maximum length is 2000 characters.";
    }
    if (!filter_var($provided_url, FILTER_VALIDATE_URL)) {
        $message['url'] = "Please provide a valid URL. This should be a direct link to the question (get from document table of contents).";
    }
    if ($provided_evaluation_category_id < 0 || $provided_evaluation_category_id > 4) {
        $message['evaluationcategory'] = "Please select a valid evaluation category.";
    }
    if ($provided_evaluation_category_id < 0 || $provided_evaluation_category_id > 3) {
        $message['type'] = "Please select a valid question type.";
    }
    if ($provided_year != '2015-16' && $provided_year != '2016-17' && strlen($provided_year) != 0) {
        $message['year'] = "Please select a valid academic year.";
    }
    if (empty($provided_expectations)) {
        $message['expectations'] = "Please select at least one curriculum expectation this question addresses.";
    }
    // expectations (curriculum)
    // author_or_editor_id

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
        // Add the question to the database
        //$query = "INSERT INTO strand (code, title, course_id) VALUES ('" . $provided_code . "', '" . $provided_title . "', " . $course_id . ");";

        // Check to see if query succeeded
        if (! mysqli_query($connection, $query)) {
            // Show an error message, something unexpected happened (query should succeed)
            $message['general'] = "We could not create the question at this time. Please try again later.";
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
            <li><a href="../../../home.php">Home</a> > <a href="../../?cid=<?php echo $course_id; ?>"><?php echo $course_code; ?></a> > <a href="../?cid=<?php echo $course_id; ?>">Questions</a> > Add...</li>
            <li><a href="../../../logout.php">logout</a></li>
            <li><?php echo $_SESSION['username']; ?></li>
        </ul>
    </nav>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <label>
                    <p>Title:</p>
                    <input type="text" name="title" value="<?php echo $_POST['title'] ?>" maxlength="45" size="45">
                    <p class="error"><?php echo $message['title']; ?></p>
                </label>                    
                <label>
                    <p>Short label:</p>
                    <input type="text" name="shortlabel" value="<?php echo $_POST['shortlabel'] ?>" maxlength="10" size="10">
                    <p class="error"><?php echo $message['shortlabel']; ?></p>
                </label>                    
                <label>
                    <p>URL:</p>
                    <input type="text" name="url" value="<?php echo $_POST['url'] ?>" maxlength="2000" size="100">
                    <p class="error"><?php echo $message['url']; ?></p>
                </label>                    
                <label>
                    <p>Evaluation Category:</p>
                    <input type="radio" name="evaluation_category_id" value="1" <?php if ($_POST['evaluation_category_id'] == '1') echo 'checked'; ?>> Knowledge &nbsp;&nbsp;
                    <input type="radio" name="evaluation_category_id" value="2" <?php if ($_POST['evaluation_category_id'] == '2') echo 'checked'; ?>> Inquiry &nbsp;&nbsp;
                    <input type="radio" name="evaluation_category_id" value="3" <?php if ($_POST['evaluation_category_id'] == '3') echo 'checked'; ?>> Communication &nbsp;&nbsp;
                    <input type="radio" name="evaluation_category_id" value="4" <?php if ($_POST['evaluation_category_id'] == '4') echo 'checked'; ?>> Application &nbsp;&nbsp;
                    <p class="error"><?php echo $message['evaluationcategory']; ?></p>
                </label>                    
                <label>
                    <p>Question type:</p>
                    <input type="radio" name="type_id" value="1" <?php if ($_POST['type_id'] == '1') echo 'checked'; ?>> Assessment <em>for</em> learning &nbsp;&nbsp;
                    <input type="radio" name="type_id" value="2" <?php if ($_POST['type_id'] == '2') echo 'checked'; ?>> Assessment <em>of</em> learning &nbsp;&nbsp;
                    <input type="radio" name="type_id" value="3" <?php if ($_POST['type_id'] == '3') echo 'checked'; ?>> Assessment <em>as</em> learning &nbsp;&nbsp;
                    <p class="error"><?php echo $message['type']; ?></p>
                </label>                    
                <label>
                    <p>For academic year:</p>
                    <input type="radio" name="year" value="2015-16" <?php if ($_POST['year'] == '2015-16') echo 'checked'; ?>> 2015-16 &nbsp;&nbsp;
                    <input type="radio" name="year" value="2016-17" <?php if ($_POST['year'] == '2016-17') echo 'checked'; ?>> 2016-17 &nbsp;&nbsp;
                    <p class="error"><?php echo $message['year']; ?></p>
                </label>                    
                <label>
                    <p>Select <a href="../../curriculum/?cid=<?php echo $course_id ?>" target="_blank">curriculum expectation(s)</a> addressed:</p>
                    <span class="expectation">
                        <input type="checkbox" name="expectations[]" value="A" <?php if (isChecked('expectations', 'A')) echo 'checked'; ?>/>A1.1 &nbsp;
                        <span class="tooltip">Explanation of A1.1 expectation</span>
                    </span>
                    <span class="expectation">
                        <input type="checkbox" name="expectations[]" value="B" <?php if (isChecked('expectations', 'B')) echo 'checked'; ?>/>A1.2 &nbsp;
                        <span class="tooltip">Explanation of A1.2 expectation</span>
                    </span>
                    <span class="expectation">
                        <input type="checkbox" name="expectations[]" value="C" <?php if (isChecked('expectations', 'C')) echo 'checked'; ?>/>A1.3 &nbsp;
                        <span class="tooltip">Explanation of A1.3 expectation</span>
                    </span>
                <p class="error"><?php echo $message['expectations']; ?></p>
                </label>
                <input type="hidden" name="cid" value="<?php echo $course_id; ?>">
                <input type="submit" name="submit" value="Add">
            </fieldset>
        </form>
        <p><?php echo $message['general']; ?></p>
    </main>
    
</body>
</html>

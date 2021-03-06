<?php

// Check whether session created (is user logged in?)
// If not, re-direct to main index page.
session_start();
if(!isset($_SESSION['username']))
{
    // Not logged in, re-direct to the login page
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = '../index.php';
    header("Location: http://$host$uri/$extra");
    exit;
}

// This page is a self-submitting form.
// Process the submitted form.
if(isset($_POST['submit']))  {

    $provided_name = htmlspecialchars(trim($_POST['name']));
    $provided_code = htmlspecialchars(trim($_POST['code']));
    $provided_description = htmlspecialchars(trim($_POST['description']));
    $provided_url = htmlspecialchars(trim($_POST['url']));
    
    // Verify that all fields were provided
    if (strlen($provided_name) == 0) {
        $message['name'] = "Name is required, e.g.: Grade 10 - Principles of Math";
    }
    if (strlen($provided_code) == 0) {
        $message['code'] = "Code is required, e.g.: MPM2D";
    }
    if (strlen($provided_description) == 0) {
        $message['description'] = "Description is required, e.g.: Ministry course blurb";
    }
    if (strlen($provided_url) == 0) {
        $message['url'] = "Canoninical curriculum URL is required, e.g.: http://www.edu.gov.on.ca/eng/curriculum/secondary/math910curr.pdf";
    }

    // Verify that field data given is not too long
    if (strlen($provided_name) > 45) {
        $message['name'] = "Name provided is too long, maximum length is 45 characters.";
    }
    if (strlen($provided_code) > 8) {
        $message['code'] = "Code provided is too long, maximum length is 8 characters.";
    }
    if (strlen($provided_description) > 1024) {
        $message['description'] = "Description provided is too long, maximum length is 1024 characters.";
    }
    if (strlen($provided_url) > 2000) {
        $message['url'] = "URL provided is too long, maximum length is 2000 characters. ";
    }

    // Verify that URL provided is actually a URL
    if (!filter_var($provided_url, FILTER_VALIDATE_URL)) {
        $message['url'] = "Please provide a valid URL, e.g.: http://www.edu.gov.on.ca/eng/curriculum/secondary/math910curr.pdf";
    }

    // If there were no errors on basic validation of input, proceed
    if (!isset($message)) {

        // Connect to database
        $host = "127.0.0.1";
        $user = "rgordonatrsgc";
        $pass = "";
        $db = "ct";
        $port = 3306;
        
        // Establish the connection
        // (note username and password here is the *database* username and password, not for a user of this website)
        $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
        
        $query = "INSERT INTO course (name, description, code, url) VALUES ('" . $provided_name . "', '" . $provided_description . "', '" . $provided_code . "', '" . $provided_url . "');";

        // Check to see if query succeeded
        if (! mysqli_query($connection, $query)) {
            // Show an error message, something unexpected happened (query should succeed)
            $message['general'] = "We could not create the course at this time. Please try again later.";
        } else {
            
            // All is well, re-direct to the logged-in home page
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = '../home.php';
            header("Location: http://$host$uri/$extra");
            exit;
        }
        
    }
    
}

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Curriculum Organizer</title>

  <link rel="stylesheet" href="../css/style.css?v=1.0">

  <!-- A properly secured site would serve this page over HTTPS (secure HTTP). Why is that? -->
  
</head>

<body>

    <header>
        <ul>
            <li><img src="../images/logo-small.png"/></li>
        </ul>
    </header>

    <nav>
        <ul>
            <li><a href="../home.php">Home</a> > Add Course...</li>
            <li><a href="../logout.php">logout</a></li>
            <li><?php echo $_SESSION['username']; ?></li>
        </ul>
    </nav>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <label>
                    <p>Name:</p>
                    <input type="text" name="name" value="<?php echo $_POST['name'] ?>" maxlength="45" size="45">
                    <p class="error"><?php echo $message['name']; ?></p>
                </label>                    
                <label>
                    <p>Code:</p>
                    <input type="text" name="code" value="<?php echo $_POST['code'] ?>" maxlength="8" size="8">
                    <p class="error"><?php echo $message['code']; ?></p>
                </label>                    
                <label>
                    <p>Description:</p>
                    <textarea name="description" cols="80" rows="8" maxlength="1024"><?php echo $_POST['description'] ?></textarea>
                    <p class="error"><?php echo $message['description']; ?></p>
                </label>                    
                <label>
                    <p>Canoninical curriculum URL:</p>
                    <input type="text" name="url" value="<?php echo $_POST['url'] ?>" maxlength="80" size="80">
                    <p class="error"><?php echo $message['url']; ?></p>
                </label>                    
                <input type="submit" name="submit" value="Add">
            </fieldset>
        </form>
        
        <p><?php echo $message['general']; ?></p>
    </main>

</body>
</html>
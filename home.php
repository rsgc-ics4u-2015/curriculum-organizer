<?php

    // Check whether session created (is user logged in?)
    // If not, re-direct to main index page.
    session_start();
    if(!isset($_SESSION['username']))
    {
        // Not logged in, re-direct to the login page
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php';
        header("Location: http://$host$uri/$extra");
        exit;
    }

    // Show list of courses on home page 
    // Connect to database
    $host = "127.0.0.1";
    $user = "rgordonatrsgc";
    $pass = "";
    $db = "ct";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    // And now perform simple query – make sure it's working
    $query = "SELECT id, code, name FROM course;";
    $result = mysqli_query($connection, $query);
    
    // Iterate over the result set
    $output = "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<li>";
        $output .= "<a href=\"./course/?cid=" . urlencode($row['id']) . "\">" . $row['code'] . ": " . $row['name'] . "</a>";
        $output .= "</li>";
    }
    $output .= "</ul>";


// Generate the CSS file link
$base = "http://" . $_SERVER['HTTP_HOST'] . "/curriculum-organizer/";
$csslink = $base . "css/style.css";

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Curriculum Organizer</title>

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
            <li>Home</li>
            <li><a href="<?php echo $base; ?>logout.php">logout</a></li>
            <li><?php echo $_SESSION['username']; ?></li>
        </ul>
    </nav>

    <main>
        <p><a href="course/add.php">add</a></p>

        <?php echo $output ?>

    </main>
  
</body>
</html>

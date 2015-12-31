<?php

if(isset($_POST['submit']))  {
    
    // This is a self-submitting form; eventually, add logic to process a log-in below.
    $output = "<p>Login logic not yet implemented.</p>";
    $output .= "<p>You tried to log in with username: <strong>" . htmlentities($_POST['username']) . "</strong></p>";
    
} else {
    
    // Show this form by default
    $output = "<form action=" . $_SERVER['PHP_SELF'] . " method=\"post\">";
    $output .= "Username:<br/>";
    $output .= "<input type=\"text\" name=\"username\" value=\"\"><br/>";
    $output .= "Password:<br/>";
    $output .= "<input type=\"password\" name=\"password\" value=\"\"><br/>";
    $output .= "<input type=\"submit\" name=\"submit\" value=\"Login\">";
    $output .= "</form>";
    
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

    <h1>Curriculum Tracker</h1>
  
    <?php echo $output ?>
  
    <p>... or, <a href="register.php">create a new account</a>.</p>
  
</body>
</html>
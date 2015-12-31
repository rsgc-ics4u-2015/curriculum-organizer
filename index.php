<?php

if(isset($_POST['submit']))  {
    
    // Connect to database
    $host = "127.0.0.1";
    $user = "rgordonatrsgc";
    $pass = "";
    $db = "ct";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());

    // Process a log in
    $provided_username = htmlspecialchars($_POST['username']);
    $provided_password = htmlspecialchars($_POST['password']);
    $query = "SELECT password FROM author_or_editor WHERE username = ('" . $provided_username . "');";
    
    // Get results
    $result = mysqli_query($connection, $query);
    
    // Compare the provided password to the stored password
    if ($result == false) {
        $message['general'] = "An unexpected error occurred. Please try again later.";
    } else {
        if (mysqli_num_rows($result) == 0) {
          $message['general'] = "Error. The user <strong>" . $provided_username . "</strong> was not found.";
        } else {
          // We have a result, now do the comparison of passwords
          $row = mysqli_fetch_assoc($result);
          $stored_password = $row['password'];
          if (password_verify($provided_password, $stored_password) == true) {
                // All is well, re-direct to the courses page
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'courses.php';
                header("Location: http://$host$uri/$extra");
                exit;
          } else {
              $message['general'] = "Incorrect password for user <strong>" . $provided_username . "</strong>.";
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

    <h1>Curriculum Tracker</h1>
  
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Username:<br/>
        <input type="text" name="username" value="<?php echo $_POST['username'] ?>" maxlength="45" size="45"> <?php echo $message['username']; ?><br/><br/>
        Password:<br/>
        <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="45" size="45"> <?php echo $message['password']; ?><br/><br/>
        <input type="submit" name="submit" value="Login">
    </form>
  
    <p>... or, <a href="register.php">create a new account</a>.</p>

    <p><?php echo $message['general']; ?></p>
  
</body>
</html>
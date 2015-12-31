<?php

if(isset($_POST['submit']))  {
    
    // This is a self-submitting form; eventually, add logic to process a log-in below.
    $message['general'] = "<p>Login logic not yet implemented.</p>";
    $message['general'] .= "<p>You tried to log in with username: <strong>" . htmlspecialchars($_POST['username']) . "</strong></p>";
    
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
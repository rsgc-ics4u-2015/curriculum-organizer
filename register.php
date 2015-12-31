<?php

// This page is a self-submitting form.
// Process the submitted form.
if(isset($_POST['submit']))  {

    $provided_username = htmlspecialchars(trim($_POST['username']));
    $provided_firstname = htmlspecialchars(trim($_POST['firstname']));
    $provided_lastname = htmlspecialchars(trim($_POST['lastname']));
    $provided_password = htmlspecialchars(trim($_POST['password']));
    
    // Verify that username, lastname, and password were provided. First name is optional.
    if (strlen($provided_username) == 0) {
        $username_message = "Username is required.";
    }
    if (strlen($provided_lastname) == 0) {
        $lastname_message = "Last name is required.";
    }
    if (strlen($provided_password) == 0) {
        $password_message = "A password is required.";
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

  <h1>Register</h1>
  
  <p>Create a new account:</p>
  
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Username:<br/>
        <input type="text" name="username" value="" maxlength="45" size="45"> <?php echo $username_message; ?><br/><br/>
        First name:<br/>
        <input type="text" name="firstname" value="" maxlength="45" size="45"> <?php echo $firstname_message; ?><br/><br/>
        Last name:<br/>
        <input type="text" name="lastname" value="" maxlength="45" size="45"> <?php echo $lastname_message; ?><br/><br/>
        Password:<br/>
        <input type="password" name="password" value="" maxlength="45" size="45"> <?php echo $password_message; ?><br/><br/>
        <input type="submit" name="submit" value="Create account">
    </form>
    
    <p>Note that new accounts will not be usable until approved by the system administrator.</p>

</body>
</html>
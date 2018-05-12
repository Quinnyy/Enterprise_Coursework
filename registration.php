<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="header">
    <h2>Registration</h2>
</div>

<form method="POST" action="registration.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Username:</label>
        <input type="text" name="regUsername">
    </div>
    <div class="input-group">
        <label>Password:</label>
        <input type="password" name="regPassword">
    </div>
    <div class="input-group">
        <label>Confirm Password:</label>
        <input type="password" name="regConfirmPassword">
    </div>
    <div class="input-group">
       <button type="submit" name="registerUser" class="btn">Register</button>
    </div>
    <p>
      <a href="login.php">Sign In</a>
        <a href="index.php">Back Home</a>
    </p>

</form>
</body>
</html>
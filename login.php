<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="header">
    <h2>Login</h2>
</div>

<form action="login.php" method="POST">
    <div class="input-group">
        <label>Username:</label>
        <input type="text" id="userName" name="userName">
    </div>
    <div class="input-group">
        <label>Password:</label>
        <input type="text" id="userPassword" name="userPassword">
    </div>

    <div class="input-group">
        <button type="submit" name="loginButton" class="btn">Login</button>
    </div>
    <p>
        <a href="registration.php">Register Here</a>
        <a href="index.php">Back Home</a>
    </p>
</form>

</body>



</html>






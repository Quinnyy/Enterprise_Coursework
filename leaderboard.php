<?php include('server.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="header">
    <h2>Leaderboard!</h2>
</div

<form action="leaderboard.php" method="POST">

   <?php $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

    $sql = "SELECT u.ID, u.Username, v.name, v.points FROM users u, village v 
              WHERE u.ID = v.user_id";

    $Result = $mysqli->query($sql);

    while($row = mysqli_fetch_array($Result)) {
        ?>
        <tr>
            <td><p>ID: <?php echo $row['ID']; ?></p></td>
            <td><p>Username: <?php echo $row['Username']; ?></p></td>
            <td><p>Village Name: <?php echo $row['name']; ?></p></td>
            <td><p>Village Points:<?php echo $row['points']; ?></p></td>
            <br>
        </tr>
        <?php
    }
?>

    <button  class="btn"><a href="village.php">Back to Village</a></button>


</form>

</body>



</html>


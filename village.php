<?php
include('server.php');

$user_id = $_SESSION['userID'];


$mysqli = new mysqli('localhost', 'root', '18james18', 'login');

$sql= "SELECT * FROM village WHERE user_id = '$user_id'";



$Result = $mysqli->query($sql);
$row = mysqli_fetch_array($Result);

$villageName = $row['name'];
$villageHQ = $row['hq'];
$villageWood = $row['wood'];
$villageIron = $row['iron'];
$villageClay = $row['clay'];
$villagePoints = $row['points'];
$villageChurch = $row['church'];
$villageWall = $row['wall'];
$villageWonder = $row['wonder'];
$villageFarm = $row['farm'];
$villageHouse = $row['house'];
$woodLevel = $row['amount_wood'];
$clayLevel = $row['amount_clay'];
$ironLevel = $row['amount_iron'];

updatePoints();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Village</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="header">
    <h2><?php echo $villageName; ?></h2>
</div>

<form action="village.php" method="POST" >

    <?php if (isset($_SESSION['currentUser'])): ?>
        <p>Welcome, <strong><?php echo $_SESSION['currentUser']; ?></strong></p>
    <?php else:  header('location: index.php'); ?>
    <?php endif ?>

    <br>

    <p><label><strong>Wood: <?php echo $woodLevel; ?> </strong>&nbsp;&nbsp;&nbsp;
        <label><strong>Clay: <?php echo $clayLevel; ?></strong></label>&nbsp;&nbsp;&nbsp;
        <label><strong>Iron: <?php echo $ironLevel; ?></strong></label></p>
    <br>
    <button class="btn_smaller_left" type="submit" name="addResources">Get Resources</button>
    <br>
        <br>

    <h3>Village Buildings:</h3>
    <br>
    <p><label id="hq">Village Headquarters: <?php echo $villageHQ; ?></label><button class="btn_smaller" type="submit" name="upgradeHQ">Upgrade</button></p></p>
    <br>
    <p><label id="clayBuilding">Village Clay Pits: <?php echo $villageClay ?></label><button class="btn_smaller" type="submit" name="upgradeClay">Upgrade</button></p></p>
    <br>
    <p><label id="woodBuilding">Village Lumber Camp: <?php echo $villageWood; ?></label><button class="btn_smaller" type="submit" name="upgradeWood">Upgrade</button></p></p>
    <br>
    <p><label id="ironBuilding">Village Iron Mines: <?php echo $villageIron; ?></label><button class="btn_smaller" type="submit" name="upgradeIron">Upgrade</button></p></p>
    <br>
    <p><label id="ironBuilding">Village Church: <?php echo $villageChurch; ?></label><button class="btn_smaller" type="submit" name="upgradeChurch">Upgrade</button></p></p>
    <br>
    <p><label id="ironBuilding">Village Wall: <?php echo $villageWall; ?></label><button class="btn_smaller" type="submit" name="upgradeWall">Upgrade</button></p></p>
    <br>
    <p><label id="ironBuilding">Village Farm: <?php echo $villageFarm; ?></label><button class="btn_smaller" type="submit" name="upgradeFarm">Upgrade</button></p></p>
    <br>
    <p><label id="ironBuilding">Village Houses: <?php echo $villageHouse; ?></label><button class="btn_smaller" type="submit" name="upgradeHouse">Upgrade</button></p></p>
    <br>
    <p><label id="ironBuilding">Village Wonder: <?php echo $villageWonder ?></label><button class="btn_smaller" type="submit" name="upgradeWonder">Upgrade</button></p></p>
    <br>
    <p><label id="points"><strong>Village Points: <?php echo $villagePoints; ?></strong></label></p>
<br>
    <p>
        <input type="text" style="height: 35px" placeholder="Rename Village" id="villageName" name="villageName">
        <button type="submit" name="renamevillage" class="btn">Rename</button>
    </p>
    <br>
    <button  class="btn"><a style="color: white" href="leaderboard.php">Leaderboard</a></button>
    <button  class="btn"><a style="color: white" href="trade.php">Trade</a></button>
    <button type="submit" name="logoutButton" class="btn">Logout</button>
</form>
</body>

</html>
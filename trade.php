<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Trade</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="header">
    <h2>Trade</h2>
</div>
<form action="trade.php" method="POST">

<p>Create and view trade offers with other players!</p>


<br>

    <h3>Create Offer:</h3>

    <div class="input-group">
        <label>I Want:</label>
        <input placeholder="wood, clay or iron" type="text" id="resourceWant" name="resourceWant">

        <label>Amount:</label>
        <input type="text" id="amountWant" name="amountWant">

        <label>I Offer:</label>
        <input placeholder="wood, clay or iron" type="text" id="resourceOffer" name="resourceOffer">

        <label>Amount:</label>
        <input type="text" id="amountFor" name="amountFor">
    </div>


    <br>

    <button type="submit" name="createTrade" class="btn">Create Trade Offer</button>
    <br>
    <br>

    <h3>Trade Offers:</h3>
<br

    <?php $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

    $sql = "SELECT t.id, t.idUser_createdIndex, t.offer, t.recieve, t.resourceWant, t.resourceOffer, u.ID, u.Username
                FROM trade t, users u WHERE t.idUser_createdIndex = u.ID";

    $Result = $mysqli->query($sql);

    while($row = mysqli_fetch_array($Result)) {
        ?>
        <tr>
            <td><p>User: <?php echo $row['Username']; ?></p></td>
            <td><p>Resource Want: <?php echo $row['resourceWant']; ?></p></td>
            <td><p>Amount: <?php echo $row['recieve']; ?></p></td>
            <td><p>Resource Offering: <?php echo $row['resourceOffer']; ?></p></td>
            <td><p>Amount: <?php echo $row['offer']; ?></p></td>
            </td>
            <td><button type="submit" name="acceptTrade" class="btn" value="<?php echo $row['id']?>">Accept Trade</button></td>
            <br>
            <br>
        </tr>
        <?php
    }
    ?>






    <button  class="btn"><a  href="village.php">Back to Village</a></button>


</form>

</body>



</html>
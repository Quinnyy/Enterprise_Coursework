<?php

session_start();

$errors = array();
$mysqli = new mysqli('localhost', 'root', '18james18', 'login');

if ($mysqli->connect_error) {
    echo "No working :((( ";
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

if(isset($_POST['registerUser'])) {
    $regName = $_POST['regUsername'];
    $regPassword = $_POST['regPassword'];
    $regConfirmPassword = $_POST['regConfirmPassword'];


    if (empty($regName)) {
        array_push($errors, "Username must not be left empty");
    }

    if (empty($regPassword)) {
        array_push($errors, "Password must not be left empty");
    }

    if ($regPassword != $regConfirmPassword) {
        array_push($errors, "Passwords must match each other");
    }

    if (count($errors) == 0) {
        $sql = "INSERT INTO users (Username, Password) VALUES ('$regName', '$regPassword')";
        mysqli_query($mysqli, $sql);
        $_SESSION['currentUser'] = $regName;

        $sqlUserID = "SELECT ID FROM users WHERE Username = '$regName'";

        $Result = $mysqli->query($sqlUserID);
        $row = mysqli_fetch_array($Result);
        $user_id = $row['ID'];
        $_SESSION['userID'] = $user_id;

        $sqlVillage = "INSERT INTO village (user_id, name, hq, wood, iron, clay,
                          points, church, wall, wonder, farm, house, amount_wood, amount_clay,
                          amount_iron)
                            VALUES ('$user_id', 'Village Name', '1', '1', '1',
                                '1', '0', '0', '0', '0', '1', '1', '100', '100', '100')";

        mysqli_query($mysqli, $sqlVillage);
        updatePoints();
        header('location: village.php');
    }
}

if (isset($_POST['loginButton'])) {

        $Username = $_POST['userName'];
        $Password = $_POST['userPassword'];

        echo $Username;


        $myQuery = "select * from users where Username = '$Username' and Password = '$Password'";

        $Result = $mysqli->query($myQuery);

        $row = mysqli_fetch_array($Result);

        if ($row['Username'] == $Username && $row['Password'] == $Password && ("" !== $Username || "" !== $Password)) {
            $_SESSION['currentUser'] = $Username;

            $sqlUserID = "SELECT ID FROM users WHERE Username = '$Username'";

            $Result2 = $mysqli->query($sqlUserID);
            $row2 = mysqli_fetch_array($Result2);
            $user_id = $row2['ID'];
            $_SESSION['userID'] = $user_id;

            header('location: village.php');

        } else {
            echo "Failed to login, please try again";
        }

    }

 if(isset($_POST['createTrade']))
 {

     $user_id = $_SESSION['userID'];

     $ressieWant = $_POST['resourceWant'];
     $ressieOffer = $_POST['resourceOffer'];
     $amountWanted = $_POST['amountWant'];
     $amountOffer = $_POST['amountFor'];

     $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

     $Result = $mysqli->query($sql);
     $row = mysqli_fetch_array($Result);

     $wood = $row['amount_wood'];
     $clay = $row['amount_clay'];
     $iron = $row['amount_iron'];

     if($ressieOffer =='wood' && $wood < $amountOffer )
     {
         echo "Not enough resources to make that trade";

     }

     else if($ressieOffer =='clay' && $clay < $amountOffer )
     {
         echo "Not enough resources to make that trade";
     }

     else if($ressieOffer =='iron' && $iron < $amountOffer )
     {
         echo "Not enough resources to make that trade";
     }

     else
         {
             $sql2 = "INSERT INTO trade (idUser_createdIndex, offer, recieve, resourceWant,
                  resourceOffer) VALUES ('$user_id', '$amountOffer', '$amountWanted', '$ressieWant', '$ressieOffer')";


             mysqli_query($mysqli, $sql2);

             echo 'trade successfully made' ;
     }

 }

if (isset($_POST['logoutButton']))
{
    session_destroy();
    header('location: index.php');

}


if (isset($_POST['renamevillage'])) {
    $villageRenamer = $_POST['villageName'];

    If($villageRenamer != null || $villageRenamer != "")
    {
        $user_id = $_SESSION['userID'];

        $sql = "UPDATE village SET name  = '$villageRenamer' WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $sql);



        header('location: village.php');
    }
   else{
     header('location: village.php');
   }

}

if (isset($_POST['upgradeHQ'])) {
    $user_id = $_SESSION['userID'];

    $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

    $sql = "SELECT * FROM village WHERE user_id = '$user_id'";


    $Result = $mysqli->query($sql);
    $row = mysqli_fetch_array($Result);

    $villageHQ = $row['hq'] + 1;
    $countWood = $row['amount_wood'];
    $countIron = $row['amount_iron'];
    $countClay = $row['amount_clay'];

    $woodCost = $villageHQ * 60;
    $clayCost = $villageHQ * 40;
    $ironCost = $villageHQ * 80;


    if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {
        $sql = "UPDATE village SET hq  = hq + 1  WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $sql);
        updatePoints();
        updateResources($woodCost, $clayCost, $ironCost);
    } else {
        echo 'Not enough resources';
    }
}

if (isset($_POST['upgradeClay'])) {
    $user_id = $_SESSION['userID'];

    $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

    $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

    $Result = $mysqli->query($sql);
    $row = mysqli_fetch_array($Result);

    $villageClay = $row['clay'] + 1;
    $countWood = $row['amount_wood'];
    $countIron = $row['amount_iron'];
    $countClay = $row['amount_clay'];

    $woodCost = $villageClay * 60;
    $clayCost = $villageClay * 10;
    $ironCost = $villageClay * 40;

    if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {
        $user_id = $_SESSION['userID'];
        $sql = "UPDATE village SET clay  = clay + 1  WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $sql);
        updatePoints();
        updateResources($woodCost, $clayCost, $ironCost);

    } else {
        echo 'Not enough resources';
    }
}


if (isset($_POST['upgradeWood'])) {

    $user_id = $_SESSION['userID'];

    $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

    $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

    $Result = $mysqli->query($sql);
    $row = mysqli_fetch_array($Result);

    $villageWood = $row['wood'] + 1;
    $countWood = $row['amount_wood'];
    $countIron = $row['amount_iron'];
    $countClay = $row['amount_clay'];

    $woodCost = $villageWood * 10;
    $clayCost = $villageWood * 40;
    $ironCost = $villageWood * 60;

    if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {

        $user_id = $_SESSION['userID'];
        $sql = "UPDATE village SET wood  = wood + 1  WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $sql);
        updatePoints();
        updateResources($woodCost, $clayCost, $ironCost);
    }
    else {
        echo 'Not enough resources';
    }
}

if (isset($_POST['upgradeIron'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageIron = $row['iron'] + 1;
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $woodCost = $villageIron * 40;
        $clayCost = $villageIron * 60;
        $ironCost = $villageIron * 10;

        if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {

            $user_id = $_SESSION['userID'];
            $sql = "UPDATE village SET iron  = iron + 1  WHERE user_id = '$user_id'";

            mysqli_query($mysqli, $sql);
            updatePoints();
            updateResources($woodCost, $clayCost, $ironCost);
        }
        else {
            echo 'Not enough resources';
        }
    }

    if (isset($_POST['upgradeChurch'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageChurch = $row['church'] + 1;
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $woodCost = $villageChurch * 60;
        $clayCost = $villageChurch * 50;
        $ironCost = $villageChurch * 25;

        if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron)
            {

                $user_id = $_SESSION['userID'];
                $sql = "UPDATE village SET church  = church + 1  WHERE user_id = '$user_id'";

                mysqli_query($mysqli, $sql);
                updatePoints();
                updateResources($woodCost, $clayCost, $ironCost);
            }
        else {
            echo 'Not enough resources';
        }
        }

    if (isset($_POST['upgradeWall'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageWall = $row['wall'] + 1;
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $woodCost = $villageWall * 80;
        $clayCost = $villageWall * 10;
        $ironCost = $villageWall * 10;

        if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron)
            {

                $user_id = $_SESSION['userID'];
                $sql = "UPDATE village SET wall  = wall + 1  WHERE user_id = '$user_id'";

                mysqli_query($mysqli, $sql);
                updatePoints();
                updateResources($woodCost, $clayCost, $ironCost);
            }
        else {
            echo 'Not enough resources';
        }
    }

    if (isset($_POST['upgradeFarm'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageFarm = $row['farm'] + 1;
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $woodCost = $villageFarm * 80;
        $clayCost = $villageFarm * 10;
        $ironCost = $villageFarm * 10;

        if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {

            $user_id = $_SESSION['userID'];
            $sql = "UPDATE village SET farm  = farm + 1  WHERE user_id = '$user_id'";

            mysqli_query($mysqli, $sql);
            updatePoints();
            updateResources($woodCost, $clayCost, $ironCost);

        }
        else {
            echo 'Not enough resources';
        }
    }

    if (isset($_POST['upgradeHouse'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageHouse = $row['house'] + 1;
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $woodCost = $villageHouse * 80;
        $clayCost = $villageHouse * 35;
        $ironCost = $villageHouse * 15;

        if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {

            $user_id = $_SESSION['userID'];
            $sql = "UPDATE village SET house  = house + 1  WHERE user_id = '$user_id'";

            mysqli_query($mysqli, $sql);
            updatePoints();
            updateResources($woodCost, $clayCost, $ironCost);

        }
        else {
            echo 'Not enough resources';
        }
    }

    if (isset($_POST['upgradeWonder'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";

        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageWonder = $row['wonder'] + 1;
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $woodCost = $villageWonder * 500;
        $clayCost = $villageWonder * 700;
        $ironCost = $villageWonder * 450;

        if ($woodCost < $countWood && $clayCost < $countClay && $ironCost < $countIron) {

            $user_id = $_SESSION['userID'];
            $sql = "UPDATE village SET wonder  = wonder + 1  WHERE user_id = '$user_id'";

            mysqli_query($mysqli, $sql);
            updatePoints();
            updateResources($woodCost, $clayCost, $ironCost);

        }
        else {
            echo 'Not enough resources';
        }
    }

    function updatePoints()
    {
        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";


        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageHQ = $row['hq'];
        $villageWood = $row['wood'];
        $villageIron = $row['iron'];
        $villageClay = $row['clay'];
        $villageChurch = $row['church'];
        $villageWall = $row['wall'];
        $villageWonder = $row['wonder'];
        $villageFarm = $row['farm'];
        $villageHouse = $row['house'];

        $villagePoints = ($villageHQ * 40) + ($villageWood * 15) + ($villageIron * 12) + ($villageClay * 18)
            + ($villageChurch * 6) + ($villageWall * 15) + ($villageWonder * 1000) + ($villageFarm * 11)
            + ($villageHouse * 22);

        $updatePoints = "UPDATE village SET points  = '$villagePoints'  WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $updatePoints);
    }

    function updateResources($woodCost, $clayCost, $ironCost)
    {
        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $user_id = $_SESSION['userID'];
        $sql = "UPDATE village SET amount_wood  = amount_wood - '$woodCost', amount_clay = 
  amount_clay - '$clayCost', amount_iron = amount_iron - '$ironCost' WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $sql);
    }

    if (isset($_POST['addResources'])) {

        $user_id = $_SESSION['userID'];

        $mysqli = new mysqli('localhost', 'root', '18james18', 'login');

        $sql = "SELECT * FROM village WHERE user_id = '$user_id'";


        $Result = $mysqli->query($sql);
        $row = mysqli_fetch_array($Result);

        $villageWood = $row['wood'];
        $villageIron = $row['iron'];
        $villageClay = $row['clay'];
        $countWood = $row['amount_wood'];
        $countIron = $row['amount_iron'];
        $countClay = $row['amount_clay'];

        $countWood += 100 * $villageWood;
        $countIron += 70 * $villageIron;
        $countClay += 50 * $villageClay;

        $updateResources = "UPDATE village SET amount_wood  = '$countWood', amount_iron = '$countIron',
          amount_clay = '$countClay' WHERE user_id = '$user_id'";

        mysqli_query($mysqli, $updateResources);

    }

if(isset($_POST['acceptTrade']))
{
    $tradeID = $_POST['acceptTrade'];

    $user_id = $_SESSION['userID'];

    $sql = "SELECT * FROM trade WHERE id = '$tradeID'";

    $Result = $mysqli->query($sql);
    $row = mysqli_fetch_array($Result);

    $amountRecieve = $row['recieve'];    //5000 wood
    $resourceWant = $row['resourceWant']; //resource wood

    $amountOffer = $row['offer'];       //1000 clay
    $resourceOffer = $row['resourceOffer']; //resource is clay

    $traderID = $row['idUser_createdIndex'];

    if($user_id == $traderID)
    {
        echo "Cannot trade with yourself";
    }
    else {

        $sql2 = "SELECT * FROM village WHERE user_id = '$user_id'";
        $Result = $mysqli->query($sql2);
        $row = mysqli_fetch_array($Result);

        $wood = $row['amount_wood'];
        $clay = $row['amount_clay'];
        $iron = $row['amount_iron'];

        if ($resourceWant == 'wood' && $wood < $amountRecieve) {
            echo "Not enough resources to make that trade";
        } else if ($resourceWant == 'clay' && $clay < $amountRecieve) {
            echo "Not enough resources to make that trade";
        } else if ($resourceWant == 'iron' && $iron < $amountRecieve) {
            echo "Not enough resources to make that trade";
        } else {

            $mysqli = new mysqli('localhost', 'root', '18james18', 'login');


            if($resourceWant == 'wood')
            {
                $deductTradeAcceptor = "UPDATE village SET amount_wood = amount_wood - '$amountRecieve' WHERE user_id = '$user_id'";
                mysqli_query($mysqli, $deductTradeAcceptor);
                $addTradeCreator = "UPDATE village SET amount_wood = amount_wood + '$amountRecieve' WHERE user_id = '$traderID'";
                mysqli_query($mysqli, $addTradeCreator);
            }
            else if($resourceWant == 'clay')
            {
                $deductTradeAcceptor = "UPDATE village SET amount_clay = amount_clay - '$amountRecieve' WHERE user_id = '$user_id'";
                mysqli_query($mysqli, $deductTradeAcceptor);
                $addTradeCreator = "UPDATE village SET amount_clay = amount_clay + '$amountRecieve' WHERE user_id = '$traderID'";
                mysqli_query($mysqli, $addTradeCreator);


            }
            else if($resourceWant == 'iron')
            {
                $deductTradeAcceptor = "UPDATE village SET amount_iron = amount_iron - '$amountRecieve' WHERE user_id = '$user_id'";
                mysqli_query($mysqli, $deductTradeAcceptor);
                $addTradeCreator = "UPDATE village SET amount_iron = amount_iron + '$amountRecieve' WHERE user_id = '$traderID'";
                mysqli_query($mysqli, $addTradeCreator);
            }

            if($resourceOffer == 'wood')
            {
                $deductTradeCreator = "UPDATE village SET amount_wood = amount_wood - '$amountOffer' WHERE user_id = '$traderID'";
                mysqli_query($mysqli, $deductTradeCreatorr);
                $addTradeAcceptor = "UPDATE village SET amount_wood = amount_wood + '$amountOffer' WHERE user_id = '$user_id'";
                mysqli_query($mysqli, $addTradeAcceptor);

            }
            else if($resourceOffer == 'clay') {

                $deductTradeCreator = "UPDATE village SET amount_clay = amount_clay - '$amountOffer' WHERE user_id = '$traderID'";
                mysqli_query($mysqli, $deductTradeCreator);
                $addTradeAcceptor = "UPDATE village SET amount_clay = amount_clay + '$amountOffer' WHERE user_id = '$user_id'";
                mysqli_query($mysqli, $addTradeAcceptor);

            }
             else if($resourceOffer == 'iron')
            {
                $deductTradeCreator = "UPDATE village SET amount_iron = amount_iron - '$amountOffer' WHERE user_id = '$traderID'";
                mysqli_query($mysqli, $deductTradeCreatorr);
                $addTradeAcceptor = "UPDATE village SET amount_iron = amount_iron + '$amountOffer' WHERE user_id = '$user_id'";
                mysqli_query($mysqli, $addTradeAcceptor);


            }

            //$updatePoints = "UPDATE village SET points  = '$villagePoints'  WHERE user_id = '$user_id'";


        }
    }
}



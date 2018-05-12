<?php
//retrieve login details from login.php;
session_start();


$mysqli = new mysqli('localhost', 'root', '18james18', 'login');

if ($mysqli->connect_error) {
    echo "No working :((( ";
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}



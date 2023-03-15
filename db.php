<?php

$mysqli = new mysqli("localhost", "root", "root", "flag-game");

/* check connection */
if (mysqli_connect_errno()) {
   printf("Connect failed: %s\n", mysqli_connect_error());
   exit();
}

require_once("Stat.php");
$staty = [];

 /* Select queries return a resultset */
 if ($result = $mysqli->query("SELECT * FROM vlajky")) {
   
    while ($row = $result->fetch_assoc()) {
        array_push($staty, new Stat($row["id"], $row["stat"],$row["obrazek"]));
    }
 }

/* close connection */
$mysqli->close();

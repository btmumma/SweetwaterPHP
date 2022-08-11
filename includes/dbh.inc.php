<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "sweetwatertable";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

// Connection string class.
// dbh.inc.php = Database Helper Include 
// Storing the connection string and mysqli connection in here so it doesn't bloat up index
// mysqli_connect connects to mysql db sweetwatertable stored on http://localhost/phpmyadmin/index.php?route=/database/structure&db=sweetwatertable
// created table sweetwater_test with given SQL command 
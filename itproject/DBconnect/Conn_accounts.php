<?php
require("accounts.php");  // first

$sql = "CREATE DATABASE IF NOT EXISTS accountsdb";
$query = mysqli_query($conn, $sql);

// if ($query) {
//     echo "Database is created." ;
// } else {
//     echo "Error creating database.";
// }
?>

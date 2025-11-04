<?php
$servername = "localhost";
$username = "u240504_kapperwebshop";
$password = "Wnn9H9E77vDUe4gZVMbp";
$dbname = "u240504_kapperwebshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>

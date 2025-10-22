<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id > 0){
    $sql = "DELETE FROM behandelingen WHERE id=$id";
    if($conn->query($sql)){
        header("Location: behandelingen_overzicht.php");
        exit;
    } else {
        echo "Fout bij verwijderen: " . $conn->error;
    }
} else {
    echo "Geen geldig ID opgegeven.";
}
?>

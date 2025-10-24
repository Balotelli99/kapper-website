<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Haal gegevens van teamlid op
$result = $conn->query("SELECT * FROM team WHERE id = $id");
$row = $result->fetch_assoc();

$message = "";


if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $functie = $_POST['functie'];
    $beschrijving = $_POST['beschrijving'];

    $conn->query("UPDATE team SET naam='$naam', functie='$functie', beschrijving='$beschrijving' WHERE id=$id");
    $message = "Teamlid is bijgewerkt!";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerk Teamlid</title>
</head>
<body>
<h1>Bewerk Teamlid</h1>
<p style="color:green;"><?php echo $message; ?></p>

<form method="POST">
    Naam: <br>
    <input type="text" name="naam" value="<?php echo $row['naam']; ?>"><br><br>

    Functie: <br>
    <input type="text" name="functie" value="<?php echo $row['functie']; ?>"><br><br>

    Beschrijving: <br>
    <textarea name="beschrijving"><?php echo $row['beschrijving']; ?></textarea><br><br>

    <input type="submit" name="opslaan" value="Opslaan">
</form>

<br>
<a href="team_overzicht.php">Terug naar overzicht</a>
</body>
</html>

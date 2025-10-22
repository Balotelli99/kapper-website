<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = $conn->query("SELECT * FROM behandelingen WHERE id=$id");
$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];

    $conn->query("UPDATE behandelingen SET naam='$naam', beschrijving='$beschrijving', prijs='$prijs' WHERE id=$id");
    $message = "Behandeling is bijgewerkt!";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerk Behandeling</title>
</head>
<body>
<h1>Bewerk Behandeling</h1>
<p style="color:green;"><?php echo $message; ?></p>

<form method="POST">
    Naam: <br>
    <input type="text" name="naam" value="<?php echo $row['naam']; ?>"><br><br>

    Beschrijving: <br>
    <textarea name="beschrijving"><?php echo $row['beschrijving']; ?></textarea><br><br>

    Prijs: <br>
    <input type="number" step="0.01" name="prijs" value="<?php echo $row['prijs']; ?>"><br><br>

    <input type="submit" name="opslaan" value="Opslaan">
</form>

<br>
<a href="behandelingen_overzicht.php">Terug naar overzicht</a>
</body>
</html>

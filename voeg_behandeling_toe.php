<?php
session_start();
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

include 'db_connect.php';
$message = '';

if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];

    $sql = "INSERT INTO behandelingen (naam, beschrijving, prijs) 
            VALUES ('$naam', '$beschrijving', '$prijs')";

    if ($conn->query($sql) === TRUE) {
        $message = "<p style='color:green;'>Behandeling toegevoegd!</p>";
    } else {
        $message = "<p style='color:red;'>Fout bij toevoegen: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Nieuwe Behandeling Toevoegen</title>
  <link rel="stylesheet" href="style/bewerkbehandeling.css">
</head>
<body>
    <h2>Nieuwe Behandeling Toevoegen</h2>

    <a href="behandelingen_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <div class="form-container">
        <form method="POST">
 <input type="text" name="naam" placeholder="Naam" required>
 <textarea name="beschrijving" placeholder="Beschrijving" required></textarea>
 <input type="number" step="0.01" name="prijs" placeholder="Prijs" required>
<button type="submit" name="opslaan">Opslaan</button>
 </form>
        <?= $message ?>
    </div>
</body>
</html>

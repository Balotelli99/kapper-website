<?php
session_start();
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}
include 'db_connect.php';

$message = '';

if(isset($_POST['opslaan'])){
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];

    $stmt = $conn->prepare("INSERT INTO behandelingen (naam, beschrijving, prijs) VALUES (?,?,?)");
    $stmt->bind_param("ssd", $naam, $beschrijving, $prijs);

    if($stmt->execute()){
        $message = "<p style='color:green;'>Behandeling toegevoegd!</p>";
    } else {
        $message = "<p style='color:red;'>Fout bij toevoegen!</p>";
    }
}
?>
<head>
  <meta charset="UTF-8">
  <title>Team Overzicht</title>
  <link rel="stylesheet" href="style/voegbehandeling.css">
</head>

<h2>Nieuwe Behandeling Toevoegen</h2>
<form method="POST">
    <input type="text" name="naam" placeholder="Naam" required><br>
    <textarea name="beschrijving" placeholder="Beschrijving" required></textarea><br>
    <input type="number" step="0.01" name="prijs" placeholder="Prijs" required><br>
    <button type="submit" name="opslaan">Opslaan</button>
</form>

<?= $message ?>

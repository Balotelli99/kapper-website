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
    $functie = $_POST['functie'];
    $beschrijving = $_POST['beschrijving'];
    $foto = $_POST['foto']; // Voeg foto toe

   $sql = "INSERT INTO team (naam, functie, beschrijving, foto) 
        VALUES ('$naam', '$functie', '$beschrijving', '$foto')";

if ($conn->query($sql)) {
    $message = "<p style='color:green;'>Teamlid toegevoegd!</p>";
} else {
    $message = "<p style='color:red;'>Fout bij toevoegen!</p>";
}

}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuw Teamlid Toevoegen</title>
    <link rel="stylesheet" href="style/bewerkbehandeling.css">
</head>
<body>
    <h2>Nieuw Teamlid Toevoegen</h2>

    <a href="team_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <div class="form-container">
        <form method="POST">
<label for="naam">Naam:</label>
 <input type="text" id="naam" name="naam" placeholder="Naam" required>

 <label for="functie">Functie:</label>
 <input type="text" id="functie" name="functie" placeholder="Functie" required>

  <label for="beschrijving">Beschrijving:</label>
 <textarea id="beschrijving" name="beschrijving" placeholder="Beschrijving" required></textarea>

  <label for="foto">Foto (typ alleen bestandsnaam, bijv. 'ronaldo.png'):</label>
  <input type="text" id="foto" name="foto" placeholder="ronaldo.png">

 <button type="submit" name="opslaan">Opslaan</button>
</form>

        <?= $message ?>
    </div>
</body>
</html>

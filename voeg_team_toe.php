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

    $stmt = $conn->prepare("INSERT INTO team (naam, functie, beschrijving) VALUES (?,?,?)");
    $stmt->bind_param("sss", $naam, $functie, $beschrijving);

    if($stmt->execute()){
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
    <link rel="stylesheet" href="style/bewerkbehandeling.css"> <!-- Zelfde CSS als bewerk formulier -->
</head>
<body>
    <h2>Nieuw Teamlid Toevoegen</h2>

    <!-- Terug knop -->
    <a href="team_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <!-- Formulier container -->
    <div class="form-container">
        <form method="POST">
            <!-- Naam -->
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" placeholder="Naam" required>

            <!-- Functie -->
            <label for="functie">Functie:</label>
            <input type="text" id="functie" name="functie" placeholder="Functie" required>

            <!-- Beschrijving -->
            <label for="beschrijving">Beschrijving:</label>
            <textarea id="beschrijving" name="beschrijving" placeholder="Beschrijving" required></textarea>

            <!-- Opslaan knop -->
            <button type="submit" name="opslaan">Opslaan</button>
        </form>

        <!-- Bericht -->
        <?= $message ?>
    </div>
</body>
</html>

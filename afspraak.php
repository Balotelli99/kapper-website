<?php
session_start();
include 'db_connect.php';

if(isset($_POST['verstuur'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $behandeling_id = $_POST['behandeling_id'];
    $team_id = $_POST['team_id'];
    $datumtijd = str_replace("T", " ", $_POST['datumtijd']); // T omzetten naar spatie


    if($conn->query("INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum) 
                     VALUES ('$behandeling_id','$team_id','$naam','$email','$datumtijd')")) {
        $melding = "<p class='success'>Afspraak succesvol gemaakt!</p>";
    } else {
        $melding = "<p class='error'>Er ging iets mis.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Maak Afspraak - Sultan's Hairstyles</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/afspraak.css">
</head>
<body>

<main class="afspraak-sectie">
    <h1>Maak een Afspraak</h1>
    <p class="intro">Vul hieronder je gegevens in om een afspraak te maken.</p>

    <?= $melding ?? '' ?>

    <form method="POST">
        <input type="text" name="naam" placeholder="Bijv. Jan Jansen" required>
        <input type="email" name="email" placeholder="janjansen@example.com" required>

        <select name="behandeling_id" required>
            <option value="">Kies een behandeling</option>
            <option value="1">Knippen - €25</option>
            <option value="2">Kleuren - €20</option>
            <option value="3">Baard Treatment - €15</option>
        </select>

        <select name="team_id" required>
            <option value="">Kies een kapper</option>
            <option value="1">Ronaldo</option>
            <option value="4">Neymar</option>
            <option value="14">Corleone</option>
        </select>

        <input type="datetime-local" name="datumtijd" required>

        <button type="submit" name="verstuur">Afspraak Bevestigen</button>
    </form>

    <a href="index.php" class="terug-btn">← Terug naar hoofdpagina</a>
</main>

</body>
</html>

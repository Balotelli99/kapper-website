<?php
session_start();
include 'db_connect.php';

// Formulier verwerken
if(isset($_POST['verstuur'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $behandeling_id = $_POST['behandeling_id'];
    $team_id = $_POST['team_id'];
    $datumtijd = $_POST['datumtijd']; // Datum en tijd samen
    $datumtijd = str_replace("T", " ", $datumtijd); // Zet T om naar spatie voor MySQL DATETIME

    $stmt = $conn->prepare("INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $behandeling_id, $team_id, $naam, $email, $datumtijd);

    if($stmt->execute()) {
        $success = "Afspraak succesvol gemaakt!";
    } else {
        $error = "Er ging iets mis. Probeer het opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maak Afspraak - Sultan's Hairstyles</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/afspraak.css">
</head>
<body>

<main class="afspraak-sectie">
    <h1>Maak een Afspraak</h1>
    <p class="intro">Vul hieronder je gegevens in om een afspraak te maken.</p>

    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" placeholder="Bijv. Jan Jansen" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="janjansen@example.com" required>

        <label for="behandeling_id">Behandeling:</label>
        <select id="behandeling_id" name="behandeling_id" required>
            <option value="">Kies een behandeling</option>
            <option value="1">Knippen - €25</option>
            <option value="2">Kleuren - €20</option>
            <option value="3">Baard Treatment - €15</option>
        </select>

        <label for="team_id">Teamlid:</label>
        <select id="team_id" name="team_id" required>
            <option value="">Kies een kapper</option>
            <option value="1">Ronaldo</option>
            <option value="4">Neymar</option>
            <option value="5">Corleone</option>
        </select>

        <label for="datumtijd">Datum en Tijd:</label>
        <input type="datetime-local" id="datumtijd" name="datumtijd" required>

        <button type="submit" name="verstuur">Afspraak Bevestigen</button>
    </form>

    <a href="index.php" class="terug-btn">← Terug naar hoofdpagina</a>
</main>

</body>
</html>

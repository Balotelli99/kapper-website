<?php
session_start();

// Databaseverbinding
$conn = new mysqli("localhost", "root", "", "kapperwebshop");
if ($conn->connect_error) die("Verbinding mislukt: " . $conn->connect_error);

$melding = "";

// Formulier verwerken
if(isset($_POST['verstuur'])) {
    $naam = $conn->real_escape_string($_POST['naam']);
    $email = $conn->real_escape_string($_POST['email']);
    $behandeling_id = (int)$_POST['behandeling_id'];
    $team_id = (int)$_POST['team_id'];
    $datumtijd = str_replace("T", " ", $_POST['datumtijd']);

    // Controleer of behandeling en teamlid bestaan
    $check_behandeling = $conn->query("SELECT id FROM behandelingen WHERE id = $behandeling_id");
    $check_team = $conn->query("SELECT id FROM team WHERE id = $team_id");

    if($check_behandeling->num_rows > 0 && $check_team->num_rows > 0) {
        $sql = "INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum)
                VALUES ('$behandeling_id', '$team_id', '$naam', '$email', '$datumtijd')";
        if($conn->query($sql)) {
            $melding = "<p class='success'>Afspraak succesvol gemaakt!</p>";
        } else {
            $melding = "<p class='error'>Er ging iets mis bij het opslaan: " . $conn->error . "</p>";
        }
    } else {
        $melding = "<p class='error'>Ongeldige behandeling of kapper gekozen.</p>";
    }
}

// Lijsten ophalen voor dropdowns
$behandelingen = $conn->query("SELECT id, naam, prijs FROM behandelingen ORDER BY naam ASC");
$teamleden = $conn->query("SELECT id, naam FROM team ORDER BY naam ASC");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Maak Afspraak - Sultan's Hairstyles</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/afspraak.css">
</head>
<body>

<div class="afspraak-sectie">
    <h1>Maak een Afspraak</h1>
    <p class="intro">Vul hieronder je gegevens in om een afspraak te maken.</p>

    <?= $melding ?>

    <form method="POST">
        <label>Naam:</label>
        <input type="text" name="naam" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Behandeling:</label>
        <select name="behandeling_id" required>
            <option value="">Kies een behandeling</option>
            <?php while($b = $behandelingen->fetch_assoc()): ?>
                <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['naam']) ?> - €<?= $b['prijs'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Kapper:</label>
        <select name="team_id" required>
            <option value="">Kies een kapper</option>
            <?php while($t = $teamleden->fetch_assoc()): ?>
                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['naam']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Datum en tijd:</label>
        <input type="datetime-local" name="datumtijd" required>

        <button type="submit" name="verstuur">Afspraak Bevestigen</button>
    </form>

    <a href="index.php" class="terug-btn">← Terug naar hoofdpagina</a>
</div>

</body>
</html>

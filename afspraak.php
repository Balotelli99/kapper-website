<?php
session_start();
include 'db_connect.php';

// Formulier verwerken
if(isset($_POST['verstuur'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $behandeling_id = $_POST['behandeling_id'];
    $team_id = $_POST['team_id'];
    $datum = $_POST['datum'];

    $stmt = $conn->prepare("INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $behandeling_id, $team_id, $naam, $email, $datum);

    if($stmt->execute()) {
        $success = "✅ Afspraak succesvol gemaakt!";
    } else {
        $error = "❌ Er ging iets mis. Probeer het opnieuw.";
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

<header>
    <nav>
        <a href="index.html">Home</a>
        <a href="afspraak.php" class="active">Afspraak</a>
        <a href="team.html">Het Team</a>
        <a href="#">Kosten</a>
        <a href="producten.html">Producten</a>
        <a href="#">Contact</a>
    </nav>
</header>

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

        <label for="datum">Datum:</label>
        <input type="date" id="datum" name="datum" required>

        <button type="submit" name="verstuur">Afspraak Bevestigen</button>
    </form>

    <a href="index.php" class="terug-btn">← Terug naar hoofdpagina</a>
</main>

<footer>
    <h3>Openingstijden</h3>
    <p>
        Maandag: 09:30 - 18:00<br>
        Dinsdag: 09:30 - 18:00<br>
        Donderdag: 09:30 - 18:00<br>
        Vrijdag: 09:30 - 20:00<br>
        Zaterdag: 12:00 - 17:00
    </p>

    <h3>Contact</h3>
    <p>
        Telefoon: 0123-456789<br>
        Email: info@perfectcut.nl<br>
        Adres: Hoofdstraat 123, 1234 AB Stad
    </p>

    <p class="footer-bottom">© 2025 Kapsalon Perfect Cut. Alle rechten voorbehouden.</p>
</footer>

</body>
</html>

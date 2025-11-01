<?php
session_start();
include 'db_connect.php';

// ID van het teamlid uit de URL halen
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo "Ongeldig teamlid ID.";
    exit;
}

// Teamlid ophalen uit de database
$stmt = $conn->prepare("SELECT * FROM team WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$lid = $result->fetch_assoc();

if (!$lid) {
    echo "Teamlid niet gevonden.";
    exit;
}

// Formulier verwerken
if (isset($_POST['verstuur'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $datumtijd = $_POST['datumtijd'];
    $datumtijd = str_replace("T", " ", $datumtijd); // Voor MySQL DATETIME

    // Verondersteld dat je ook een kolom team_id hebt in afspraken
    $stmt2 = $conn->prepare("INSERT INTO afspraken (team_id, naam, email, datum) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("isss", $id, $naam, $email, $datumtijd);

    if ($stmt2->execute()) {
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
    <title><?= htmlspecialchars($lid['naam']) ?> - Sultan's Hairstyles</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/afspraak.css">
</head>
<body>

<main class="afspraak-sectie">
    <h1><?= htmlspecialchars($lid['naam']) ?></h1>
    <h2><?= htmlspecialchars($lid['functie']) ?></h2>
    <?php if(!empty($lid['foto'])): ?>
        <img src="<?= htmlspecialchars($lid['foto']) ?>" alt="Foto van <?= htmlspecialchars($lid['naam']) ?>" style="width:200px; border-radius:10px;">
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($lid['beschrijving'])) ?></p>

    <hr>
    <h2>Maak een afspraak met <?= htmlspecialchars($lid['naam']) ?></h2>
    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" placeholder="Bijv. Jan Jansen" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="janjansen@example.com" required>

        <label for="datumtijd">Datum en Tijd:</label>
        <input type="datetime-local" id="datumtijd" name="datumtijd" required>

        <button type="submit" name="verstuur">Afspraak Bevestigen</button>
    </form>

    <a href="index.php" class="terug-btn">← Terug naar hoofdpagina</a>
</main>

</body>
</html>

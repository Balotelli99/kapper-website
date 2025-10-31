<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Haal gegevens van teamlid op
$result = $conn->query("SELECT * FROM team WHERE id = $id");
$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $functie = $_POST['functie'];
    $beschrijving = $_POST['beschrijving'];

    $stmt = $conn->prepare("UPDATE team SET naam=?, functie=?, beschrijving=? WHERE id=?");
    $stmt->bind_param("sssi", $naam, $functie, $beschrijving, $id);
    if($stmt->execute()) {
        $message = "<p style='color:green;'>Teamlid is bijgewerkt!</p>";
    } else {
        $message = "<p style='color:red;'>Fout bij bijwerken!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerk Teamlid</title>
    <link rel="stylesheet" href="style/bewerkbehandeling.css"> <!-- Zelfde CSS als nieuwe behandeling -->
</head>
<body>
    <h2>Bewerk Teamlid</h2>

    <!-- Terug knop -->
    <a href="team_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <!-- Formulier container -->
    <div class="form-container">
        <form method="POST">
            <!-- Naam -->
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($row['naam']) ?>" required>

            <!-- Functie -->
            <label for="functie">Functie:</label>
            <input type="text" id="functie" name="functie" value="<?= htmlspecialchars($row['functie']) ?>" required>

            <!-- Beschrijving -->
            <label for="beschrijving">Beschrijving:</label>
            <textarea id="beschrijving" name="beschrijving" required><?= htmlspecialchars($row['beschrijving']) ?></textarea>

            <!-- Opslaan knop -->
            <button type="submit" name="opslaan">Opslaan</button>
        </form>

        <!-- Bericht -->
        <?= $message ?>
    </div>
</body>
</html>

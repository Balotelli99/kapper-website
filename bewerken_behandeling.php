<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

// Behandeling-ID ophalen
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Behandeling uit database halen
$result = $conn->query("SELECT * FROM behandelingen WHERE id = $id");
$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];

    $stmt = $conn->prepare("UPDATE behandelingen SET naam=?, beschrijving=?, prijs=? WHERE id=?");
    $stmt->bind_param("ssdi", $naam, $beschrijving, $prijs, $id);

    if($stmt->execute()) {
        $message = "<p style='color:green;'>Behandeling is bijgewerkt!</p>";
    } else {
        $message = "<p style='color:red;'>Fout bij bijwerken!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerk Behandeling</title>
    <link rel="stylesheet" href="style/bewerkbehandeling.css"> <!-- Zelfde stijl als nieuwe behandeling -->
</head>
<body>
    <h2>Bewerk Behandeling</h2>

    <!-- Terug knop -->
    <a href="behandelingen_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <!-- Formulier container -->
    <div class="form-container">
        <form method="POST">
            <!-- Naam -->
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($row['naam']) ?>" required>

            <!-- Beschrijving -->
            <label for="beschrijving">Beschrijving:</label>
            <textarea id="beschrijving" name="beschrijving" required><?= htmlspecialchars($row['beschrijving']) ?></textarea>

            <!-- Prijs -->
            <label for="prijs">Prijs (€):</label>
            <input type="number" id="prijs" name="prijs" step="0.01" value="<?= htmlspecialchars($row['prijs']) ?>" required>

            <!-- Opslaan knop -->
            <button type="submit" name="opslaan">Opslaan</button>
        </form>

        <!-- Bericht -->
        <?= $message ?>
    </div>
</body>
</html>

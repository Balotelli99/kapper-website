<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$id = $_GET['id'] ?? 0;
if(!$id) die("Geen geldig ID.");


$row = $conn->query("SELECT * FROM behandelingen WHERE id=$id")->fetch_assoc();
if(!$row) die("Behandeling niet gevonden.");

$message = "";

if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];

    if($conn->query("UPDATE behandelingen SET naam='$naam', beschrijving='$beschrijving', prijs='$prijs' WHERE id=$id")) {
        $message = "<p style='color:green;'>Behandeling is bijgewerkt!</p>";
        $row['naam'] = $naam;
        $row['beschrijving'] = $beschrijving;
        $row['prijs'] = $prijs;
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
    <link rel="stylesheet" href="style/bewerkbehandeling.css">
</head>
<body>
    <h2>Bewerk Behandeling</h2>
    <a href="behandelingen_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <div class="form-container">
        <form method="POST">
<label>Naam:</label>
  <input type="text" name="naam" value="<?= $row['naam'] ?>" required>

  <label>Beschrijving:</label>
 <textarea name="beschrijving" required><?= $row['beschrijving'] ?></textarea>

  <label>Prijs (€):</label>
 <input type="number" name="prijs" step="0.01" value="<?= $row['prijs'] ?>" required>

  <button type="submit" name="opslaan">Opslaan</button>
</form>

        <?= $message ?>
    </div>
</body>
</html>

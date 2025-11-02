<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$id = $_GET['id'] ?? 0;
if(!$id) die("Geen geldig teamlid.");


$row = $conn->query("SELECT * FROM team WHERE id=$id")->fetch_assoc();
if(!$row) die("Teamlid niet gevonden.");

$message = "";

if(isset($_POST['opslaan'])) {
    $naam = $_POST['naam'];
    $functie = $_POST['functie'];
    $beschrijving = $_POST['beschrijving'];
    $foto = $_POST['foto'];

    if($conn->query("UPDATE team SET naam='$naam', functie='$functie', beschrijving='$beschrijving', foto='$foto' WHERE id=$id")) {
        $message = "<p style='color:green;'>Teamlid is bijgewerkt!</p>";
      
        $row['naam'] = $naam;
        $row['functie'] = $functie;
        $row['beschrijving'] = $beschrijving;
        $row['foto'] = $foto;
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
    <link rel="stylesheet" href="style/bewerkbehandeling.css">
</head>
<body>
    <h2>Bewerk Teamlid</h2>
    <a href="team_overzicht.php" class="toevoegen-btn">← Terug naar overzicht</a>

    <div class="form-container">
        <form method="POST">
            <label>Naam:</label>
            <input type="text" name="naam" value="<?= $row['naam'] ?>" required>

            <label>Functie:</label>
            <input type="text" name="functie" value="<?= $row['functie'] ?>" required>

            <label>Beschrijving:</label>
            <textarea name="beschrijving" required><?= $row['beschrijving'] ?></textarea>

            <label>Foto (bijv. 'ronaldo.png'):</label>
            <input type="text" name="foto" value="<?= $row['foto'] ?>">

            <?php if(!empty($row['foto'])): ?>
                <p>Huidige afbeelding:</p>
                <img src="<?= $row['foto'] ?>" alt="Foto van <?= $row['naam'] ?>" style="width:150px; border-radius:5px;">
            <?php endif; ?>

            <button type="submit" name="opslaan">Opslaan</button>
        </form>

        <?= $message ?>
    </div>
</body>
</html>

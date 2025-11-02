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
    $foto = $_POST['foto']; // nieuwe veld voor afbeelding

    $stmt = $conn->prepare("UPDATE team SET naam=?, functie=?, beschrijving=?, foto=? WHERE id=?");
    $stmt->bind_param("ssssi", $naam, $functie, $beschrijving, $foto, $id);

    if($stmt->execute()) {
        $message = "<p style='color:green;'>Teamlid is bijgewerkt!</p>";
        // Update $row zodat formulier de nieuwe waarden toont
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
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($row['naam']) ?>" required>

            <label for="functie">Functie:</label>
            <input type="text" id="functie" name="functie" value="<?= htmlspecialchars($row['functie']) ?>" required>

            <label for="beschrijving">Beschrijving:</label>
            <textarea id="beschrijving" name="beschrijving" required><?= htmlspecialchars($row['beschrijving']) ?></textarea>

            <label for="foto">Foto (bijv. 'ronaldo.png'):</label>
            <input type="text" id="foto" name="foto" value="<?= htmlspecialchars($row['foto']) ?>">

            <?php if(!empty($row['foto'])): ?>
                <p>Huidige afbeelding:</p>
                <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto van <?= htmlspecialchars($row['naam']) ?>" style="width:150px; border-radius:5px;">
            <?php endif; ?>

            <button type="submit" name="opslaan">Opslaan</button>
        </form>

        <?= $message ?>
    </div>
</body>
</html>

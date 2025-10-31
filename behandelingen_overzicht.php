<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';
$result = $conn->query("SELECT * FROM behandelingen ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Behandelingen Overzicht</title>
    <link rel="stylesheet" href="style/behandeloverzicht.css">
</head>
<body>
    <h1>Behandelingen Overzicht</h1>
    <a href="voeg_behandeling_toe.php" class="toevoegen-btn">Nieuwe Behandeling Toevoegen</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Prijs</th>
            <th>Foto</th>
            <th>Acties</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID"><?= $row['id'] ?></td>
                    <td data-label="Naam"><?= htmlspecialchars($row['naam']) ?></td>
                    <td data-label="Beschrijving"><?= htmlspecialchars($row['beschrijving']) ?></td>
                    <td data-label="Prijs">€<?= htmlspecialchars($row['prijs']) ?></td>
                    <td data-label="Foto">
                        <?php if($row['afbeelding']): ?>
                            <img src="<?= htmlspecialchars($row['afbeelding']) ?>" alt="Foto van <?= htmlspecialchars($row['naam']) ?>">
                        <?php else: ?>
                            Geen foto
                        <?php endif; ?>
                    </td>
                    <td data-label="Acties">
                        <a href="bewerken_behandeling.php?id=<?= $row['id'] ?>">Bewerken</a>
                        <a href="verwijder_behandeling.php?id=<?= $row['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Geen behandelingen gevonden.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

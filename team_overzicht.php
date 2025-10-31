<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';
$result = $conn->query("SELECT * FROM team ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Team Overzicht</title>
    <link rel="stylesheet" href="style/teamoverzicht.css">
</head>

<body>
    <h1>Team Overzicht</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Functie</th>
                <th>Beschrijving</th>
                <th>Foto</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['naam']) ?></td>
                        <td><?= htmlspecialchars($row['functie']) ?></td>
                        <td><?= htmlspecialchars($row['beschrijving']) ?></td>
                        <td>
                            <?php if (!empty($row['foto'])): ?>
                                <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto van <?= htmlspecialchars($row['naam']) ?>">
                            <?php else: ?>
                                <span class="geen-foto">Geen foto</span>
                            <?php endif; ?>
                        </td>
                        <td class="acties">
                            <a href="bewerken_team.php?id=<?= $row['id'] ?>" class="edit-btn">Bewerken</a>
                            <a href="verwijder_team.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Weet je zeker dat je dit teamlid wilt verwijderen?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Geen teamleden gevonden.</td></tr>
            <?php endif; ?>

            <!-- Extra rij met knoppen onderaan -->
            <tr class="table-footer">
                <td colspan="6" class="footer-actions">
                    <a href="voeg_team_toe.php" class="add-btn">+ Nieuw teamlid toevoegen</a>
                    <a href="kiezen.php" class="back-btn">← Terug naar kiezen pagina</a>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>

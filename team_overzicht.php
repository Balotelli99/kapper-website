<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';
$result = $conn->query("SELECT * FROM team ORDER BY id ASC");
?>

<head>
  <meta charset="UTF-8">
  <title>Team Overzicht</title>
  <link rel="stylesheet" href="style/team.css">
</head>

<body>
    <h1>Team Overzicht</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Functie</th>
            <th>Beschrijving</th>
            <th>Foto</th>
            <th>Acties</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID"><?= $row['id'] ?></td>
                    <td data-label="Naam"><?= htmlspecialchars($row['naam']) ?></td>
                    <td data-label="Functie"><?= htmlspecialchars($row['functie']) ?></td>
                    <td data-label="Beschrijving"><?= htmlspecialchars($row['beschrijving']) ?></td>
                    <td data-label="Foto">
                        <?php if($row['foto']): ?>
                            <img src="<?= htmlspecialchars($row['foto']) ?>" width="80" alt="Foto van <?= htmlspecialchars($row['naam']) ?>">
                        <?php else: ?>
                            Geen foto
                        <?php endif; ?>
                    </td>
                    <td data-label="Acties">
                        <a href="bewerken_team.php?id=<?= $row['id'] ?>">Bewerken</a>
                        <a href="voeg_team_toe.php?id=<?= $row['id'] ?>">voeg toe</a>
                        <a href="verwijder_team.php?id=<?= $row['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Geen teamleden gevonden.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

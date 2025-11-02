<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';
$teamleden = $conn->query("SELECT * FROM team ORDER BY id ASC");
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
            <?php if($teamleden->num_rows > 0): ?>
                <?php while($lid = $teamleden->fetch_assoc()): ?>
                    <tr>
               <td><?= $lid['id'] ?></td>
             <td><?= $lid['naam'] ?></td>
           <td><?= $lid['functie'] ?></td>
           <td><?= $lid['beschrijving'] ?></td>
               <td>
           <?php if($lid['foto']): ?>
          <img src="<?= $lid['foto'] ?>" alt="Foto van <?= $lid['naam'] ?>">
           <?php else: ?>
                   Geen foto
             <?php endif; ?>
             </td>
                        <td>
                            <a href="bewerken_team.php?id=<?= $lid['id'] ?>">Bewerken</a>
                            <a href="verwijder_team.php?id=<?= $lid['id'] ?>" onclick="return confirm('Weet je zeker dat je dit teamlid wilt verwijderen?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Geen teamleden gevonden.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
         <td colspan="6">
          <a href="voeg_team_toe.php">+ Nieuw teamlid toevoegen</a>
          <a href="kiezen.php">← Terug naar kiezen pagina</a>
          </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

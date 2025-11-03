<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: login.php");

$servername = "localhost";
$username = "root";
$password = ""; // 
$dbname = "kapperwebshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
$rows = $conn->query("SELECT * FROM behandelingen ORDER BY id ASC");
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

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Beschrijving</th>
                <th>Prijs</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if($rows->num_rows): ?>
                <?php while($row = $rows->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['naam'] ?></td>
                        <td><?= $row['beschrijving'] ?></td>
                        <td>€<?= $row['prijs'] ?></td>
                        <td>
                            <a href="bewerken_behandeling.php?id=<?= $row['id'] ?>">Bewerken</a>
                            <a href="verwijder_behandeling.php?id=<?= $row['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Geen behandelingen gevonden.</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <a href="voeg_behandeling_toe.php">+ Nieuw behandeling toevoegen</a>
                    <a href="kiezen.php">← Terug naar kiezen pagina</a>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

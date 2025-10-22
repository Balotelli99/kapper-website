<?php
session_start();
if(!isset($_SESSION['user_id'])) {
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
</head>
<body>
<h1>Team Overzicht</h1>
<a href="voeg_team_toe.php">Nieuw Teamlid Toevoegen</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Naam</th>
        <th>Functie</th>
        <th>Beschrijving</th>
        <th>Foto</th>
        <th>Acties</th>
    </tr>

    <?php if ($result->num_rows > 0) { ?>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['naam']; ?></td>
                <td><?php echo $row['functie']; ?></td>
                <td><?php echo $row['beschrijving']; ?></td>
                <td>
                    <?php if($row['foto'] != "") { ?>
                        <img src="<?php echo $row['foto']; ?>" width="80">
                    <?php } else { ?>
                        Geen foto
                    <?php } ?>
                </td>
                <td>
                    <a href="bewerken_team.php?id=<?php echo $row['id']; ?>">Bewerken</a> |
                    <a href="verwijder_team.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>

                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="6">Geen teamleden gevonden.</td>
        </tr>
    <?php } ?>
</table>
</body>
</html>

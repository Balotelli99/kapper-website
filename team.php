<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; // 
$dbname = "kapperwebshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
if (!$id) die("Ongeldig teamlid ID.");


$lid = $conn->query("SELECT * FROM team WHERE id = $id")->fetch_assoc();
if (!$lid) die("Teamlid niet gevonden.");


$behandeling_naam = ($lid['naam'] == 'Ronaldo') ? 'Knippen' : (($lid['naam'] == 'Neymar') ? 'Kleuren' : 'Baard knippen');


$bh = $conn->query("SELECT * FROM behandelingen WHERE naam = '$behandeling_naam'")->fetch_assoc();


if (isset($_POST['verstuur'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $datum = str_replace("T", " ", $_POST['datumtijd']);


if ($conn->query("INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum)
                  VALUES ('{$bh['id']}', '$id', '$naam', '$email', '$datum')")) {
    echo "<span class='success'>Afspraak succesvol gemaakt!</span>";
} else {
    echo "<span class='error'>Er ging iets mis.</span>";
}


}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= $lid['naam'] ?> - Afspraak</title>
    <link rel="stylesheet" href="style/afspraak.css">
</head>
<body>

<main class="afspraak-sectie">
    <h1><?= $lid['naam'] ?></h1>
    <h2><?= $lid['functie'] ?></h2>
    <?php if($lid['foto']): ?>
        <img src="<?= $lid['foto'] ?>" alt="<?= $lid['naam'] ?>" style="width:200px;border-radius:10px;">
    <?php endif; ?>
    <p><?= $lid['beschrijving'] ?></p>

    <hr>
    <h2>Maak een afspraak met <?= $lid['naam'] ?></h2>
    <p>Behandeling: <?= $bh['naam'] ?> - €<?= $bh['prijs'] ?></p>

    <?= $msg ?? '' ?>

    <form method="POST">
        <input type="text" name="naam" placeholder="Naam" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="datetime-local" name="datumtijd" required>
        <button type="submit" name="verstuur">Bevestigen</button>
    </form>

    <a href="index.php" class="terug-btn">← Terug</a>
</main>

</body>
</html>
